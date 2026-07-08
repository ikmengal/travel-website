<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    validator, File, Log, DB
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{
    DestinationImage,
    Destination,
    Country,
    State,
    City
};

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('destinations-list');

        $title = 'Destinations';
        $countries = Country::orderBy('name')->get();
        $totalDestinations = Destination::count();
        $featuredDestinations = Destination::where('is_featured', true)->count();
        $popularDestinations = Destination::where('is_popular', true)->count();
        $activeDestinations = Destination::where('status', true)->count();
        if ($request->ajax() && $request->loaddata == "yes") {
            $query = Destination::with([
                    'country',
                    'state',
                    'city'
                ])
                ->withCount([
                    'tours',
                    'hotels'
                ]);
            if ($request->filled('country')) {
                $query->where('country_id', $request->country);
            }
            if ($request->status !== null && $request->status !== '') {
                $query->where('status', $request->status);
            }
            if ($request->featured !== null && $request->featured !== '') {
                $query->where('is_featured', $request->featured);
            }
            if (!empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('tagline', 'LIKE', "%{$search}%")
                        ->orWhereHas('country', function ($c) use ($search) {
                            $c->where('name', 'LIKE', "%{$search}%");
                        });
                });
            }

            return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($destination) {
                return view(
                    'admin.destinations.partials.checkbox',
                    compact('destination')
                )->render();
            })
            ->addColumn('image', function ($destination) {
                return view(
                    'admin.destinations.partials.image',
                    compact('destination')
                )->render();
            })
            ->addColumn('destination', function ($destination) {
                return view('admin.destinations.partials.destination', compact('destination'))->render();
            })
            ->addColumn('country', function ($destination) {
                return $destination->country
                    ? '<span class="badge bg-label-primary">'
                        .$destination->country->name.
                    '</span>'
                    : '-';
            })
            ->addColumn('tours', function ($destination) {
                return '<span class="badge bg-label-info">'
                    .$destination->tours_count.
                    '</span>';
            })
            ->addColumn('hotels', function ($destination) {
                return '<span class="badge bg-label-success">'
                    .$destination->hotels_count.
                    '</span>';
            })
            ->addColumn('featured', function ($destination) {
                return $destination->is_featured
                    ? '<span class="badge bg-success">Featured</span>'
                    : '<span class="badge bg-secondary">No</span>';
            })
            ->addColumn('popular', function ($destination) {
                return $destination->is_popular
                    ? '<span class="badge bg-warning">Popular</span>'
                    : '<span class="badge bg-secondary">No</span>';
            })
            ->addColumn('status', function ($destination) {
                return view('admin.destinations.partials.status',compact('destination'))->render();
            })
            ->editColumn('created_at', function ($destination) {
                return $destination->created_at
                    ->format('d M Y');
            })
            ->addColumn('action', function ($destination) {
                return view('admin.destinations.partials.action',compact('destination'))->render();
            })
            ->rawColumns([
                'checkbox',
                'image',
                'destination',
                'country',
                'tours',
                'hotels',
                'featured',
                'popular',
                'status',
                'action'
            ])
            ->make(true);
        }
        return view('admin.destinations.index', get_defined_vars());
    }

    public function create()
    {
        $this->authorize('destinations-create');

        $title = 'Create Destination';

        $countries = Country::where('status', 1)
            ->orderBy('name')
            ->get();

        return view('admin.destinations.create', compact(
            'title',
            'countries'
        ));
    }

    public function store(Request $request)
    {
        $this->authorize('destinations-create');

        $validator = Validator::make($request->all(), [
            'country_id'          => 'required|exists:countries,id',
            'state_id'            => 'nullable|exists:states,id',
            'city_id'             => 'nullable|exists:cities,id',

            'name'                => 'required|string|max:255|unique:destinations,name',
            'tagline'             => 'nullable|string|max:255',

            'short_description'   => 'nullable|string',
            'description'         => 'nullable|string',

            'featured_image'      => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'banner_image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            'gallery.*'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            'starting_price'      => 'required|numeric|min:0',

            'latitude'            => 'nullable|numeric',
            'longitude'           => 'nullable|numeric',

            'best_time_to_visit'  => 'nullable|string|max:255',

            'is_featured'         => 'nullable|boolean',
            'is_popular'          => 'nullable|boolean',
            'status'              => 'nullable|boolean',

            'sort_order'          => 'nullable|integer',

            'meta_title'          => 'nullable|max:255',
            'meta_description'    => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {

            // ------------------- Featured Image ------------------- //
            $featuredImage = null;
            if ($request->hasFile('featured_image')) {
                $file = $request->file('featured_image');
                $featuredImage = time().'_featured_'.Str::random(6).'.'.$file->getClientOriginalExtension();
                $file->move(
                    public_path('images/destinations'),
                    $featuredImage
                );
            }

            // ------------------- Banner Image ------------------- //
            $bannerImage = null;
            if ($request->hasFile('banner_image')) {
                $file = $request->file('banner_image');
                $bannerImage = time().'_banner_'.Str::random(6).'.'.$file->getClientOriginalExtension();
                $file->move(
                    public_path('images/destinations'),
                    $bannerImage
                );
            }

            // ------------------- Destination ------------------- //
            $destination = Destination::create([
                'country_id' => $request->country_id,
                'state_id'   => $request->state_id,
                'city_id'    => $request->city_id,

                'name'       => $request->name,
                'slug'       => Str::slug($request->name).'-'.Str::random(5),
                'tagline'    => $request->tagline,
                'short_description' => $request->short_description,
                'description'       => $request->description,

                'featured_image' => $featuredImage,
                'banner_image'   => $featuredImage,

                'starting_price' => $request->starting_price,

                'latitude'  => $request->latitude,
                'longitude' => $request->longitude,

                'best_time_to_visit' => $request->best_time_to_visit,

                'is_featured' => $request->boolean('is_featured'),
                'is_popular'  => $request->boolean('is_popular'),
                'status'      => $request->boolean('status'),

                'sort_order' => $request->sort_order ?? 0,

                'meta_title'       => $request->meta_title,
                'meta_description' => $request->meta_description,
            ]);

            // ------------------- Gallery Images ------------------- //
            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $index => $image) {
                    $imageName = time().'_'.$index.'_'.Str::random(5).'.'.$image->getClientOriginalExtension();
                    $image->move(
                        public_path('images/destinations'),
                        $imageName
                    );
                    DestinationImage::create([
                        'destination_id' => $destination->id,
                        'image'          => $imageName,
                        'sort_order'     => $index + 1,
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Destination created successfully.',
                'redirect' => route('destinations.index')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            if (!empty($featuredImage)) {
                $path = public_path('images/destinations/'.$featuredImage);
                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            if (!empty($bannerImage)) {
                $path = public_path('images/destinations/'.$bannerImage);
                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ],500);
        }
    }

    public function show(Destination $destination)
    {
        // $this->authorize('destinations-show');

        $title = 'Destination Details';

        $destination->load([
            'country',
            'state',
            'city',
            'images',
            'tours',
            'hotels',
            'reviews.user',
            'faqs'
        ]);
        return view('admin.destinations.show', get_defined_vars());
    }

    public function edit(Destination $destination)
    {
        $this->authorize('destinations-edit');

        $title = 'Edit Destination';

        $countries = Country::where('status', 1)
            ->orderBy('name')
            ->get();

        $states = State::where('country_id', $destination->country_id)
            ->orderBy('name')
            ->get();

        $cities = City::where('state_id', $destination->state_id)
            ->orderBy('name')
            ->get();

        $destination->load([
            'images'
        ]);

        return view(
            'admin.destinations.edit',
            compact(
                'title',
                'destination',
                'countries',
                'states',
                'cities'
            )
        );
    }

    public function update(Request $request, Destination $destination)
    {
        $this->authorize('destinations-edit');

        $validator = Validator::make($request->all(), [

            'country_id'         => 'required|exists:countries,id',
            'state_id'           => 'nullable|exists:states,id',
            'city_id'            => 'nullable|exists:cities,id',

            'name'               => 'required|max:255|unique:destinations,name,' . $destination->id,
            'tagline'            => 'nullable|max:255',

            'short_description'  => 'nullable|string',
            'description'        => 'nullable|string',

            'featured_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'banner_image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            'gallery.*'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            'starting_price'     => 'required|numeric|min:0',

            'latitude'           => 'nullable|numeric',
            'longitude'          => 'nullable|numeric',

            'best_time_to_visit' => 'nullable|max:255',

            'is_featured'        => 'nullable|boolean',
            'is_popular'         => 'nullable|boolean',
            'status'             => 'nullable|boolean',

            'sort_order'         => 'nullable|integer',

            'meta_title'         => 'nullable|max:255',
            'meta_description'   => 'nullable|string',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // ----------------- Featured Image ----------------- //
            $featuredImage = $destination->featured_image;
            if ($request->hasFile('featured_image')) {
                if ($featuredImage) {
                    $old = public_path('images/destinations/' . $featuredImage);
                    if (File::exists($old)) {
                        File::delete($old);
                    }
                }

                $file = $request->file('featured_image');
                $featuredImage = time().'_featured_'.Str::random(6).'.'.$file->getClientOriginalExtension();
                $file->move(
                    public_path('images/destinations'),
                    $featuredImage
                );
            }

            // ----------------- Banner Image ----------------- //
            $bannerImage = $destination->banner_image;
            if ($request->hasFile('banner_image')) {
                if ($bannerImage) {
                    $old = public_path('images/destinations/' . $bannerImage);
                    if (File::exists($old)) {
                        File::delete($old);
                    }
                }

                $file = $request->file('banner_image');
                $bannerImage = time().'_banner_'.Str::random(6).'.'.$file->getClientOriginalExtension();
                $file->move(
                    public_path('images/destinations'),
                    $bannerImage
                );
            }

            // ----------------- Update Destination ----------------- //
            $destination->update([
                'country_id' => $request->country_id,
                'state_id'   => $request->state_id,
                'city_id'    => $request->city_id,

                'name'       => $request->name,
                'slug'       => Str::slug($request->name).'-'.$destination->id,
                'tagline'            => $request->tagline,
                'short_description'  => $request->short_description,
                'description'        => $request->description,

                'featured_image' => $featuredImage,
                'banner_image'   => $bannerImage,

                'starting_price' => $request->starting_price,

                'latitude'  => $request->latitude,
                'longitude' => $request->longitude,

                'best_time_to_visit' => $request->best_time_to_visit,

                'is_featured' => $request->boolean('is_featured'),
                'is_popular'  => $request->boolean('is_popular'),
                'status'      => $request->boolean('status'),

                'sort_order' => $request->sort_order ?? 0,

                'meta_title'       => $request->meta_title,
                'meta_description' => $request->meta_description,
            ]);

            // ----------------- New Gallery Images ----------------- //
            if ($request->hasFile('gallery')) {
                $lastOrder = $destination->images()->max('sort_order') ?? 0;
                foreach ($request->file('gallery') as $index => $image) {
                    $imageName = time().'_'.$index.'_'.Str::random(6).'.'.$image->getClientOriginalExtension();
                    $image->move(
                        public_path('images/destinations/'),
                        $imageName
                    );

                    DestinationImage::create([
                        'destination_id' => $destination->id,
                        'image'          => $imageName,
                        'sort_order'     => ++$lastOrder,
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'success'  => true,
                'message'  => 'Destination updated successfully.',
                'redirect' => route('destinations.index')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Destination $destination)
    {
        $this->authorize('destinations-delete');

        DB::beginTransaction();
        try {

            // ----------------- Featured Image ----------------- //
            if (!empty($destination->featured_image)) {
                $path = public_path('images/destinations/' . $destination->featured_image);
                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            // ----------------- Banner Image -----------------//
            if (!empty($destination->banner_image)) {
                $path = public_path('images/destinations/' . $destination->banner_image);
                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            // ----------------- Gallery Images ----------------- //
            foreach ($destination->images as $image) {
                $path = public_path('images/destinations/' . $image->image);
                if (File::exists($path)) {
                    File::delete($path);
                }
                $image->delete();
            }

            // ----------------- Delete Destination ----------------- //
            $destination->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Destination deleted successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteGalleryImage(DestinationImage $image)
    {
        $this->authorize('destinations-edit');

        try {
            $path = public_path($image->image);
            if (File::exists('images/destinations/'.$path)) {
                File::delete('images/destinations/'.$path);
            }
            $image->delete();
            return response()->json([
                'success' => true,
                'message' => 'Gallery image deleted successfully.'
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    public function getStates(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'required|exists:countries,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false
            ], 422);
        }

        $states = State::where('country_id', $request->country_id)
            ->orderBy('name')
            ->get([
                'id',
                'name'
            ]);

        return response()->json([
            'success' => true,
            'states' => $states
        ]);
    }

    public function getCities(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'state_id' => 'required|exists:states,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false
            ], 422);
        }

        $cities = City::where('state_id', $request->state_id)
            ->orderBy('name')
            ->get([
                'id',
                'name'
            ]);

        return response()->json([
            'success' => true,
            'cities' => $cities
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $this->authorize('destinations-delete');

        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:destinations,id',
        ]);

        DB::beginTransaction();

        try {

            $destinations = Destination::with('images')
                ->whereIn('id', $request->ids)
                ->get();

            foreach ($destinations as $destination) {

                // Featured Image
                if (!empty($destination->featured_image)) {

                    $path = public_path('images/destinations/' . $destination->featured_image);

                    if (File::exists($path)) {
                        File::delete($path);
                    }
                }

                // Banner Image
                if (!empty($destination->banner_image)) {

                    $path = public_path('images/destinations/' . $destination->banner_image);

                    if (File::exists($path)) {
                        File::delete($path);
                    }
                }

                // Gallery Images
                foreach ($destination->images as $image) {

                    $path = public_path('images/destinations/' . $image->image);

                    if (File::exists($path)) {
                        File::delete($path);
                    }
                }

                $destination->delete();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Selected destinations deleted successfully.'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);

        }
    }

    public function changeStatus(Request $request)
    {
        Log::info('Destination Status Request', $request->all());

        $validate = Validator::make($request->all(), [
            'id' => 'required|exists:destinations,id',
        ]);

        if ($validate->fails()) {
            Log::error('Destination Status Validation Failed', [
                'errors' => $validate->errors()->toArray()
            ]);

            return response()->json([
                'success' => false,
                'errors' => $validate->errors()
            ], 422);
        }

        try {
            $destination = Destination::findOrFail($request->id);

            Log::info('Before Update', [
                'id' => $destination->id,
                'old_status' => $destination->status
            ]);

            $destination->status = !$destination->status;
            $destination->save();

            Log::info('After Update', [
                'id' => $destination->id,
                'new_status' => $destination->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Destination status updated successfully.',
                'status' => $destination->status,
            ]);

        } catch (\Exception $e) {
            Log::error('Destination Status Error', [
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

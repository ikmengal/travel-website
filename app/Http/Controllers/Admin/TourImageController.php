<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    Validator, File, DB, Log
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{
    TourImage, Tour
};

class TourImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->loaddata == "yes") {
            $query = TourImage::with('tour');

            if ($request->tour != "") {
                $query->where('tour_id', $request->tour);
            }

            if ($request->status != "") {
                $query->where('status', $request->status);
            }

            if ($request->search != "") {
                $query->where(function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('caption', 'like', '%' . $request->search . '%');
                });
            }

            return DataTables::of($query)
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" value="' . $row->id . '" class="form-check-input row-checkbox">';
            })
            ->addColumn('image', function ($row) {
                $image = asset('images/gallery/'.$row->image);
                return '
                    <img src="'.$image.'"
                        width="70"
                        height="70"
                        class="rounded shadow"
                        style="object-fit:cover">';
            })
            ->addColumn('tour', function ($row) {
                return $row->tour?->title ?? '-';
            })
            ->addColumn('caption', function ($row) {
                return str::words($row->caption, 10) ?? '-';
            })
            ->addColumn('status', function ($row) {
                $checked = $row->status ? 'checked' : '';
                return ' <div class="form-check form-switch">
                        <input class="form-check-input changeStatus" type="checkbox" data-id="' . $row->id . '"' . $checked . '></div>';
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at->format('d M Y');
            })
            ->addColumn('action', function ($row) {
                return view('admin.tour_images.action', compact('row'))->render();
            })
            ->rawColumns(['checkbox', 'image', 'status', 'action'])
            ->make(true);
        }
        $data['title'] = "Tour Images";
        $data['tours'] = Tour::orderBy('title')->get();
        $data['totalImages'] = TourImage::count();
        $data['activeImages'] = TourImage::where('status', 1)->count();
        $data['featuredImages'] = TourImage::where('feature', 1)->count();
        $data['tourCovered'] = TourImage::distinct('tour_id')->count('tour_id');
        return view('admin.tour_images.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Add Tour Image";
        $tours = Tour::orderBy('title')->get();
        return view('admin.tour_images.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tour_id'      => 'required|exists:tours,id',
            'title'        => 'nullable|max:255',
            'caption'      => 'nullable|max:1000',
            'sort_order'   => 'nullable|numeric',

            'images'       => 'required|array|min:1',
            'images.*'     => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $key => $image) {
                    $name = time().'_'.$key.'_'.uniqid().'.'.$image->getClientOriginalExtension();
                    $image->move(
                        public_path('images/gallery'),
                        $name
                    );

                    TourImage::create([
                        'tour_id'    => $request->tour_id,
                        'title'      => $request->title,
                        'caption'    => $request->caption,
                        'sort_order' => $request->sort_order ? $request->sort_order + $key : $key + 1,
                        'feature'    => $request->featured ? 1 : 0,
                        'status'     => $request->status ? 1 : 0,
                        'image'      => 'images/gallery/'.$name,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('tour_images.index')->with('success','Tour Images Uploaded Successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect()->back()->withInput()->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TourImage $tourImage)
    {
        $title = "View Tour Image";
        $image = $tourImage->load('tour');
        return view('admin.tour_images.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TourImage $tourImage)
    {
        $title = "Edit Tour Image";
        $image = $tourImage;
        $tours = Tour::orderBy('title')->get();
        return view('admin.tour_images.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TourImage $tourImage)
    {
        $validator = Validator::make($request->all(), [
            'tour_id'      => 'required|exists:tours,id',
            'title'        => 'nullable|max:255',
            'caption'      => 'nullable|max:1000',
            'sort_order'   => 'nullable|numeric',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tourImage->tour_id = $request->tour_id;
        $tourImage->title = $request->title;
        $tourImage->caption = $request->caption;
        $tourImage->sort_order = $request->sort_order ?? 0;
        $tourImage->feature = $request->featured ? 1 : 0;
        $tourImage->status = $request->status ? 1 : 0;

        if($request->hasFile('image')){
            if($tourImage->image && File::exists(public_path($tourImage->image))){
                File::delete(public_path('images/gallery/'.$tourImage->image));
            }

            $image = $request->file('image');
            $name = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images/gallery/'),$name);
            $tourImage->image = $name;
        }

        $tourImage->save();
        return redirect()->route('tour_images.index')->with('success','Tour Image Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TourImage $tourImage)
    {
        if ($tourImage->image && File::exists(public_path('images/gallery/'.$tourImage->image))) {
            File::delete(public_path('images/gallery/'.$tourImage->image));
        }

        $tourImage->delete();
        return response()->json([
            'success' => true,
            'message' => 'Tour Image Deleted Successfully.'
        ]);
    }

    public function changeStatus(Request $request)
    {
        $image = TourImage::findOrFail($request->id);
        $image->status = !$image->status;
        $image->save();
        return response()->json([
            'success' => true,
            'message' => 'Status Updated Successfully.'
        ]);
    }

    public function bulkDelete(Request $request)
    {
        foreach ($request->ids as $id) {

            $image = TourImage::find($id);

            if (!$image) {
                continue;
            }

            if ($image->image && File::exists(public_path($image->image))) {
                File::delete(public_path($image->image));
            }

            $image->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Selected Images Deleted Successfully.'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    Validator, File, DB
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Airline;
use App\Models\Country;

class AirlineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Airline::query();

            // ---------------- Search ---------------- //
            if ($request->filled('search')) {
                $search = trim($request->search);
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('iata_code', 'like', "%{$search}%")
                        ->orWhere('icao_code', 'like', "%{$search}%")
                        ->orWhere('airline_code', 'like', "%{$search}%")
                        ->orWhere('website', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            }

            // ---------------- Featured Filter ---------------- //
            if ($request->featured != '') {
                $query->where('featured', $request->featured);
            }
            if ($request->status != '') {
                $query->where('status', $request->status);
            }
            $query->orderBy('sort_order')->orderByDesc('id');
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return view('admin.airlines.partials.checkbox', compact('row'))->render();
                })
                ->editColumn('logo', function ($row) {
                    return view('admin.airlines.partials.logo', compact('row'))->render();
                })
                ->editColumn('name', function ($row) {
                    return view('admin.airlines.partials.name', compact('row'))->render();
                })
                ->editColumn('featured', function ($row) {
                    return view('admin.airlines.partials.featured', compact('row'))->render();
                })
                ->editColumn('status', function ($row) {
                    return view('admin.airlines.partials.status', compact('row'))->render();
                })
                ->addColumn('action', function ($row) {
                    return view('admin.airlines.partials.action', compact('row'))->render();
                })
                ->rawColumns([
                    'checkbox',
                    'logo',
                    'name',
                    'featured',
                    'status',
                    'action'
                ])
                ->make(true);
        }

        // ---------------- Dashboard Cards ---------------- //
        $totalAirlines = Airline::count();
        $activeAirlines = Airline::where('status', 1)->count();
        $featuredAirlines = Airline::where('featured', 1)->count();
        $inactiveAirlines = Airline::where('status', 0)->count();
        return view('admin.airlines.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::get();
        return view('admin.airlines.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string|max:255|unique:airlines,name',
            'slug'              => 'required|string|max:255|unique:airlines,slug',
            'iata_code'         => 'nullable|string|size:2|unique:airlines,iata_code',
            'icao_code'         => 'nullable|string|size:3|unique:airlines,icao_code',
            'airline_code'      => 'required|string|max:20|unique:airlines,airline_code',
            'logo'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'website'           => 'nullable|url|max:255',
            'phone'             => 'nullable|string|max:50',
            'email'             => 'nullable|email|max:255',
            'description'       => 'nullable|string',
            'featured'          => 'required|boolean',
            'status'            => 'required|boolean',
            'sort_order'        => 'nullable|integer|min:0',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $airline = new Airline();
            $airline->name             = $request->name;
            $airline->slug             = Str::slug($request->slug);
            $airline->iata_code        = strtoupper($request->iata_code);
            $airline->icao_code        = strtoupper($request->icao_code);
            $airline->airline_code     = strtoupper($request->airline_code);
            $airline->website          = $request->website;
            $airline->phone            = $request->phone;
            $airline->email            = $request->email;
            $airline->description      = $request->description;
            $airline->featured         = $request->featured;
            $airline->status           = $request->status;
            $airline->sort_order       = $request->sort_order ?? 0;
            $airline->meta_title       = $request->meta_title;
            $airline->meta_description = $request->meta_description;

            // --------------- Logo Upload --------------- //
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $logoName = time().'_'.Str::random(10).'.'.$logo->getClientOriginalExtension();
                $logo->move(
                    public_path('images/airlines'),
                    $logoName
                );
                $airline->logo = $logoName;
            }

            $airline->save();

            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Airline created successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Airline $airline)
    {
        return view('admin.airlines.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Airline $airline)
    {
        return view('admin.airlines.edit', get_defined_vars('airline'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Airline $airline)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string|max:255|unique:airlines,name,' . $airline->id,
            'slug'              => 'required|string|max:255|unique:airlines,slug,' . $airline->id,
            'iata_code'         => 'nullable|string|size:2|unique:airlines,iata_code,' . $airline->id,
            'icao_code'         => 'nullable|string|size:3|unique:airlines,icao_code,' . $airline->id,
            'airline_code'      => 'required|string|max:20|unique:airlines,airline_code,' . $airline->id,
            'logo'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'website'           => 'nullable|url|max:255',
            'phone'             => 'nullable|string|max:50',
            'email'             => 'nullable|email|max:255',
            'description'       => 'nullable|string',
            'featured'          => 'required|boolean',
            'status'            => 'required|boolean',
            'sort_order'        => 'nullable|integer|min:0',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $airline->name             = $request->name;
            $airline->slug             = Str::slug($request->slug);
            $airline->iata_code        = strtoupper($request->iata_code);
            $airline->icao_code        = strtoupper($request->icao_code);
            $airline->airline_code     = strtoupper($request->airline_code);
            $airline->website          = $request->website;
            $airline->phone            = $request->phone;
            $airline->email            = $request->email;
            $airline->description      = $request->description;
            $airline->featured         = $request->featured;
            $airline->status           = $request->status;
            $airline->sort_order       = $request->sort_order ?? 0;
            $airline->meta_title       = $request->meta_title;
            $airline->meta_description = $request->meta_description;

            // --------------- Replace Logo --------------- //
            if ($request->hasFile('logo')) {
                if ($airline->logo && File::exists(public_path('images/airlines/' . $airline->logo))) {
                    File::delete(public_path('images/airlines/' . $airline->logo));
                }

                $logo = $request->file('logo');
                $logoName = time() . '_' . Str::random(10) . '.' . $logo->getClientOriginalExtension();
                $logo->move(public_path('images/airlines'), $logoName);
                $airline->logo = $logoName;
            }

            $airline->save();

            DB::commit();
            return response()->json([
                'status'  => true,
                'message' => 'Airline updated successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Airline $airline)
    {
        DB::beginTransaction();
        try {
            // ---------------- Delete Logo ---------------- //
            if ($airline->logo && File::exists(public_path('images/airlines/' . $airline->logo))) {
                File::delete(public_path('images/airlines/' . $airline->logo));
            }

            $airline->delete();
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Airline deleted successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:airlines,id',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => 'Invalid request.'
            ], 422);

        }

        try {

            $airline = Airline::findOrFail($request->id);

            $airline->status = $request->status;

            $airline->save();

            return response()->json([
                'status' => true,
                'message' => 'Status updated successfully.'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    /*
    |--------------------------------------------------------------------------
    | Bulk Delete
    |--------------------------------------------------------------------------
    */

    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:airlines,id',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => 'Please select valid records.'
            ], 422);

        }

        DB::beginTransaction();

        try {

            $airlines = Airline::whereIn('id', $request->ids)->get();

            foreach ($airlines as $airline) {

                if (
                    $airline->logo &&
                    File::exists(public_path('images/airlines/' . $airline->logo))
                ) {
                    File::delete(public_path('images/airlines/' . $airline->logo));
                }

                $airline->delete();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Selected airlines deleted successfully.'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    /*
    |--------------------------------------------------------------------------
    | Generate Airline Code
    |--------------------------------------------------------------------------
    */

    public function generateCode()
    {
        $code = 'AIR-' . strtoupper(Str::random(6));

        while (Airline::where('airline_code', $code)->exists()) {
            $code = 'AIR-' . strtoupper(Str::random(6));
        }

        return response()->json([
            'status' => true,
            'code' => $code,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    Validator, DB
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\FlightClass;

class FlightClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = FlightClass::query();

            // ---------------- Search ---------------- //
            if ($request->filled('search')) {
                $search = trim($request->search);
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            }

            // ---------------- Status Filter ---------------- //
            if ($request->status != '') {
                $query->where('status', $request->status);
            }
            if ($request->meal != '') {
                $query->where('meal', $request->meal);
            }
            if ($request->refundable != '') {
                $query->where('refundable', $request->refundable);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return view('admin.flight_classes.partials.checkbox', compact('row'))->render();
                })
                ->editColumn('name', function ($row) {
                    return view('admin.flight_classes.partials.name', compact('row'))->render();
                })
                ->editColumn('baggage', function ($row) {
                    return $row->baggage . ' Kg';
                })
                ->editColumn('seat_priority', function ($row) {
                    return '<span class="badge bg-label-primary">'.$row->seat_priority.'</span>';
                })
                ->editColumn('meal', function ($row) {
                    return view('admin.flight_classes.partials.meal', compact('row'))->render();
                })
                ->editColumn('refundable', function ($row) {
                    return view('admin.flight_classes.partials.refundable', compact('row'))->render();
                })
                ->editColumn('status', function ($row) {
                    return view('admin.flight_classes.partials.status', compact('row'))->render();
                })
                ->addColumn('action', function ($row) {
                    return view('admin.flight_classes.action', compact('row'))->render();
                })
                ->rawColumns(['checkbox', 'name', 'seat_priority', 'meal', 'refundable', 'status', 'action',])
                ->make(true);
        }

        // ---------------- Dashboard Cards ---------------- //
        $totalFlightClasses = FlightClass::count();
        $activeFlightClasses = FlightClass::where('status', 1)->count();
        $mealFlightClasses = FlightClass::where('meal', 1)->count();
        $refundableFlightClasses = FlightClass::where('refundable', 1)->count();
        return view('admin.flight_classes.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.flight_classes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'            => 'required|string|max:255|unique:flight_classes,name',
            'slug'            => 'required|string|max:255|unique:flight_classes,slug',
            'description'     => 'nullable|string',

            'baggage'         => 'required|integer|min:0|max:100',
            'seat_priority'   => 'required|integer|min:1|max:10',
            'meal'            => 'required|boolean',
            'refundable'      => 'required|boolean',
            'sort_order'      => 'nullable|integer|min:0',
            'status'          => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $flightClass = new FlightClass();
            $flightClass->name = $request->name;
            $flightClass->slug = Str::slug($request->slug);
            $flightClass->description = $request->description;
            $flightClass->baggage = $request->baggage;
            $flightClass->seat_priority = $request->seat_priority;
            $flightClass->meal = $request->meal;
            $flightClass->refundable = $request->refundable;
            $flightClass->sort_order = $request->sort_order ?? 0;
            $flightClass->status = $request->status;
            $flightClass->save();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Flight class created successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FlightClass $flightClass)
    {
        return view('admin.flight_classes.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FlightClass $flightClass)
    {
        return view('admin.flight_classes.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FlightClass $flight_class)
    {
        $validator = Validator::make($request->all(), [
            'name'            => 'required|string|max:255|unique:flight_classes,name,' . $flight_class->id,
            'slug'            => 'required|string|max:255|unique:flight_classes,slug,' . $flight_class->id,
            'description'     => 'nullable|string',
            'baggage'         => 'required|integer|min:0|max:100',
            'seat_priority'   => 'required|integer|min:1|max:10',
            'meal'            => 'required|boolean',
            'refundable'      => 'required|boolean',
            'sort_order'      => 'nullable|integer|min:0',
            'status'          => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $flight_class->name = $request->name;
            $flight_class->slug = Str::slug($request->slug);
            $flight_class->description = $request->description;
            $flight_class->baggage = $request->baggage;
            $flight_class->seat_priority = $request->seat_priority;
            $flight_class->meal = $request->meal;
            $flight_class->refundable = $request->refundable;
            $flight_class->sort_order = $request->sort_order ?? 0;
            $flight_class->status = $request->status;
            $flight_class->save();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Flight class updated successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FlightClass $flight_class)
    {
        DB::beginTransaction();
        try {
            $flight_class->delete();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Flight class deleted successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ],500);
        }
    }

    /**
     * Change Status
     */
    public function changeStatus(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id'     => 'required|exists:flight_classes,id',
            'status' => 'required|boolean',
        ]);

        if($validator->fails()){
            return response()->json([
                'errors'=>$validator->errors()
            ],422);
        }

        try{
            $flightClass = FlightClass::findOrFail($request->id);

            $flightClass->status = $request->status;
            $flightClass->save();

            return response()->json([
                'status'=>true,
                'message'=>'Status updated successfully.'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ],500);
        }
    }

    /**
     * Bulk Delete
     */
    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'ids'   => 'required|array|min:1',
            'ids.*' => 'exists:flight_classes,id',
        ]);

        if($validator->fails()){
            return response()->json([
                'errors'=>$validator->errors()
            ],422);
        }

        DB::beginTransaction();
        try{
            FlightClass::whereIn('id',$request->ids)->delete();
            DB::commit();

            return response()->json([
                'status'=>true,
                'message'=>'Selected flight classes deleted successfully.'
            ]);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'status'=>false,
                'message'=>$e->getMessage()
            ],500);
        }
    }

    /**
     * Generate Slug
     */
    public function generateSlug(Request $request)
    {
        return response()->json([
            'slug' => Str::slug($request->title)
        ]);
    }
}

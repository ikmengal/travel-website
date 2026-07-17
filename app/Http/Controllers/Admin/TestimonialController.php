<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    Storage, DB, Validator
};
use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Testimonial::query();

            // Search
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('designation', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%")
                        ->orWhere('review', 'like', "%{$search}%");
                });
            }

            // --------- Filters --------- //
            if ($request->status != '') {
                $query->where('status', $request->status);
            }

            if ($request->featured != '') {
                $query->where('featured', $request->featured);
            }

            if ($request->rating != '') {
                $query->where('rating', $request->rating);
            }

            // --------- DataTable --------- //
            return DataTables::of($query)
                ->addColumn('checkbox', function ($row) {
                    return view('admin.testimonials.partials.checkbox', compact('row'))->render();
                })
                ->editColumn('image', function ($row) {
                    return view('admin.testimonials.partials.user', compact('row'))->render();
                })
                ->editColumn('rating', function ($row) {
                    return str_repeat('⭐', $row->rating);
                })
                ->editColumn('featured', function ($row) {
                    return view('admin.testimonials.partials.featured', compact('row'))->render();
                })
                ->editColumn('status', function ($row) {
                    return view('admin.testimonials.partials.status', compact('row'))->render();
                })
                ->addColumn('action', function ($row) {
                    return view('admin.testimonials.action', compact('row'))->render();
                })
                ->rawColumns(['checkbox', 'image', 'featured', 'status', 'action'])
                ->make(true);
        }
        return view('admin.testimonials.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        //
    }

     /**
     * Change Status (AJAX)
     */
    public function changeStatus(Request $request)
    {
        //
    }

    /**
     * Change Featured (AJAX)
     */
    public function changeFeatured(Request $request)
    {
        //
    }

    /**
     * Bulk Delete
     */
    public function bulkDelete(Request $request)
    {
        //
    }
}

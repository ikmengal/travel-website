<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    Validator, File, DB
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Partner;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $partners = Partner::query();
            return DataTables::of($partners)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if ($request->filled('search')) {
                        $query->where('name', 'like', '%' . $request->search . '%');
                    }
                    if ($request->filled('status')) {
                        $query->where('status', $request->status);
                    }
                    if ($request->filled('featured')) {
                        $query->where('featured', $request->featured);
                    }
                })
                ->addColumn('checkbox', function ($row) {
                    return view('admin.partners.partials.checkbox', ['row' => $row])->render();
                })
                ->addColumn('logo', function ($row) {
                    return '<img src="' . $row->logo . '" width="60" class="rounded border">';
                })
                ->editColumn('website', function ($row) {
                    if (!$row->website) {
                        return '-';
                    }
                    return '<a href="' . $row->website . '" target="_blank">'
                        . $row->website .
                        '</a>';
                })
                ->editColumn('featured', function ($row) {
                    return view('admin.partners.partials.switch-featured', ['row' => $row])->render();
                })
                ->editColumn('status', function ($row) {
                    return view('admin.partners.partials.switch-status', ['row' => $row])->render();
                })
                ->addColumn('action', function ($row) {
                    return view('admin.partners.action', compact('row'))->render();
                })
                ->rawColumns([
                    'checkbox',
                    'logo',
                    'website',
                    'featured',
                    'status',
                    'action'
                ])
                ->make(true);
        }
        return view('admin.partners.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.partners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255|unique:partners,name',
            'website'    => 'nullable|url|max:255',
            'logo'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'featured'   => 'required|boolean',
            'status'     => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {

            $partner = new Partner();

            $partner->name = $request->name;
            $partner->website = $request->website;
            $partner->sort_order = $request->sort_order ?? 0;
            $partner->featured = $request->featured;
            $partner->status = $request->status;

            if ($request->hasFile('logo')) {

                $image = $request->file('logo');

                $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                $image->move(public_path('images/partners'), $fileName);

                $partner->logo = $fileName;
            }

            $partner->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Partner created successfully.'
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
    public function show(Partner $partner)
    {
        return view('admin.partners.show', compact('partner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partner $partner)
    {
        $validator = Validator::make($request->all(), [
            'name'       => 'required|string|max:255|unique:partners,name,' . $partner->id,
            'website'    => 'nullable|url|max:255',
            'logo'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'featured'   => 'required|boolean',
            'status'     => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {

            $partner->name = $request->name;
            $partner->website = $request->website;
            $partner->sort_order = $request->sort_order ?? 0;
            $partner->featured = $request->featured;
            $partner->status = $request->status;

            if ($request->hasFile('logo')) {

                if (
                    $partner->getRawOriginal('logo') &&
                    File::exists(public_path('images/partners/' . $partner->getRawOriginal('logo')))
                ) {
                    File::delete(public_path('images/partners/' . $partner->getRawOriginal('logo')));
                }

                $image = $request->file('logo');

                $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                $image->move(public_path('images/partners'), $fileName);

                $partner->logo = $fileName;
            }

            $partner->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Partner updated successfully.'
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
    public function destroy(Partner $partner)
    {
        DB::beginTransaction();
        try {
            if (
                $partner->getRawOriginal('logo') &&
                File::exists(public_path('images/partners/' . $partner->getRawOriginal('logo')))
            ) {
                File::delete(public_path('images/partners/' . $partner->getRawOriginal('logo')));
            }
            $partner->delete();

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Partner deleted successfully.'
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
        $request->validate([
            'id' => 'required|exists:partners,id',
            'status' => 'required|boolean',
        ]);

        $partner = Partner::findOrFail($request->id);

        $partner->update([
            'status' => $request->status
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Partner status updated successfully.'
        ]);
    }

    public function changeFeatured(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:partners,id',
            'featured' => 'required|boolean',
        ]);

        $partner = Partner::findOrFail($request->id);

        $partner->update([
            'featured' => $request->featured
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Partner featured status updated successfully.'
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:partners,id',
        ]);

        DB::beginTransaction();

        try {

            $partners = Partner::whereIn('id', $request->ids)->get();

            foreach ($partners as $partner) {

                if (
                    $partner->getRawOriginal('logo') &&
                    File::exists(public_path('images/partners/' . $partner->getRawOriginal('logo')))
                ) {
                    File::delete(public_path('images/partners/' . $partner->getRawOriginal('logo')));
                }

                $partner->delete();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Selected partners deleted successfully.'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);

        }
    }
}

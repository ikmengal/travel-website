<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    Validator, DB
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{
    Destination,
    // TourPackage,
    Flight,
    Hotel,
    Tour,
    Faq,
    Car
};

class FaqsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->loaddata == "yes") {
            $query = Faq::with('faqable');

            // ------------ FILTER ------------ //
            if ($request->filled('faqable_type')) {
                $query->where('faqable_type', $request->faqable_type);
            }

            if ($request->filled('faqable_id')) {
                $query->where('faqable_id', $request->faqable_id);
            }

            if ($request->status != '') {
                $query->where('status', $request->status);
            }

            if ($request->featured != '') {
                $query->where('featured', $request->featured);
            }

            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox"
                            class="form-check-input row-checkbox"
                            value="' . $row->id . '">';
            })
            ->addColumn('type', function ($row) {
                return '<span class="badge bg-label-primary">'
                    . class_basename($row->faqable_type) .
                    '</span>';
            })
            ->addColumn('related', function ($row) {
                if (!$row->faqable) {
                    return '-';
                }
                return $row->faqable->title
                    ?? $row->faqable->name
                    ?? '-';
            })
            ->editColumn('question', function ($row) {
                return Str::limit($row->question, 70);
            })
            ->editColumn('answer', function ($row) {
                return Str::limit(strip_tags($row->answer), 30);
            })
            ->addColumn('featured', function ($row) {
                $checked = $row->featured ? 'checked' : '';
                return '
                    <div class="form-check form-switch">
                        <input
                            type="checkbox"
                            class="form-check-input changeFeatured"
                            data-id="' . $row->id . '"
                            ' . $checked . '>
                    </div>
                ';
            })
            ->addColumn('status', function ($row) {
                $checked = $row->status ? 'checked' : '';
                return '
                    <div class="form-check form-switch">
                        <input
                            type="checkbox"
                            class="form-check-input changeStatus"
                            data-id="' . $row->id . '"
                            ' . $checked . '>
                    </div>
                ';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d M Y');
            })
            ->addColumn('action', function ($row) {
                return view('admin.faqs.action', compact('row'));
            })
            ->rawColumns(['checkbox', 'type', 'featured', 'status', 'action'])
            ->make(true);
        }

        $title = 'FAQ Management';
        $totalFaqs = Faq::count();
        $featuredFaqs = Faq::where('featured', 1)->count();
        $activeFaqs = Faq::where('status', 1)->count();
        $faqTypes = Faq::select('faqable_type')->distinct()->count();
        return view('admin.faqs.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Create FAQ';
        return view('admin.faqs.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'faqable_type' => 'required|string',
            'faqable_id'   => 'required|integer',
            'question'     => 'required|string|max:255',
            'answer'       => 'required|string',
            'sort_order'   => 'nullable|integer|min:0',
            'featured'     => 'nullable|boolean',
            'status'       => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            $models = [
                Tour::class        => Tour::class,
                Hotel::class       => Hotel::class,
                Destination::class => Destination::class,
                Car::class         => Car::class,
                Flight::class      => Flight::class,
                // TourPackage::class => TourPackage::class,
            ];

            if (! array_key_exists($request->faqable_type, $models)) {
                return redirect()->back()->with('error', 'Invalid FAQ Type.')->withInput();
            }

            $model = $models[$request->faqable_type];
            $record = $model::find($request->faqable_id);

            if (! $record) {
                return redirect()->back()->with('error', 'Selected record not found.')->withInput();
            }

            Faq::create([
                'faqable_type' => $request->faqable_type,
                'faqable_id'   => $request->faqable_id,
                'question'     => $request->question,
                'answer'       => $request->answer,
                'featured'     => $request->boolean('featured'),
                'status'       => $request->boolean('status', true),
                'sort_order'   => $request->sort_order ?? 0,
            ]);

            DB::commit();
            return redirect()->route('faqs.index')->with('success', 'FAQ created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        $faq->load('faqable');
        $title = 'FAQ Details';
        $faq = $faq;
        return view('admin.faqs.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        $faq->load('faqable');
        $title = 'Edit FAQ';
        $faq = $faq;
        return view('admin.faqs.edit', get_defined_vars());
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, Faq $faq)
    {
        $validator = Validator::make($request->all(), [
            'faqable_type' => 'required|string',
            'faqable_id'   => 'required|integer',
            'question'     => 'required|string|max:255',
            'answer'       => 'required|string',
            'sort_order'   => 'nullable|integer|min:0',
            'featured'     => 'nullable|boolean',
            'status'       => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();
            $models = [
                Tour::class        => Tour::class,
                Hotel::class       => Hotel::class,
                Destination::class => Destination::class,
                Car::class         => Car::class,
                Flight::class      => Flight::class,
                // TourPackage::class => TourPackage::class,
            ];

            if (!array_key_exists($request->faqable_type, $models)) {
                return redirect()->back()->withInput()->with('error', 'Invalid FAQ Type.');
            }

            $model = $models[$request->faqable_type];
            $record = $model::find($request->faqable_id);

            if (!$record) {
                return redirect()->back()->withInput()->with('error', 'Selected record not found.');
            }

            $faq->update([
                'faqable_type' => $request->faqable_type,
                'faqable_id'   => $request->faqable_id,
                'question'     => $request->question,
                'answer'       => $request->answer,
                'featured'     => $request->boolean('featured'),
                'status'       => $request->boolean('status'),
                'sort_order'   => $request->sort_order ?? 0,
            ]);

            DB::commit();
            return redirect()->route('faqs.index')->with('success', 'FAQ updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        try {
            $faq->delete();
            return response()->json([
                'status'  => true,
                'message' => 'FAQ deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Change FAQ Status
     */
    public function changeStatus(Request $request)
    {
        try {
            $faq = Faq::findOrFail($request->id);
            $faq->status = !$faq->status;
            $faq->save();

            return response()->json([
                'status'  => true,
                'message' => 'Status updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Change Featured Status
     */
    public function changeFeatured(Request $request)
    {
        try {
            $faq = Faq::findOrFail($request->id);
            $faq->featured = !$faq->featured;
            $faq->save();

            return response()->json([
                'status'  => true,
                'message' => 'Featured status updated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk Delete
     */
    public function bulkDelete(Request $request)
    {
        try {
            if (!$request->filled('ids')) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Please select at least one FAQ.'
                ]);
            }

            Faq::whereIn('id', $request->ids)->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Selected FAQs deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Models By Type (AJAX)
     */
    public function getModels(Request $request)
    {
        $models = [
            Tour::class => Tour::select('id', 'title')->orderBy('title')->get(),
            Hotel::class => Hotel::select('id', 'name')->orderBy('name')->get(),
            Destination::class => Destination::select('id', 'name')->orderBy('name')->get(),
            Car::class => Car::select('id', 'name')->orderBy('name')->get(),
            // Flight::class => Flight::select('id', 'title')->orderBy('title')->get(),
            // TourPackage::class => TourPackage::select('id', 'title')->orderBy('title')->get(),
        ];

        return response()->json(
            $models[$request->type] ?? []
        );
    }
}

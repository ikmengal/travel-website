<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    Validator, DB
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\TeamMember;

class TeamMemberController extends Controller
{
    /**
     * Display listing
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $teamMembers = TeamMember::query();
            return DataTables::of($teamMembers)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if ($request->filled('search')) {
                        $query->where(function ($q) use ($request) {
                            $q->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('designation', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%');
                        });
                    }
                    if ($request->filled('status')) {
                        $query->where('status', $request->status);
                    }
                    if ($request->filled('featured')) {
                        $query->where('featured', $request->featured);
                    }
                })
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="form-check-input row-checkbox" value="'.$row->id.'">';
                })
                ->addColumn('image', function ($row) {
                    return '<img src="'.$row->image.'" width="60" height="60" class="rounded-circle border object-fit-cover">';
                })
                ->addColumn('social', function ($row) {
                    $html = '';
                    if($row->facebook)
                        $html .= '<i class="ti ti-brand-facebook text-primary me-1"></i>';
                    if($row->instagram)
                        $html .= '<i class="ti ti-brand-instagram text-danger me-1"></i>';
                    if($row->linkedin)
                        $html .= '<i class="ti ti-brand-linkedin text-info me-1"></i>';
                    if($row->twitter)
                        $html .= '<i class="ti ti-brand-x me-1"></i>';
                    if($row->youtube)
                        $html .= '<i class="ti ti-brand-youtube text-danger"></i>';
                    return $html ?: '-';
                })
                ->editColumn('featured', function ($row) {
                    return view('admin.team_members.partials.switch-featured',[
                        'row'=>$row,
                        'checked'=>$row->featured,
                        'class'=>'featured-switch'
                    ])->render();
                })
                ->editColumn('status', function ($row) {
                    return view('admin.team_members.partials.switch-status',[
                        'row'=>$row,
                        'checked'=>$row->status,
                        'class'=>'status-switch'
                    ])->render();
                })
                ->addColumn('action', function ($row) {
                    return view('admin.team_members.action',compact('row'))->render();
                })
                ->rawColumns([
                    'checkbox',
                    'image',
                    'social',
                    'featured',
                    'status',
                    'action'
                ])
                ->make(true);
        }
        return view('admin.team_members.index');
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.team_members.create');
    }

    /**
     * Store
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:team_members,slug',
            'designation' => 'required|string|max:255',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'short_bio'   => 'nullable|string',
            'email'       => 'nullable|email|max:255',
            'phone'       => 'nullable|string|max:30',
            'facebook'    => 'nullable|url',
            'instagram'   => 'nullable|url',
            'linkedin'    => 'nullable|url',
            'twitter'     => 'nullable|url',
            'youtube'     => 'nullable|url',
            'sort_order'  => 'nullable|integer|min:0',
            'featured'    => 'required|boolean',
            'status'      => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $image = null;
            if ($request->hasFile('image')) {
                $image = time().'_'.Str::slug($request->name).'.'.$request->image->extension();
                $request->image->move(public_path('images/team-members'), $image);
            }

            TeamMember::create([
                'name' => $request->name,
                'slug' => Str::slug($request->slug),
                'designation' => $request->designation,
                'image' => $image,
                'short_bio' => $request->short_bio,
                'email' => $request->email,
                'phone' => $request->phone,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
                'linkedin' => $request->linkedin,
                'twitter' => $request->twitter,
                'youtube' => $request->youtube,
                'sort_order' => $request->sort_order ?? 0,
                'featured' => $request->featured,
                'status' => $request->status,
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Team member created successfully.'
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
     * Show details
     */
    public function show(TeamMember $teamMember)
    {
        return view('admin.team_members.show', compact('teamMember'));
    }

    /**
     * Show edit form
     */
    public function edit(TeamMember $teamMember)
    {
        return view('admin.team_members.edit', compact('teamMember'));
    }

    /**
     * Update
     */
    public function update(Request $request, TeamMember $teamMember)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'slug' => 'required|unique:team_members,slug,' . $teamMember->id,
            'designation' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'short_bio' => 'nullable',
            'email' => 'nullable|email',
            'phone' => 'nullable|max:30',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'twitter' => 'nullable|url',
            'youtube' => 'nullable|url',
            'sort_order' => 'nullable|integer',
            'featured' => 'required|boolean',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $image = $teamMember->getRawOriginal('image');
            if ($request->hasFile('image')) {
                if ($image && file_exists(public_path('images/team-members/'.$image))) {
                    unlink(public_path('images/team-members/'.$image));
                }
                $image = time().'_'.Str::slug($request->name).'.'.$request->image->extension();
                $request->image->move(public_path('images/team-members'), $image);
            }

            $teamMember->update([
                'name' => $request->name,
                'slug' => Str::slug($request->slug),
                'designation' => $request->designation,
                'image' => $image,
                'short_bio' => $request->short_bio,
                'email' => $request->email,
                'phone' => $request->phone,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
                'linkedin' => $request->linkedin,
                'twitter' => $request->twitter,
                'youtube' => $request->youtube,
                'sort_order' => $request->sort_order,
                'featured' => $request->featured,
                'status' => $request->status,
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Team member updated successfully.'
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
     * Delete
     */
    public function destroy(TeamMember $teamMember)
    {
        try {
            $image = $teamMember->getRawOriginal('image');
            if ($image && file_exists(public_path('images/team-members/' . $image))) {
                unlink(public_path('images/team-members/' . $image));
            }

            // Image column NULL kar do
            $teamMember->update([
                'image' => null
            ]);

            // Soft Delete
            $teamMember->delete();

            return response()->json([
                'status' => true,
                'message' => 'Team member deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Change Status
     */
    public function changeStatus(Request $request)
    {
        $teamMember = TeamMember::findOrFail($request->id);

        $teamMember->update([
            'status' => $request->status
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Status updated successfully.'
        ]);
    }

    /**
     * Change Featured
     */
    public function changeFeatured(Request $request)
    {
        $teamMember = TeamMember::findOrFail($request->id);

        $teamMember->update([
            'featured' => $request->featured
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Featured status updated successfully.'
        ]);
    }

    /**
     * Bulk Delete
     */
    public function bulkDelete(Request $request)
    {
        $members = TeamMember::whereIn('id', $request->ids)->get();

        foreach ($members as $member) {
            $image = $member->getRawOriginal('image');

            if ($image && file_exists(public_path('images/team-members/' . $image))) {
                unlink(public_path('images/team-members/' . $image));
            }

            // Image column NULL
            $member->update([
                'image' => null
            ]);

            // Soft Delete
            $member->delete();
        }
        return response()->json([
            'status' => true,
            'message' => 'Selected team members deleted successfully.'
        ]);
    }
}

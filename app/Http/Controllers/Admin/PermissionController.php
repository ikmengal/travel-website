<?php

namespace App\Http\Controllers\Admin;

use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    Validator, DB
};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('permissions-list');
        $title = "All Permissions";

        if ($request->ajax() && $request->loaddata == "yes") {
            $permissions = Permission::query()
                ->selectRaw('MIN(id) as id, label, MIN(name) as name, MIN(created_at) as created_at')
                ->groupBy('label')
                ->orderBy('label');

            return DataTables::of($permissions)
                ->addIndexColumn()
                ->editColumn('name', function ($permission) {
                    return '<span class="fw-semibold text-primary">'.ucfirst($permission->label).'</span>';
                })
               ->addColumn('permission_url', function ($permission) {
                    return Permission::where('label',$permission->label)->value('name');
                })
                ->addColumn('permission', function ($permission) {
                    $colors = [
                        'list'   => 'primary',
                        'view'   => 'secondary',
                        'create' => 'success',
                        'edit'   => 'info',
                        'delete' => 'danger',
                        'status' => 'warning',
                        'export' => 'dark',
                        'print'  => 'primary',
                        'restore'=> 'success',
                    ];
                    return Permission::where('label', $permission->label)
                        ->pluck('name')
                        ->map(function ($item) use ($colors) {

                            $action = strtolower(str($item)->afterLast('-'));

                            $color = $colors[$action] ?? 'secondary';

                            return '<span class="badge bg-label-' . $color . ' me-1 mb-1">'
                                    . ucfirst($action) .
                                '</span>';

                        })
                        ->implode('');
                })
                ->editColumn('created_at', function ($permission) {
                    return $permission->created_at
                        ? $permission->created_at->format('d M Y')
                        : '-';
                })
                ->addColumn('action', function ($permission) {
                    return view('admin.permissions.action', compact('permission'))->render();
                })
                ->rawColumns([
                    'name',
                    'permission_url',
                    'permission',
                    'action'
                ])
                ->make(true);
        }
        return view('admin.permissions.index', compact('title'));
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
        $validate = validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array|min:1',
            'custom' => 'nullable|string'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validate->errors()
            ], 422);
        }

        $label = Str::slug($request->name);

        if($request->filled('permissions')){
            foreach ($request->permissions as $permission) {
                Permission::firstOrCreate([
                    'name' => $label.'-'.$permission,
                    'guard_name' => 'web'
                ],[
                    'label' => $label
                ]);
            }
        }

        if($request->filled('custom')){
            $customPermissions = explode(',', $request->custom);
            foreach($customPermissions as $custom){
                $custom = Str::slug(trim($custom));
                Permission::firstOrCreate([
                    'name'=>$label.'-'.$custom,
                    'guard_name'=>'web'
                ],[
                    'label'=>$label
                ]);
            }
        }

        return response()->json([
            'success'=>true,
            'message'=>'Permission created successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($label)
    {
        // $this->authorize('permissions-delete');
        // try {
        //     // Remove from roles
        //     $permission->roles()->detach();
        //     // Delete permission
        //     $permission->delete();
        //     return response()->json([
        //         'status' => true,
        //         'message' => 'Permission deleted successfully.'
        //     ]);

        // } catch (\Exception $e) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => $e->getMessage(),
        //     ], 500);
        // }

        $permission = Permission::where('label', $label)
        ->latest('id')
        ->first();

        if (!$permission) {
            return response()->json([
                'success' => false,
                'message' => 'Permission not found.'
            ], 404);
        }

        $permission->roles()->detach();
        $permission->delete();

        return response()->json([
            'success' => true,
            'message' => 'Permission deleted successfully.'
        ]);
    }
}

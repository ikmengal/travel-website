<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{
    validator, DB
};
use Illuminate\Http\Request;
use Spatie\Permission\Models\{
    Permission, Role
};

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('roles-list');
        $title = "All Roles";
        $roles = Role::with('users')->get();
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('-', $permission->name)[0];
        });
        return view('admin.roles.index', get_defined_vars());
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
            'role'  => 'required|string|max:255|unique:roles,name',
            'items' => 'required|array|min:1',
        ],[
            'items.required' => 'Please select at least one permission.',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validate->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {

            $role = Role::create([
                'name' => $request->role,
                'guard_name' => 'web',
            ]);

            // Agar checkbox me permission IDs hain
            $permissions = Permission::whereIn('id', $request->items)->get();

            $role->syncPermissions($permissions);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Role created successfully.'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ],500);
        }
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
    public function edit(Role $role)
    {
        $this->authorize('roles-edit');
        $permissions = Permission::all()
            ->groupBy(function ($permission) {
                return $permission->label;
            });

        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('admin.roles.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        // $this->authorize('roles-edit');

        $request->validate([
            'role' => 'required|unique:roles,name,'.$role->id,
            'items' => 'nullable|array',
        ]);

        $role->update([
            'name' => $request->role,
        ]);

        $role->syncPermissions($request->items ?? []);

        return response()->json([
            'success' => true,
            'message' => 'Role Updated Successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //$this->authorize('roles-delete');
        if ($role->name === 'Super Admin') {
            return response()->json([
                'success' => false,
                'message' => 'Super Admin role cannot be deleted.'
            ], 422);
        }

        if ($role->users()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'This role is assigned to users. Remove it from users first.'
            ], 422);
        }

        DB::beginTransaction();

        try {

            $role->syncPermissions([]);

            $role->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Role deleted successfully.'
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

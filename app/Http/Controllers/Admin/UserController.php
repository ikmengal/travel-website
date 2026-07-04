<?php

namespace App\Http\Controllers\Admin;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\{
    Validator, Storage, File,
    Hash, Mail, DB
};
use App\Mail\UserWelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\User;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('users-list');
        $title = 'Users';
        if ($request->ajax() && $request->loaddata == "yes") {
            $query = User::with('roles')->latest();
            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->editColumn('name', function ($user) {
                    return view('admin.users.profile', compact('user'))->render();
                })
                ->addColumn('role', function ($user) {
                    return $user->roles->map(function ($role) {
                        return '<span class="badge bg-label-primary me-1">'
                                .$role->name.
                            '</span>';
                    })->implode(' ');
                })
                ->editColumn('email', function ($user) {
                    return $user->email ?? '-';
                })
                ->addColumn('phone', function ($user) {
                    return $user->phone ?? '-';
                })
                ->addColumn('status', function ($user) {
                    if ($user->status) {
                        return '<span class="badge bg-label-success">Active</span>';
                    }
                    return '<span class="badge bg-label-danger">Inactive</span>';
                })
                ->editColumn('created_at', function ($user) {
                    return $user->created_at
                        ? $user->created_at->format('d M Y')
                        : '-';
                })
                ->addColumn('action', function ($user) {
                    return view('admin.users.action', compact('user'))->render();
                })
                ->rawColumns([
                    'name',
                    'role',
                    'status',
                    'action'
                ])
                ->make(true);
        }
        return view('admin.users.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Create User";
        $roles = Role::orderBy('name')->get();
        $countries = Country::orderBy('name')->get();
        return view('admin.users.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('users-create');
        $validate = validator::make($request->all(), [
            'name'              => 'required|string|max:255',
            'username'          => 'required|string|max:255|unique:users,username',
            'email'             => 'required|email|unique:users,email',
            'phone'             => 'nullable|string|max:20|unique:users,phone',
            'avatar'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'role'              => 'required|exists:roles,name',

            'gender'            => 'nullable|in:Male,Female,Other',
            'date_of_birth'     => 'nullable|date',

            'country_id'        => 'nullable|exists:countries,id',
            'state_id'          => 'nullable|exists:states,id',
            'city_id'           => 'nullable|exists:cities,id',

            'address'           => 'nullable|string',
            'bio'               => 'nullable|string',

            'status'            => 'required|in:Active,Inactive',
            'password'          => 'required|string|min:6|confirmed',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validate->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $imageName = null;
            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $imageName = time().'_'.Str::random(5).'.'.$image->getClientOriginalExtension();
                $image->move(public_path('images/users'), $imageName);
            }

            $password = $request->password;
            if(empty($password)){
                $password = Str::password(10,true,true,false,false);
            }

            $user = User::create([
                'slug'              => Str::slug($request->username) . '-' . Str::random(5),
                'name'              => $request->name,
                'username'          => $request->username,
                'email'             => $request->email,
                'phone'             => $request->phone,

                'password'          =>Hash::make($password),

                'avatar'            => $imageName,

                'country_id'        => $request->country_id,
                'state_id'          => $request->state_id,
                'city_id'           => $request->city_id,

                'gender'            => $request->gender,
                'date_of_birth'     => $request->date_of_birth,

                'address'           => $request->address,
                'bio'               => $request->bio,
                'status'            => $request->status,
                'email_verified_at' => $request->filled('email_verified') ? now() : null,
            ]);

            // Assign Role
            $user->assignRole($request->role);

            Mail::to($user->email)->send(new UserWelcomeMail($user, $password));

            DB::commit();
            return redirect()
                ->route('users.index')
                ->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            if (!empty($imageName)) {
                $imagePath = public_path('images/users/' . $imageName);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $title = "User Profile";
        $user->load(['roles.permissions','country','state','city',]);
        return view('admin.users.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('users-edit');
        $roles = Role::orderBy('name')->get();
        $countries = Country::orderBy('name')->get();
        $states = State::where('country_id', $user->country_id)
                        ->orderBy('name')
                        ->get();

        $cities = City::where('state_id', $user->state_id)
                        ->orderBy('name')
                        ->get();

        return view('admin.users.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string|max:255',
            'username'      => 'required|unique:users,username,' . $user->id,
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'phone'         => 'nullable|unique:users,phone,' . $user->id,
            'avatar'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'role'          => 'required|exists:roles,name',

            'gender'        => 'nullable|in:Male,Female,Other',
            'date_of_birth' => 'nullable|date',

            'country_id'    => 'nullable|exists:countries,id',
            'state_id'      => 'nullable|exists:states,id',
            'city_id'       => 'nullable|exists:cities,id',

            'address'       => 'nullable|string',
            'bio'           => 'nullable|string',

            'status'        => 'required|in:Active,Inactive',

            'password'      => 'nullable|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Avatar Upload //
            if ($request->hasFile('avatar')) {
                if ($user->avatar) {
                    $oldImage = public_path('images/users/' . $user->avatar);
                    if (File::exists($oldImage)) {
                        File::delete($oldImage);
                    }
                }

                $image = $request->file('avatar');
                $imageName = time() . '_' . Str::random(5) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/users'), $imageName);
                $user->avatar = $imageName;
            }

            // --------------------- Update User -------------------- //

            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->phone = $request->phone;

            $user->country_id = $request->country_id;
            $user->state_id = $request->state_id;
            $user->city_id = $request->city_id;

            $user->gender = $request->gender;
            $user->date_of_birth = $request->date_of_birth;

            $user->address = $request->address;
            $user->bio = $request->bio;

            $user->status = $request->status;

            // --------------------- Update Password (Only if entered) --------------------- //

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            // --------------------- Save User --------------------- //
            $user->save();

            // --------------------- Sync Role --------------------- //
            $user->syncRoles([$request->role]);

            DB::commit();
            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

{{-- ======================== PROFILE INFORMATION ========================== --}}
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="ti ti-user-circle me-2"></i>
            Profile Information
        </h5>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- Avatar -->
            <div class="col-lg-3">
                <div class="text-center">
                    <img
                        src="{{ isset($user) ? $user->profile_picture : asset('images/users/user1.png') }}"
                        id="avatar-preview"
                        class="rounded-circle border shadow"
                        width="170"
                        height="170"
                        style="object-fit:cover;">

                    <div class="mt-3">
                        <input type="file" class="form-control" name="avatar" id="avatar">
                        @error('avatar')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- User Information -->
            <div class="col-lg-9">
                <div class="row">
                    <!-- Name -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input
                            type="text" class="form-control" name="name"
                            value="{{ old('name', $user->name ?? '') }}"
                            placeholder="Enter Full Name">
                        @error('name')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input
                            type="text" class="form-control" name="username"
                            value="{{ old('username', $user->username ?? '') }}"
                            placeholder="Username">
                        @error('username')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label"> Email Address <span class="text-danger">*</span></label>
                        <input
                            type="email" class="form-control" name="email"
                            value="{{ old('email', $user->email ?? '') }}"
                            placeholder="example@gmail.com">
                        @error('email')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone Number</label>
                        <input
                            type="text" class="form-control" name="phone"
                            value="{{ old('phone', $user->phone ?? '') }}"
                            placeholder="+92xxxxxxxxxx">
                        @error('phone')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Assign Role <span class="text-danger">*</span></label>
                        <select class="form-select select2" name="role">
                            <option value=""> Select Role </option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ old('role', isset($user) ? $user->roles->first()?->name : '') == $role->name ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="Active"
                               {{ old('status',$user->status ?? '')=='Active'?'selected':'' }}>
                                Active
                            </option>

                            <option
                                value="Inactive"
                                {{ old('status',$user->status ?? '')=='Inactive'?'selected':'' }}>
                                Inactive
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ======================== PERSONAL INFORMATION ======================== --}}
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="ti ti-user me-2"></i>
            Personal Information
        </h5>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- Gender -->
            <div class="col-md-4 mb-3">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-select select2">
                    <option value=""> Select Gender </option>
                    <option
                        value="Male"
                        {{ old('gender',$user->gender ?? '')=='Male'?'selected':'' }}>
                        Male
                    </option>

                    <option
                        value="Female"
                        {{ old('gender',$user->gender ?? '')=='Female'?'selected':'' }}>
                        Female
                    </option>

                    <option
                        value="Other"
                        {{ old('gender',$user->gender ?? '')=='Other'?'selected':'' }}>
                        Other
                    </option>
                </select>
                @error('gender')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <!-- Date of Birth -->
            <div class="col-md-4 mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" name="date_of_birth" class="form-control"
                    value="{{ old('date_of_birth', $user->date_of_birth ?? '') }}">
                @error('date_of_birth')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <!-- Phone -->
            <div class="col-md-4 mb-3">
                <label class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone"
                    value="{{ old('phone', $user->phone ?? '') }}"
                    placeholder="+92xxxxxxxxxx">
                @error('phone')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror
            </div>
        </div>
    </div>
</div>

{{-- ======================== LOCATION INFORMATION ======================== --}}
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="ti ti-map-pin me-2"></i>
            Location Information
        </h5>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- Country -->
            <div class="col-md-4 mb-3">
                <label class="form-label">Country</label>
                <select name="country_id" id="country_id" class="form-select select2">
                    <option value=""> Select Country </option>
                    @foreach($countries as $country)
                        <option
                            value="{{ $country->id }}"
                            {{ old('country_id', $user->country_id ?? '')==$country->id?'selected':'' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- State -->
            <div class="col-md-4 mb-3">
                <label class="form-label"> State </label>
                <select name="state_id" id="state_id" class="form-select select2">
                    <option value="">
                        Select State
                    </option>
                </select>
            </div>

            <!-- City -->
            <div class="col-md-4 mb-3">
                <label class="form-label"> City </label>
                <select name="city_id" id="city_id" class="form-select select2">
                    <option value="">
                        Select City
                    </option>
                </select>
            </div>
        </div>

        <div class="row">
            <!-- Address -->
            <div class="col-md-12 mb-3">
                <label class="form-label"> Address </label>
                <textarea rows="3" class="form-control" name="address"
                    placeholder="Enter Address">{{ old('address', $user->address ?? '') }}</textarea>
            </div>
        </div>
    </div>
</div>

{{-- ======================== ABOUT USER ======================== --}}
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="ti ti-file-description me-2"></i>
            About User
        </h5>
    </div>

    <div class="card-body">
        <textarea name="bio" rows="5" class="form-control" placeholder="Write something about this user...">{{ old('bio', $user->bio ?? '') }}</textarea>
        @error('bio')
            <small class="text-danger">
                {{ $message }}
            </small>
        @enderror
    </div>
</div>

{{-- ======================== LOGIN CREDENTIALS ======================== --}}
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="ti ti-lock me-2"></i>
            Login Credentials
        </h5>
    </div>

    <div class="card-body">
        <div class="row">
            <!-- Auto Generate Password -->
            <div class="col-md-12 mb-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="autoPassword" checked>
                    <label class="form-check-label fw-semibold">
                        Auto Generate Password
                    </label>
                </div>
            </div>

            <!-- Password -->
            <div class="col-md-5 mb-3">
                <label class="form-label"> Password <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="password" name="password" readonly>
                @error('password')
                    <small class="text-danger">
                        {{ $message }}
                    </small>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="col-md-5 mb-3">
                <label class="form-label"> Confirm Password <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="password_confirmation" name="password_confirmation" readonly>
            </div>

            <!-- Buttons -->
            <div class="col-md-2 mb-3">
                <label class="form-label d-block"> Action </label>
                <div class="d-flex">
                    <button type="button" class="btn btn-outline-success me-2" id="generatePassword">
                        <i class="ti ti-refresh"></i>
                    </button>
                    <button type="button" class="btn btn-outline-primary" id="copyPassword">
                        <i class="ti ti-copy"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="alert alert-label-info mt-3 mb-0">
            <i class="ti ti-info-circle me-2"></i>
            The generated password can be copied and shared with the user.
        </div>
    </div>
</div>

{{-- ======================== ACCOUNT SETTINGS ======================== --}}
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="ti ti-settings me-2"></i>
            Account Settings
        </h5>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" checked name="email_verified">
                    <label class="form-check-label"> Mark Email as Verified </label>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" checked name="send_credentials">
                    <label class="form-check-label"> Send Login Credentials via Email </label>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ======================== FORM ACTIONS ======================== --}}
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-end">
            <a href="{{ route('users.index') }}" class="btn btn-label-secondary me-2">
                <i class="ti ti-x me-1"></i>
                Cancel
            </a>
            <button type="reset" class="btn btn-outline-warning me-2">
                <i class="ti ti-refresh me-1"></i>
                Reset
            </button>

            <button class="btn btn-primary">
                @if(isset($user))
                    Update User
                @else
                    Create User
                @endif
            </button>
        </div>
    </div>
</div>

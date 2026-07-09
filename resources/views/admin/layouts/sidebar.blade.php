<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
    <a href="index.html" class="app-brand-link">
        <span class="app-brand-logo demo">
        <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                fill="#7367F0"
            />
            <path
                opacity="0.06"
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
                fill="#161616"
            />
            <path
                opacity="0.06"
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
                fill="#161616"
            />
            <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                fill="#7367F0"
            />
        </svg>
        </span>
        <span class="app-brand-text demo menu-text fw-bold">Vuexy</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
        <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
    </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item {{ Route::is('admin.dashboard') ? 'active open' : '' }} ">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Dashboards">Dashboards</div>
            </a>
        </li>

        <!-- Apps & Pages -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Apps &amp; Pages</span>
        </li>
        <li class="menu-item {{ Route::is('permissions.*') ||
                                Route::is('settings.*') ||
                                Route::is('roles.*') ? 'active open' : '' }} ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-settings"></i>
                <div data-i18n="Administration">Administration</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('roles') ? 'open active' : '' }}">
                    <a href="{{ route('roles.index') }}" class="menu-link">
                        <div data-i18n="Roles">Roles</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('permissions') ? 'open active' : '' }}">
                    <a href="{{ route('permissions.index') }}" class="menu-link">
                        <div data-i18n="Permission">Permission</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('settings') ? 'open active' : '' }}">
                    <a href="{{ route('settings.index') }}" class="menu-link">
                        <div data-i18n="Settings">Settings</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ Route::is('users.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="User Management">User Management</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('users') ? 'open active' : '' }}">
                    <a href="{{ route('users.index') }}" class="menu-link">
                    <div data-i18n="User List">User List</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ Route::is('destinations.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-route"></i>
                <div data-i18n="Destinations">Destinations</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('destinations') ? 'open active' : '' }}">
                    <a href="{{ route('destinations.index') }}" class="menu-link">
                    <div data-i18n="Destinations">Destinations</div>
                    </a>
                </li>
            </ul>
        </li>
        @canany(['tour-itineraries-list',
                 'tour-departures-list',
                 'tour-category-list',
                 'tour-includes-list',
                 'tour-excludes-list',
                 'tour-images',
                 'tours-list'
                ])
            <li class="menu-item {{ Route::is('tour_itineraries.*') ||
                                    Route::is('tour_departures.*') ||
                                    Route::is('tour_categories.*') ||
                                    Route::is('tour_includes.*') ||
                                    Route::is('tour_excludes.*') ||
                                    Route::is('tour_images.*') ||
                                    Route::is('tours.*') ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-map-2"></i>
                    <div data-i18n="Tours">Tours</div>
                </a>
                <ul class="menu-sub">
                    @can('tour-category-list')
                        <li class="menu-item {{ request()->is('tour_categories.*') ? 'open active' : '' }}">
                            <a href="{{ route('tour_categories.index') }}" class="menu-link">
                            <div data-i18n="Tour Categories">Tour Categories</div>
                            </a>
                        </li>
                    @endcan
                    @can('tours-list')
                        <li class="menu-item {{ request()->is('tours.*') ? 'open active' : '' }}">
                            <a href="{{ route('tours.index') }}" class="menu-link">
                            <div data-i18n="Tours">Tours</div>
                            </a>
                        </li>
                    @endcan
                    @can('tour-images-list')
                        <li class="menu-item {{ request()->is('tour_images.*') ? 'open active' : '' }}">
                            <a href="{{ route('tour_images.index') }}" class="menu-link">
                            <div data-i18n="Tour Images">Tour Images</div>
                            </a>
                        </li>
                    @endcan
                    @can('tour-itineraries-list')
                        <li class="menu-item {{ request()->is('tour_itineraries.*') ? 'open active' : '' }}">
                            <a href="{{ route('tour_itineraries.index') }}" class="menu-link">
                            <div data-i18n="Tour Itinerary">Tour Itinerary</div>
                            </a>
                        </li>
                    @endcan
                    @can('tour-includes-list')
                        <li class="menu-item {{ request()->is('tour_includes.*') ? 'open active' : '' }}">
                            <a href="{{ route('tour_includes.index') }}" class="menu-link">
                            <div data-i18n="Tour Includes">Tour Includes</div>
                            </a>
                        </li>
                    @endcan
                    @can('tour-excludes-list')
                        <li class="menu-item {{ request()->is('tour_excludes.*') ? 'open active' : '' }}">
                            <a href="{{ route('tour_excludes.index') }}" class="menu-link">
                            <div data-i18n="Tour Excludes">Tour Excludes</div>
                            </a>
                        </li>
                    @endcan
                    @can('tour-departures-list')
                        <li class="menu-item {{ request()->is('tour_departures.*') ? 'open active' : '' }}">
                            <a href="{{ route('tour_departures.index') }}" class="menu-link">
                            <div data-i18n="Tour Departures">Tour Departures</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany
    </ul>
</aside>

<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('admin/assets/') }}/" data-template="vertical-menu-template">
    @include('admin.layouts.header')
  <body>
    <!-- Layout wrapper -->
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                <!-- Menu -->
                    @include('admin.layouts.sidebar')
                <!-- / Menu -->

                <!-- Layout container -->
                    <div class="layout-page">
                        <!-- Navbar -->
                            @include('admin.layouts.topbar')
                        <!-- / Navbar -->

                        <!-- Content wrapper -->
                            <div class="content-wrapper">
                                <!-- Content -->
                                    <div class="container-xxl flex-grow-1 container-p-y">
                                        @yield('content')
                                    </div>
                                <!-- / Content -->

                                @include('admin.layouts.footer')
                                <div class="content-backdrop fade"></div>
                            </div>
                        <!-- Content wrapper -->
                    </div>
                <!-- / Layout page -->
            </div>
            <div class="layout-overlay layout-menu-toggle"></div>
            <div class="drag-target"></div>
        </div>
    <!-- / Layout wrapper -->
    @include('admin.layouts.scripts')
    @stack('scripts')
  </body>
</html>

<!doctype html>
<html
    lang="en"
    data-layout="vertical"
    data-topbar="light"
    data-sidebar="dark"
    data-sidebar-size="lg"
    data-sidebar-image="none"
    data-preloader="disable">

<head>
    @include('admin.components.head')
</head>

<body>

<!-- Begin page -->
<div id="layout-wrapper">

    @include('admin.components.header')
    <!-- ========== App Menu ========== -->
    @include('admin.components.sidebar')
    <!-- Left Sidebar End -->
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        @include('admin.components.footer')
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->


<!--start back-to-top-->
<button
    onclick="topFunction()"
    class="btn btn-danger btn-icon"
    id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->

<!--preloader-->
<div id="preloader">
    <div id="status">
        <div
            class="spinner-border text-primary avatar-sm"
            role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>

<div class="customizer-setting d-none d-md-block">
    <div
        class="btn-info rounded-pill shadow-lg btn btn-icon btn-lg p-2"
        data-bs-toggle="offcanvas"
        data-bs-target="#theme-settings-offcanvas"
        aria-controls="theme-settings-offcanvas">
        <i class='mdi mdi-spin mdi-cog-outline fs-22'></i>
    </div>
</div>


@include('admin.components.script')
</body>

</html>

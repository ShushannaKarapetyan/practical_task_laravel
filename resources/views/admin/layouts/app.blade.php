<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Custom fonts for this template-->
{{--    <link href="{{ asset('/template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">--}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('/template/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body id="page-top">
<!-- Page Wrapper -->
<div id="wrapper">
    @include('admin.layouts.partials._sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            @include('admin.layouts.partials._navbar')

            <!-- Begin Page Content -->
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        @include('admin.layouts.partials._footer')
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Bootstrap core JavaScript-->
<script src="{{ asset('/template/vendor/jquery/jquery.min.js') }} "></script>

<script src="{{ asset('/template/vendor/bootstrap/js/bootstrap.bundle.min.js') }} "></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('/template/vendor/jquery-easing/jquery.easing.min.js') }} "></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('/template/js/sb-admin-2.min.js') }} "></script>

<!-- Page level custom scripts -->

{{--@stack('scripts')--}}
</body>
</html>

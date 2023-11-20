<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/jqvmap/dist/jqvmap.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/datatables/datatables.min.css">

    <link rel="stylesheet"
        href="{{ asset('') }}assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('') }}assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">

    <link rel="stylesheet" href="{{ asset('') }}assets/modules/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/modules/jquery-selectric/selectric.css">
    {{-- <link rel="stylesheet"
        href="{{ asset('') }}assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css"> --}}

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('') }}assets/css/style.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/css/components.css">

</head>

<body>
    <div id="preloder">
        <div class="loader"></div>
    </div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            @include('admin.layout.navbar')
            <div class="main-sidebar sidebar-style-2">
                @include('admin.layout.sidebar')
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    @yield('content')
                </section>
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    {{ env('APP_NAME') }}
                </div>
                <div class="footer-right">

                </div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('') }}assets/modules/jquery.min.js"></script>
    <script src="{{ asset('') }}assets/modules/popper.js"></script>
    <script src="{{ asset('') }}assets/modules/tooltip.js"></script>
    <script src="{{ asset('') }}assets/modules/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ asset('') }}assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
    <script src="{{ asset('') }}assets/modules/moment.min.js"></script>
    <script src="{{ asset('') }}assets/js/stisla.js"></script>

    <!-- JS Libraies -->
    <script src="{{ asset('') }}assets/modules/jquery.sparkline.min.js"></script>
    <script src="{{ asset('') }}assets/modules/chart.min.js"></script>
    <script src="{{ asset('') }}assets/modules/owlcarousel2/dist/owl.carousel.min.js"></script>
    <script src="{{ asset('') }}assets/modules/summernote/summernote-bs4.js"></script>
    <script src="{{ asset('') }}assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>
    <script src="{{ asset('') }}assets/modules/datatables/datatables.min.js"></script>
    <script src="{{ asset('') }}assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('') }}assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js"></script>
    <script src="{{ asset('') }}assets/modules/jquery-ui/jquery-ui.min.js"></script>
    <script src="{{ asset('') }}assets/modules/bootstrap-daterangepicker/daterangepicker.js"></script>
    {{-- <script src="{{ asset('') }}assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script> --}}
    <script src="{{ asset('') }}assets/modules/select2/dist/js/select2.full.min.js"></script>
    <script src="{{ asset('') }}assets/modules/jquery-selectric/jquery.selectric.min.js"></script>
    <script src="{{ asset('') }}assets/modules/sweetalert/sweetalert.min.js"></script>


    <!-- Page Specific JS File -->
    <script src="{{ asset('') }}assets/js/page/forms-advanced-forms.js"></script>

    <!-- Template JS File -->
    <script src="{{ asset('') }}assets/js/scripts.js"></script>
    <script src="{{ asset('') }}assets/js/custom.js"></script>
    <script>
        function showLoading() {
            $(".loader").show();
            $("#preloder").delay(50).fadeIn("fast");
        }

        function hideLoading() {
            $(".loader").fadeOut();
            $("#preloder").delay(50).fadeOut("fast");
        }
        $(window).on('load', function() {
            $(".loader").fadeOut();
            $("#preloder").delay(200).fadeOut("slow");
        });

        var debounce = function(func, delay) {
            var timeoutId;
            return function() {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(func, delay);
            };
        };
    </script>
    @isset($script)
        @include($script)
    @endisset
</body>

</html>

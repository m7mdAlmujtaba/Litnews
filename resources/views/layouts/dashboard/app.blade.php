<!DOCTYPE html>
<html>

<head>
    <!-- Head -->
    @include('includes/dashboard/head')
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        @include('includes/dashboard/header')

        <!-- Sidebar -->
        @include('includes/dashboard/navigation')

        <!-- Content Wrapper. Contains page content -->
        <div class="relative md:ml-64 bg-blueGray-50">
            <!-- page content -->
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        @include('includes/dashboard/footer')
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" charset="utf-8"></script>
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>

    @yield('js')
</body>

</html>
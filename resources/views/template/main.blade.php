<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>WEB ADMIN</title>

      <!-- Google Font: Source Sans Pro -->
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
      <!-- Font Awesome Icons -->
      <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">

      <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/toastr/toastr.min.css') }}">
      <!-- Theme style -->
      <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/adminlte.min.css') }}">

      @yield('custom-css')
      <style type="text/css">
        #pageloader
        {
            background: rgba( 255, 255, 255, 0.8 );
            display: none;
            height: 100%;
            position: fixed;
            width: 100%;
            z-index: 9999;
        }

        #pageloader img
        {
            left: 40%;
            margin-left: -32px;
            margin-top: -32px;
            position: absolute;
            top: 30%;
        }
    </style>
      <style type="text/css">
        .nav-sidebar .nav-item .nav-link.active {
        /* background-color: $color; */
        color: #fff;
        }
      </style>
    </head>
{{-- <body class="hold-transition sidebar-mini"> --}}
    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">
  <!-- Navbar -->
  @include('template.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('template.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


    <div id="pageloader">

        <img src="{{ asset('AdminLTE/dist/img/loader.gif') }}" alt="processing..." />

    </div>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>@yield('content-title')</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                @yield('content-breadcrumb')
              {{-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">General Form</li> --}}
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->

    <section class="content">
        <div class="container-fluid">
            @yield('content')
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  {{-- <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer> --}}

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{ asset('AdminLTE/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('AdminLTE/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{ asset('AdminLTE/dist/js/demo.js') }}"></script> --}}
<!-- Page specific script -->
<script src="{{ asset('AdminLTE/plugins/toastr/toastr.min.js') }}"></script>
@yield('custom-js')

<script>

$(function () {
  bsCustomFileInput.init();
});
</script>
<script type="text/javascript">

    $(document).ready(function(){
        $("#logout_btn").on("click", function(){
            $("#pageloader").fadeIn();
        });//submit
    });//document ready

</script>

<script>

    @if(Session::has('message'))
      toastr.options =
      {
          "closeButton" : true,
          "progressBar" : true
      }
              toastr.success("{{ session('message') }}");
    @endif
</script>
<script>

@foreach ($errors->all() as $error)
    toastr.error("{{ $error }}");
 @endforeach
</script>
</body>
</html>

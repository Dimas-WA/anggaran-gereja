<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> APP</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://adminlte.io/themes/v3/dist/css/adminlte.min.css?v=3.2.0">
  <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/toastr/toastr.min.css') }}">

  <style>
    @keyframes spinner {
      to {transform: rotate(360deg);}
    }

    .spinner:after {
      content: '';
      box-sizing: border-box;
      position: absolute;
      top: 50%;
      left: 50%;
      width: 20px;
      height: 10px;
      margin-top: -10px;
      margin-left: -10px;
      border-radius: 50%;
      border: 2px solid #ccc;
      border-top-color: #333;
      animation: spinner .6s linear infinite;
    }

    #submit-btn.loading {
      position: relative;
      pointer-events: none;
    }

    #submit-btn.loading:after {
      content: '';
      box-sizing: border-box;
      position: absolute;
      top: 50%;
      left: 50%;
      width: 20px;
      height: 20px;
      margin-top: -10px;
      margin-left: -10px;
      border-radius: 50%;
      border: 2px solid #ccc;
      border-top-color: #333;
      animation: spinner .6s linear infinite;
    }

    @keyframes spinner {
      to {transform: rotate(360deg);}
    }
</style>

<style>
    .container {
        max-width: 500px;
    }
    .reload {
        font-family: Lucida Sans Unicode
    }
</style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  {{-- <div class="card card-outline card-primary"> --}}
    <div class="card card-outline card-primary" style="border-top-color: #015f7a">
    <div class="card-header text-center">
      <a href="#" class="h1" style="color: #00728f"><b> APP</b></a>
      <p class="login-box-msg"></p>
    </div>
    <div class="card-body">
      {{-- <p class="login-box-msg">Sign in to start your session</p> --}}

      {{-- <form action="#" method="post"> --}}

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
        @if ($errors->has('username'))
        <span class="text-danger">{{ $errors->first('username') }}</span>
        @endif
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" name="username" required autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>

        </div>


        @if ($errors->has('password'))
        <span class="text-danger">{{ $errors->first('password') }}</span>
        @endif
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="form-group mt-4 mb-4">
            <div class="captcha">
                <span>{!! captcha_img() !!}</span>
                <button type="button" class="btn btn-danger" class="reload" id="reload">
                    &#x21bb;
                </button>
            </div>
        </div>
        <div class="form-group mb-4">
            <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              {{-- <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label> --}}
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" style="background-color: #015f7a; border-color: #015f7a" id="submit-btn">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        <a href="{{ route('forgot.pass') }}">I forgot my password</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('AdminLTE/dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/toastr/toastr.min.js') }}"></script>

<script>
    const submitBtn = document.getElementById('submit-btn');
    document.querySelector('#submit-btn').addEventListener('click', function() {
      submitBtn.innerText = '....';
      this.classList.add('loading');

      setTimeout(function() {
        document.querySelector('form').submit();
      }, 5000); // Menunggu 5 detik sebelum formulir dikirim
    });

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

<script type="text/javascript">
    $('#reload').click(function () {
        $.ajax({
            type: 'GET',
            url: 'reload-captcha',
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
    });
</script>
</body>
</html>

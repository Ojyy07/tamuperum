<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Buku Tamu | Log in</title>
  <?php  
  $company_name = DB::table('profil_settings')->limit('1')->first();
  ?>
  <link rel="icon" type="image/png" href="{{asset('foto')}}/{{$company_name->logo_profil}}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('panel/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('panel/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">

  <link rel="stylesheet" href="{{asset('panel/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">

  <link rel="stylesheet" href="{{asset('panel/plugins/toastr/toastr.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('panel/dist/css/adminlte.min.css')}}">
</head>
<style type="text/css">
  body {
    margin: 0;
    overflow: hidden;
  }
</style>
<body style="background-image: url('{{asset('bg_login.jpeg')}}');background-size: 100% 100%;background-repeat: no-repeat;">
  <!-- <body style="background-image:url('{{asset('images/90977.jpg')}}');background-size:100% 100%;"> -->
    <div id="particles-js"></div>
    <div class="login-box" style="position: absolute;top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="" class="h4"><b>Sistem Informasi</b> Buku Tamu</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">AUTH LOGIN | WEB TAMU</p>

        <form id="myForm" method="post">
          @csrf
          <div class="input-group mb-3">
            <input type="text" id="username" required="" name="username" autocomplete="off" class="form-control" placeholder="Email/Username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" id="password" required="" name="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
          </div>

          <div class="social-auth-links text-center mt-2 mb-3">
            <button class="btn btn-block btn-primary submit">
              LOGIN <span id="submit"></span>
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <!-- jQuery -->
</body>
<script src="{{asset('panel/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('panel/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('panel/dist/js/adminlte.min.js')}}"></script>
<script src="{{asset('particles/particles.js')}}"></script>
<script src="{{asset('particles/demo/js/app.js')}}"></script>

<!-- stats.js -->
<script src="{{asset('particles/demo/js/lib/stats.js')}}"></script>
<script src="{{asset('panel/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('panel/plugins/toastr/toastr.min.js')}}"></script>

<script type="text/javascript">
 var Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});
 document.getElementById('myForm').addEventListener('submit', function(e) {
  e.preventDefault();
  var username=$('#username').val();
  var password=$('#password').val();
  $(".submit").attr('disabled',true);
  if (username != '' && password != '') {
    $("#submit").html('<div class="spinner-border spinner-border-sm" role="status"><span class="sr-only">Loading...</span></div>');
  }
  $.ajax({
    url : "{{route('ceklogin')}}",
    type : 'POST',
    data : {
      '_method' : 'POST',
      '_token' : '{{ csrf_token() }}',
      'username' : username,
      'password' : password
    },
    success: function(response) {
      $(".submit").attr('disabled',false);
      $("#submit").html('');
      if(response.masuk_user) {
        window.location=response.masuk_user;
      }
      if (response.notmasuk) {
        toastr.error('Login Gagal, Username/Password yang anda masukkan tidak sesuai.');
      }
      if (response.kosong) {
        Swal.fire({
          icon: "info",
          type: "info",
          title: 'Masukkan Data',
          text: 'Harap masukkan username dan Password anda.',
          showConfirmButton: false,
          timer: 1500
        });
      }
    },
    error: function(response) {
      $(".submit").attr('disabled',false);
      $("#submit").html('');
      Swal.fire({
        icon: "error",
        type: "error",
        title: 'Terjadi Kesalahan',
        text: 'Terjadi Kesalahan, permintaan data tidak dikirim.'
      });
    }
  });     
});     
</script>
</html>

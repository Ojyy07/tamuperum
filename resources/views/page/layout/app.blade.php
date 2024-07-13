<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Web Tamu | @yield('title')</title>
  <?php  
  $company_name = DB::table('profil_settings')->limit('1')->first();
  $prof = App\Models\User::join('biodata','biodata.id_users','=','users.id')
  ->where('users.id',Auth::user()->id)
  ->first();
  ?>
  <link rel="icon" type="image/png" href="{{asset('foto')}}/{{$company_name->logo_profil}}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('panel/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css')}}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('panel/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('panel/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('panel/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('panel/plugins/toastr/toastr.min.css')}}">

  <link rel="stylesheet" href="{{asset('panel/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('panel/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <!-- <link rel="stylesheet" href="{{asset('panel/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}"> -->
  <link rel="stylesheet" href="{{asset('panel/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('panel/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <!-- <link rel="stylesheet" href="{{asset('panel/plugins/jqvmap/jqvmap.min.css')}}"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('panel/dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('panel/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <!-- <link rel="stylesheet" href="{{asset('panel/plugins/daterangepicker/daterangepicker.css')}}"> -->
  <!-- summernote -->
</head>
<style type="text/css">
  .modal-loading {
    display: flex;
    justify-content: center;
    align-items: center;
    position: absolute;
    top: 50%;
    left: 50%;
    z-index: 9999;
    visibility: hidden;
  }
  .modal-body {
    position: relative;
  }
  .modal.show .modal-loading {
    visibility: visible;
  }
  #loading {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    z-index: 9999;
    text-align: center;
    padding-top: 20%;
  }
</style>
@yield('css')
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="{{asset('foto')}}/{{$company_name->logo_profil}}" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <!-- <li class="nav-item d-none d-sm-inline-block">
          <a href="index3.html" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Contact</a>
        </li> -->
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-user"></i>
            <!-- <span class="badge badge-warning navbar-badge">15</span> -->
            {{Auth::user()->name}}
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">Profile Saya</span>
            <div class="dropdown-divider"></div>
            <a href="#" data-toggle="modal" data-target="#modal_form_profile" class="dropdown-item">
              <i class="fas fa-user mr-2"></i> Profile
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{route('logout')}}" class="dropdown-item">
              <i class="fas fa-sign-out-alt mr-2"></i> Logout
              <!-- <span class="float-right text-muted text-sm">12 hours</span> -->
            </a>
          </div>
        </li>

        <!-- Messages Dropdown Menu -->

        <!-- Notifications Dropdown Menu -->

        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
       <!--  <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li> -->
      </ul>
    </nav>
    <!-- /.navbar -->
    <div class="modal fade" data-backdrop="static" id="modal_form_profile">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Ubah Profile</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" id="profieForm" enctype="multipart/form-data">
              @csrf
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Nama <span class="text text-danger">*</span></label>
                    <input type="text" value="{{Auth::user()->name}}" class="form-control" required="" name="name_user" id="name_user">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Email <span class="text text-danger">*</span></label>
                    <input type="email" class="form-control" value="{{Auth::user()->email}}" required="" name="email_user" id="email_user">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Username <span class="text text-danger">*</span></label>
                    <input type="text" class="form-control" value="{{Auth::user()->username}}" required="" name="username_user" id="username_user">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Telepon <span class="text text-danger">*</span></label>
                    <input type="number" value="{{$prof->telepon}}" class="form-control" required="" name="telepon_user" id="telepon_user">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Password <span class="text text-danger password_label"></span></label>
                    <input type="password" class="form-control password" name="password_user" id="password_user">
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Confirm Password <span class="text text-danger password_label"></span></label>
                    <input type="password" class="form-control password" name="confirm_password_user" id="confirm_password_user">
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Foto</label>
                    <input type="text" hidden="" value="{{$prof->foto}}" id="fotoLama_user" name="fotoLama_user">
                    <input type="text" hidden="" value="{{$prof->id}}" id="id_user" name="id_user">
                    <input type="file" class="form-control" name="foto_user" id="foto_user">
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-loading" id="modal-loading" style="display: none;">
              <span class="fa fa-spinner fa-spin fa-3x"></span>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
              <button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Ubah</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="" class="brand-link text-center">
        <!-- <img src="{{asset('panel/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
        <span class="brand-text font-weight-light" style="font-weight: bold;">Buku Tamu</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        @include('page.layout.sidebar')
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      @yield('content')
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2024 <a href="">{{$prof->nama_profil}}</a>.</strong>
      All rights reserved.
      <!-- <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.2.0
      </div> -->
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="{{asset('panel/plugins/jquery/jquery.min.js')}}"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{asset('panel/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <!-- Bootstrap 4 -->
  <script src="{{asset('panel/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- ChartJS -->

  <script src="{{asset('panel/plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('panel/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{asset('panel/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
  <script src="{{asset('panel/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
  <script src="{{asset('panel/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
  <script src="{{asset('panel/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
  <script src="{{asset('panel/plugins/jszip/jszip.min.js')}}"></script>
  <script src="{{asset('panel/plugins/pdfmake/pdfmake.min.js')}}"></script>
  <script src="{{asset('panel/plugins/pdfmake/vfs_fonts.js')}}"></script>
  <script src="{{asset('panel/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
  <script src="{{asset('panel/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
  <script src="{{asset('panel/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

  <script src="{{asset('panel/plugins/select2/js/select2.full.min.js')}}"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script> -->
  <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>  -->

  <script src="{{asset('panel/plugins/chart.js/Chart.min.js')}}"></script>
  <!-- <script src="{{asset('panel/chart.min.js')}}"></script> -->
  <!-- Sparkline -->
  <!-- <script src="{{asset('panel/plugins/sparklines/sparkline.js')}}"></script> -->
  <!-- JQVMap -->
  <!-- <script src="{{asset('panel/plugins/jqvmap/jquery.vmap.min.js')}}"></script> -->
  <!-- <script src="{{asset('panel/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script> -->
  <script src="{{asset('panel/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
  <!-- jQuery Knob Chart -->
  <!-- <script src="{{asset('panel/plugins/jquery-knob/jquery.knob.min.js')}}"></script> -->
  <!-- daterangepicker -->
  <!-- <script src="{{asset('panel/plugins/moment/moment.min.js')}}"></script> -->
  <!-- <script src="{{asset('panel/plugins/daterangepicker/daterangepicker.js')}}"></script> -->
  <!-- Tempusdominus Bootstrap 4 -->
  <!-- <script src="{{asset('panel/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script> -->
  <!-- Summernote -->
  <!-- overlayScrollbars -->
  <script src="{{asset('panel/plugins/toastr/toastr.min.js')}}"></script>
  <script src="{{asset('panel/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('webcam.min.js')}}"></script>
  
  <script src="{{asset('panel/dist/js/adminlte.js')}}"></script>
  <!-- AdminLTE for demo purposes -->
  <!-- <script src="{{asset('panel/dist/js/demo.js')}}"></script> -->
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <!-- <script src="{{asset('panel/dist/js/pages/dashboard.js')}}"></script> -->
</body>
<script type="text/javascript">
//   $(function() {
//     for (var nk = window.location, 
//       o = $("ul#menu a").filter(function() {
//         return this.href == nk;
//       })
//       .addClass("active")
//       .parent()
//       .addClass("active");;) {
//       if (!o.is("li")) break;
//     o = o.parent()
//     .addClass("in")
//     .parent()
//     .addClass("active");
//   }
// });
$(function() {
  var currentLocation = window.location;
  var activeMenuItem = $("ul#menu a").filter(function() {
    return this.href == currentLocation;
  }).addClass("active").parent().addClass("active");
  while (activeMenuItem.is("li")) {
    activeMenuItem = activeMenuItem.parent().addClass("in").parent().addClass("active menu-open");
  }
});
function show_loading() {
  var elemenModalLoading = document.getElementsByClassName('modal-loading');
  var ModalBody = document.getElementsByClassName('modal-body');
  for (var i = 0; i < elemenModalLoading.length; i++) {
    elemenModalLoading[i].style.display = "block";
  }
  for (var i = 0; i < ModalBody.length; i++) {
    ModalBody[i].style.pointerEvents = "none";
    ModalBody[i].style.background = 'white';
    ModalBody[i].style.opacity = '0.4';
  }
}
function hide_loading() {
  var elemenModalLoading = document.getElementsByClassName('modal-loading');
  var ModalBody = document.getElementsByClassName('modal-body');
  for (var i = 0; i < elemenModalLoading.length; i++) {
    elemenModalLoading[i].style.display = "none";
  }
  for (var i = 0; i < ModalBody.length; i++) {
    ModalBody[i].style.pointerEvents = "auto";
    ModalBody[i].style.background = "transparent";
    ModalBody[i].style.opacity = '1';
  }
}
$(function () {
  $('#profieForm').submit(function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    show_loading();
    $.ajax({
      method: "POST",
      headers: {
        Accept: "application/json"
      },
      contentType: false,
      processData: false,
      url: "{{route('update_profile')}}",
      data: formData,
      success: function (response) {
        hide_loading();
        if (response.status == 'true') {
          $("#profieForm")[0].reset();
          $('#modal_form_profile').modal('hide');
          Swal.fire({
            icon: 'success',
            type: 'success',
            title: 'Success',
            text: response.message
          });
          document.location.href="";
        }else if(response.status == 'password'){
          toastr.error('Konfirmasi Password, Konfirmasi Password yang anda masukkan tidak sesuai.');
        }else {
          Swal.fire({
            icon: 'error',
            type: 'error',
            title: 'Gagal',
            dangerMode: true,
            text: 'Terjadi kesalahan! [data tidak tersimpan]'
          });
        }
      },
      error: function (response) {
        hide_loading();
        Swal.fire({
          icon: 'error',
          type: 'error',
          title: 'Gagal',
          dangerMode: true,
          text: 'Terjadi kesalahan!'
        });
      }
    });
  });
});
</script>
@yield('scripts')
</html>

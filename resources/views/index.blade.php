<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="{{asset('foto')}}/{{$company->logo_profil}}">
  <title>{{$company->nama_profil}} | Web Tamu</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('panel/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('panel/dist/css/adminlte.min.css')}}">

  <link rel="stylesheet" href="{{asset('panel/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('panel/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('panel/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">

  <link rel="stylesheet" href="{{asset('panel/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">

  <link rel="stylesheet" href="{{asset('panel/plugins/toastr/toastr.min.css')}}">
</head>
<style type="text/css">
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
<?php  
function tgl_indo($tanggal){
  $bulan = array (
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $pecahkan = explode('-', $tanggal);
  return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
?>
<body class="hold-transition layout-top-nav">
  <div class="wrapper">
   <div id="loading">
    <span class="fa fa-spinner fa-spin fa-3x"></span>
  </div>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="" class="navbar-brand">
        <img src="{{asset('foto')}}/{{$company->logo_profil}}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{$company->nama_profil}}</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
          <li class="nav-item">
            <a href="" class="nav-link">{{tgl_indo(date('Y-m-d'))}} <span id="live-clock"></span></a>
          </li>
          <!-- End Level two -->
        </ul>
      </li>
    </ul>

  </div>
  <!-- Right navbar links -->
</div>
</nav>
<!-- /.navbar -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <marquee><h4>Selamat datang di Web {{$company->nama_profil}} .</h4></marquee>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"> Buku Tamu</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Layout</a></li>
            <li class="breadcrumb-item active">Buku Tamu Form</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- /.col-md-6 -->
        <div class="col-lg-12">

          <div class="card card-primary card-outline">
            <div class="card-header">
              <h5 class="card-title m-0"><input type="checkbox" checked="" name=""> Identitas Tamu</h5>
              @if(empty(Auth::user()))
              <a href=" {{route('login')}} " style="float: right;"><i class="fas fa-sign-in-alt"></i> LOGIN</a>
              @else
              <a href=" {{route('dashboard')}} " style="float: right;"><i class="fas fa-user"></i> {{Auth::user()->name}}</a>
              @endif
            </div>
            <div class="card-body">
              <form id="tamuForm" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="row">
                  <audio id="myAudio">
                    <source src="{{asset('camera.wav')}}" type="audio/wav">
                    </audio>
                    <div class="col-lg-8">
                      <input type="text" hidden="" id="id_tamu" name="id_tamu">
                      <div class="row">
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label>Nama Tamu <span class="text-danger">*</span></label>
                            <input type="text" required="" class="form-control" name="nama_tamu" id="nama_tamu">
                          </div>
                        </div>
                        <!-- <div class="col-lg-6">
                          <div class="form-group">
                            <label>No WhatsApp <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" required="" name="no_tamu" id="no_tamu">
                          </div>
                        </div> -->
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label>Jenis Kelamin <span class="text-danger">*</span></label>
                            <select class="form-control" required="" name="jekel_tamu" id="jekel_tamu">
                              <option value="Laki-Laki">Laki-Laki</option>
                              <option value="Perempuan">Perempuan</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label>Alamat Tamu <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="alamat_tamu" id="alamat_tamu" required="">
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label>Jenis Kendaraan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="jenis_kendaraan" id="jenis_kendaraan" required="">
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label>No Plat Kendaraan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="no_plat" id="no_plat" required="">
                          </div>
                        </div>
                        <div class="col-lg-6">
                          <div class="form-group">
                            <label>Jumlah Tamu <span class="text-danger">*</span></label>
                            <input type="number" min="1" class="form-control" required="" name="jumlah_tamu" id="jumlah_tamu">
                          </div>
                        </div>
                        <div class="col-lg-4">
                          <div class="form-group">
                            <label>Pilih Warga <span class="text-danger">*</span></label>
                            <button class="btn w-100 btn-outline-primary choose_warga" type="button"><i class="fas fa-eye"></i> PILIH</button>
                          </div>
                        </div>
                        <div class="col-4">
                          <div class="form-group">
                            <label>Nama Warga yang dipilih <span class="text-danger">*</span></label>
                            <select class="form-control" id="id_warga" name="id_warga" required=""></select>
                          </div>
                        </div>
                        <div class="col-4">
                          <div class="form-group">
                            <label>Alamat Warga <span class="text-danger">*</span></label>
                            <select class="form-control" id="alamat_warga" name="alamat_warga" required=""></select>
                          </div>
                        </div>
                        <div class="col-lg-12">
                          <div class="form-group">
                            <label>Keperluan Bertamu <span class="text-danger">*</span></label>
                            <select class="form-control" required="" id="id_keperluan" name="id_keperluan">
                              <option value="">:. PILIH KEPERLUAN .:</option>
                              @foreach($keperluan as $kpr)
                              <option value="{{$kpr->id_keperluan}}">{{$kpr->nama_keperluan}}</option>
                              @endforeach
                            </select>
                            <!-- <textarea class="form-control" rows="4" name="keperluan_tamu" id="keperluan_tamu" required=""></textarea> -->
                          </div>
                        </div>
                        <div class="col-lg-3">
                          <button class="btn btn-sm btn-success form-control" onclick="return confirm('Lanjut untuk pengajuan tamu?')"><i class="fas fa-check"></i> Submit</button>
                        </div>
                        @if(!empty($_GET['id']))
                        <div class="col-lg-3">
                          <a href="{{route('data_tamu')}}" class="btn btn-sm btn-info form-control">Kembali</a>
                        </div>
                        @endif
                      </div>
                    </div>
                    <div class="col-lg-4 text-center">
                      <div class="row">
                        <input type="text" hidden="" id="foto_tamu" name="foto_tamu">
                        <input type="text" hidden="" id="foto_tamuLama" name="foto_tamuLama">
                        <div class="col-lg-12">
                         <div id="not_allowed" style="display: none;">
                           <img src="{{asset('camera_not_allowed.png')}}" id="image_not_allowed" height="320">
                           <button id="aktif-btn" type="button" class="btn btn-sm btn-danger mt-2"><i class="fas fa-info-circle"></i> Izin/Aktifkan Kamera</button>
                         </div>
                         <div id="webcam-container">
                           <div id="webcam"></div>
                           <button id="capture-btn" type="button" style="display: none;" class="btn btn-sm btn-primary mt-2"><i class="fas fa-camera"></i> Ambil Foto</button>
                         </div>
                         <canvas id="captured-photo" style="display: none;"></canvas>
                         <div id="preview-container" style="display: none;">
                          <h5>Preview Foto:</h5>
                          <img id="preview-photo" class="img-fluid" alt="Pratinjau Foto">
                          <button id="reset-btn" type="button" class="btn btn-secondary btn-sm mt-2" style="display: none;"><i class="fas fa-camera"></i> Ambil Foto Ulang</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>

        </div>
        <!-- /.col-md-6 -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
    <div class="modal fade" data-backdrop="static" id="modal_list_warga">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Pilih Warga yang dituju</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" id="formJabatan">
              @csrf
              <div class="row">
                <div class="col-12">
                  <table class="table table-bordered table-hover text-center" id="example1">
                   <thead>
                    <tr>
                      <th>No.</th>
                      <th>Nama</th>
                      <th>Alamat</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                   @foreach($pegawai as $pgw)
                   <tr>
                     <td>{{$loop->index+1}}.</td>
                     <td>{{$pgw->nama_warga}}</td>
                     <td>{{$pgw->alamat_warga}}</td>
                     <td>
                      <a href="javascript:void(0)" more_id="{{$pgw->id_warga}}" more_nama="{{$pgw->nama_warga}}" more_alamat="{{$pgw->alamat_warga}}" more_status="{{$pgw->status_warga}}" more_keterangan="{{$pgw->keterangan}}" class="btn btn-success btn-sm rounded-pill change_warga"><i class="fas fa-check"></i></a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-loading" id="modal-loading" style="display: none;">
          <span class="fa fa-spinner fa-spin fa-3x"></span>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<!-- Main Footer -->
<footer class="main-footer">
  <!-- To the right -->
  <div class="float-right d-none d-sm-inline">
    <!-- Anything you want -->
  </div>
  <!-- Default to the left -->
  <strong>Copyright &copy; 2024 <a href="">{{$company->nama_profil}}</a>.</strong> All rights reserved.
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('panel/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('panel/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('panel/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('panel/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('panel/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('panel/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('panel/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('panel/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('panel/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('panel/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('panel/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="{{asset('panel/plugins/toastr/toastr.min.js')}}"></script>
<script src="{{asset('panel/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('panel/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('webcam.min.js')}}"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script> -->
</body>
<script>
  function updateClock() {
    var waktuSaatIni = new Date();
    var jam = waktuSaatIni.getHours();
    var menit = waktuSaatIni.getMinutes();
    var detik = waktuSaatIni.getSeconds();

    // Format waktu dengan menambahkan nol di depan jika kurang dari 10
    jam = padZero(jam);
    menit = padZero(menit);
    detik = padZero(detik);

    // Menampilkan waktu pada elemen dengan id "live-clock"
    document.getElementById('live-clock').innerHTML = jam + ":" + menit + ":" + detik;
  }

  function padZero(number) {
    return (number < 10 ? '0' : '') + number;
  }

// Memperbarui waktu setiap detik (1000 milidetik)
setInterval(updateClock, 1000);

// Memanggil fungsi untuk pertama kali agar waktu ditampilkan segera saat halaman dimuat
updateClock();

var urlAjax = "";
$(".choose_warga").click(function() {
  $("#modal_list_warga").modal('show');
});
$(function () {
  $("#example1").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false, "lengthMenu": true
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
});
$(".change_warga").click(function() {
  var pegawaiID = $(this).attr('more_id');
  var pegawaiNama = $(this).attr('more_nama');
  var wargaAlamat = $(this).attr('more_alamat');
  var wargaStatus = $(this).attr('more_status');
  var wargaKeterangan = $(this).attr('more_keterangan');
  $("#id_warga").empty();
  $("#alamat_warga").empty();
  if (pegawaiID) {
   if (wargaStatus == 'tidak dirumah 0') {
    Swal.fire({
      icon: 'warning',
      type: 'warning',
      title: 'Warga Tidak dirumah',
      text: 'Keterangan : '+wargaKeterangan
    });
  }else{
    $("#modal_list_warga").modal('hide');
    $("#id_warga").append('<option value="'+pegawaiID+'">'+pegawaiNama+'</option>');
    $("#alamat_warga").append('<option value="'+pegawaiID+'">'+wargaAlamat+'</option>');
  }
}
})
document.addEventListener('DOMContentLoaded', function () {
 function webCamGet() {
   Webcam.set({
    height: 320,
    image_format: 'jpeg',
    jpeg_quality: 100,
    dest_width: 640,
    dest_height: 480
  });
   Webcam.attach('#webcam');
   $("#foto_tamu").val('');
 }
 webCamGet();
 $("#aktif-btn").click(function() {
   webCamGet();
 });
 Webcam.on( 'error', function(err) {
  $("#foto_tamu").val('');
  if (err == 'NotAllowedError: Permission dismissed') {
    $("#not_allowed").css('display','block');
  }
  else if(err == 'NotAllowedError: Permission denied'){
    $("#not_allowed").css('display','block');
    $("#aktif-btn").css('display','none');
  }
});
 Webcam.on( 'live', function() {
  $("#capture-btn").css('display','block');
});
 $(document).on('click','#capture-btn',function() {
  Webcam.snap(function (data_uri) {
    var x = document.getElementById("myAudio"); 
    x.play();
    document.getElementById('webcam-container').style.display = 'none';
    document.getElementById('preview-container').style.display = 'block';

    var canvas = document.getElementById('captured-photo');
    var context = canvas.getContext('2d');

    var img = new Image();
    img.onload = function () {
      context.drawImage(img, 0, 0, canvas.width, canvas.height);
    };
    img.src = data_uri;

    document.getElementById('preview-photo').src = data_uri;
    $("#foto_tamu").val(data_uri);
    $("#reset-btn").css('display','block');
  });
});
 $(document).on('click','#reset-btn',function() {
  webCamGet();
  document.getElementById('webcam-container').style.display = 'block';
  document.getElementById('preview-container').style.display = 'none';

  document.getElementById('reset-btn').style.display = 'none';
  document.getElementById('preview-photo').src = '';
});
});
var tamuID = "";
</script>
@if(!empty($_GET['id']))
<script type="text/javascript">
  urlAjax = "{{route('update_tamu')}}";
  $("#loading").show();
  function get_edit(tamuID) {
    $.ajax({
      type: "GET",
      url: "{{url('page/data-tamu/getEdit')}}?id_tamu="+tamuID,
      success: function(response) {
        if (response) {
          $("#loading").hide();
          $.each(response, function(key, value) {
            $("#instansi").val(value.instansi);
            $("#id_tamu").val(value.id_tamu);
            $("#nama_tamu").val(value.nama_tamu);
            $("#foto_tamuLama").val(value.foto_tamu);
            $("#no_tamu").val(value.no_tamu);
            $("#kategori_tamu").val(value.kategori_tamu).trigger('change_warga');
            $("#id_warga").append('<option value="'+value.id_warga+'">'+value.nama_warga+'</option>');
            $("#jumlah_tamu").val(value.jumlah_tamu);
            $("#email_tamu").val(value.email_tamu);
            $("#keperluan_tamu").val(value.keperluan_tamu);
          });
        }
      },
      error: function(response) {
        get_edit(tamuID);
      }
    });
  }
  $(document).ready(function() {
    tamuID = "{{$_GET['id']}}";
    get_edit(tamuID);
  });
</script>
@else
<script type="text/javascript">
  tamuID = "";
  urlAjax = "{{route('save_tamu')}}";
</script>
@endif
<script type="text/javascript">
 $(function () {
  $('#tamuForm').submit(function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    $("#loading").show();
    $.ajax({
      method: "POST",
      headers: {
        Accept: "application/json"
      },
      contentType: false,
      processData: false,
      url: urlAjax,
      data: formData,
      success: function (response) {
        $("#loading").hide();
        $("#reset-btn").trigger('click');
        if (response.status == 'true') {
          $("#tamuForm")[0].reset();
          $("#id_warga").empty();
          $("#alamat_warga").empty();
          if (tamuID != '') {
            window.location=" {{route('data_tamu')}} ";
          }
          Swal.fire({
            icon: 'success',
            type: 'success',
            title: 'Success',
            text: response.message
          });
        } else {
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
        $("#loading").hide();
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
</html>

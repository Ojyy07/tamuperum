 @extends('page/layout/app')

 @section('title','Data Tamu')

 @section('content')
 <section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Tamu</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('index')}}">Tamu</a></li>
          <li class="breadcrumb-item active"><a href="{{route('index')}}" class="text-muted">Data Tamu</a></li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<div id="loading">
  <span class="fa fa-spinner fa-spin fa-3x"></span>
</div>
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12" id="contentDataTamu">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Tamu
            </h3>
            <a href="javascript:void(0)" style="float: right;" more_action="new" class="btn btn-sm btn-primary text-white new"><i class="fas fa-plus"></i> Tamu Baru</a>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-hover table-striped pegawai_table">
              <thead>
                <tr>
                  <th>No. </th>
                  <th>Foto</th>
                  <th>Nama</th>
                  <th>Jenis Kelamin</th>
                  <th>Alamat</th>
                  <th>Jenis Kendaraan</th>
                  <th>Tujuan ke</th>
                  <th>Keperluan</th>
                  <th>Jumlah Tamu</th>
                  <th>Waktu</th>
                  @if(Auth::user()->level != 'Security')
                  <th>Action</th>
                  @endif
                </tr>
              </thead>
              <tbody>
                <?php
                function tanggal_indonesia($tgl, $tampil_hari=true){
                  $nama_hari=array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu");
                  $nama_bulan = array (
                    1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
                    "September", "Oktober", "November", "Desember");
                  $tahun=substr($tgl,0,4);
                  $bulan=$nama_bulan[(int)substr($tgl,5,2)];
                  $tanggal=substr($tgl,8,2);
                  $text="";
                  if ($tampil_hari) {
                    $urutan_hari=date('w', mktime(0,0,0, substr($tgl,5,2), $tanggal, $tahun));
                    $hari=$nama_hari[$urutan_hari];
                    $text .= $hari.", ";
                  }
                  $text .=$tanggal ." ". $bulan ." ". $tahun;
                  return $text;
                }
                ?>
                @foreach($data as $dt)
                <?php  
                $dateTimeString = $dt->created_at;
                $dateTimeObject = new DateTime($dateTimeString);
                $timeOnly = $dateTimeObject->format('H:i:s');
                ?>
                <tr>
                  <td>{{$loop->index+1}}.</td>
                  <td align="center">
                    @if($dt->foto_tamu == NULL)
                    <span class="badge bg-info">Tanpa foto</span>
                    @else
                    <div class="zoom-container">
                      <img id="zoom-image" more_id="{{$dt->id_tamu}}" src="{{asset('foto')}}/{{$dt->foto_tamu}}" width="65" height="65" class="img rounded-pill zoom-image">
                      <i class="fa fa-search-plus zoom-image"></i>
                    </div>
                    <div id="zoom-modal-{{$dt->id_tamu}}" class="zoom-modal">
                      <span class="close">&times;</span>
                      <img class="zoom-modal-content" id="modal-zoom-image-{{$dt->id_tamu}}">
                    </div>
                    <!-- <img src="{{asset('foto')}}/{{$dt->foto_tamu}}" width="65" height="65" class="img rounded-pill"> -->
                    @endif
                  </td>
                  <td>{{$dt->nama_tamu}}</td>
                  <td>{{$dt->jekel_tamu}}</td>
                  <td>{{$dt->alamat_tamu}}</td>
                  <td>{{$dt->jenis_kendaraan}}<br>{{$dt->no_plat}}</td>
                  <td>{{$dt->alamat_warga}}<br>{{$dt->nama_warga}}</td>
                  <td>{{$dt->nama_keperluan}}</td>
                  <td>{{$dt->jumlah_tamu}}</td>
                  <td>{{tanggal_indonesia($dt->created_at)}} {{$timeOnly}}</td>
                  @if(Auth::user()->level != 'Security')
                  <td align="center">
                    @if(Auth::user()->level == 'Admin' OR Auth::user()->level == 'Leader Security')
                    <a href="javascript:void(0)" more_id="{{$dt->id_tamu}}" more_action="edit" class="btn btn-sm btn-success text-white edit"><i class="fas fa-edit"></i></a>
                    <a href="javascript:void(0)" more_id="{{$dt->id_tamu}}" more_action="view" class="btn btn-sm btn-warning text-white view"><i class="fas fa-eye"></i></a>
                    @endif
                    @if(Auth::user()->level == 'Admin')
                    <a href="javascript:void(0)" class="btn btn-sm btn-danger delete" more_id="{{$dt->id_tamu}}"><i class="fas fa-trash"></i></a>
                    @endif
                  </td>
                  @endif
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- view -->
      <div class="modal fade" data-backdrop="static" id="modal_form_view">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detail Tamu</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-8">
                 <div class="row">
                   <div class="col-lg-3">Nama</div>
                   <div class="col-lg-1">:</div>
                   <div class="col-lg-8" id="nama_tamu_view"></div>
                 </div>
                 <div class="row">
                   <div class="col-lg-3">Jenis Kelamin</div>
                   <div class="col-lg-1">:</div>
                   <div class="col-lg-8" id="jekel_tamu_view"></div>
                 </div>
                 <div class="row">
                   <div class="col-lg-3">Alamat Tamu</div>
                   <div class="col-lg-1">:</div>
                   <div class="col-lg-8" id="alamat_tamu_view"></div>
                 </div>
                 <div class="row">
                   <div class="col-lg-3">Jenis Kendaraan</div>
                   <div class="col-lg-1">:</div>
                   <div class="col-lg-8" id="jenis_kendaraan_view"></div>
                 </div>
                 <div class="row">
                   <div class="col-lg-3">No Plat</div>
                   <div class="col-lg-1">:</div>
                   <div class="col-lg-8" id="no_plat_view"></div>
                 </div>
                 <div class="row">
                   <div class="col-lg-3">Jumlah Tamu</div>
                   <div class="col-lg-1">:</div>
                   <div class="col-lg-8" id="jumlah_tamu_view"></div>
                 </div>
                 <div class="row">
                   <div class="col-lg-3">Tanggal</div>
                   <div class="col-lg-1">:</div>
                   <div class="col-lg-8" id="created_at_tanggal_view"></div>
                 </div>
                 <div class="row">
                   <div class="col-lg-3">Waktu</div>
                   <div class="col-lg-1">:</div>
                   <div class="col-lg-8" id="created_at_waktu_view"></div>
                 </div>
                 <div class="row">
                   <div class="col-lg-3">Bertemu</div>
                   <div class="col-lg-1">:</div>
                   <div class="col-lg-8" id="nama_warga_view"></div>
                 </div>
                 <div class="row">
                   <div class="col-lg-3">Keperluan</div>
                   <div class="col-lg-1">:</div>
                   <div class="col-lg-8" id="nama_keperluan_view"></div>
                 </div>
                 <div class="row">
                   <div class="col-lg-12"><hr></div>
                 </div>
                 <div class="row">
                   <div class="col-lg-3">Status Warga</div>
                   <div class="col-lg-1">:</div>
                   <div class="col-lg-8" id="status_warga_view">
                   </div>
                 </div>
                 <div class="row">
                   <div class="col-lg-3">Keterangan</div>
                   <div class="col-lg-1">:</div>
                   <div class="col-lg-8" id="keterangan_view"></div>
                 </div>
               </div>
               <div class="col-lg-4 text-left" id="foto_tamu_view">
                <!-- <img src="" id="foto_tamu_view" class="img img-fluid"> -->
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
    <!-- end -->
    <div class="col-lg-12" id="contentEditTamu">
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h5 class="card-title m-0" id="label_form_tamu"></h5>
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
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label>Nama Tamu</label>
                        <input type="text" class="form-control" name="nama_tamu" id="nama_tamu">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select class="form-control" name="jekel_tamu" id="jekel_tamu">
                          <option value="">:. JENIS KELAMIN .:</option>
                          <option value="Laki-Laki">Laki-Laki</option>
                          <option value="Perempuan">Perempuan</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label>Alamat Tamu</label>
                        <input type="text" class="form-control" name="alamat_tamu" id="alamat_tamu">
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
                        <label>Jumlah Tamu</label>
                        <input type="number" min="1" class="form-control" name="jumlah_tamu" id="jumlah_tamu">
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
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <button class="btn btn-sm btn-primary form-control submit" onclick="return confirm('Lanjutkan?')"></button>
                    </div>
                    <div class="col-lg-3">
                      <button class="btn btn-sm btn-secondary form-control back" type="button"><i class="fas fa-back"></i> Kembali</button>
                    </div>
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
                      <button id="reset-btn" type="button" class="btn btn-secondary btn-sm mt-2" style="display: none;"><i class="fas fa-camera"></i> Ambil Ulang Foto</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" data-backdrop="static" id="modal_list_warga">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Pilih alamat yang dituju</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <table class="table table-bordered table-hover text-center" id="table_list_warga">
             <thead>
              <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Keterangan</th>
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
                 @if($dt->status_warga == 'dirumah')
                 <span class="badge bg-success text-white">Dirumah</span>
                 @elseif($dt->status_warga == 'tidak dirumah 0')
                 <span class="badge bg-danger text-white">Tidak Dirumah<br>(tidak terima tamu)</span>
                 @elseif($dt->status_warga == 'tidak dirumah 1')
                 <span class="badge bg-danger text-white">Tidak Dirumah<br>(titip pesan ke ptugas)</span>
                 @endif
               </td>
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
</div>
</section>
@endsection
@section('css')
<style type="text/css">
  .zoom-modal {
    display: none;
    position: fixed;
    z-index: 100;
    padding-top: 120px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.9);
  }

  /* Modal Content (image) */
  .zoom-modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    transition: transform 0.25s ease;
  }

  /* The Close Button */
  .zoom-modal .close {
    position: absolute;
    top: 70px;
    right: 35px;
    color: #fff;
    font-size: 50px;
    font-weight: bold;
    transition: 0.3s;
  }

  .zoom-modal .close:hover,
  .zoom-modal .close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
  }

  .zoom-container img:hover {
    cursor: pointer;
  }
</style>
@endsection
@section('scripts')
<script>
  $("#table_list_warga").DataTable();
  $(document).on('click', '.zoom-image', function() {
    var tamuID = $(this).attr('more_id');
    var src = $(this).attr('src');
    var modal = document.getElementById('zoom-modal-'+tamuID);
    var modalImg = document.getElementById('modal-zoom-image-'+tamuID);
    // var span = document.getElementsByClassName('close')[0];

    modal.style.display = "block";
    modalImg.src = src;

    // span.onclick = function() { 
    //   modal.style.display = "none";
    // }
    $(".close").click(function() {
      modal.style.display = "none";
    })

    let isZoomed = false;

    modalImg.onclick = function(e) {
      if (!isZoomed) {
        const rect = modalImg.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const xPercent = x / rect.width * 100;
        const yPercent = y / rect.height * 100;

        modalImg.style.transformOrigin = `${xPercent}% ${yPercent}%`;
        modalImg.style.transform = 'scale(2)';
        isZoomed = true;
      } else {
        modalImg.style.transform = 'scale(1)';
        isZoomed = false;
      }
    }
  });
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print","colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
  $(document).on('click', '.delete', function (event) {
    tamuID = $(this).attr('more_id');
    event.preventDefault();
    Swal.fire({
      title: 'Lanjut Hapus Data?',
      text: 'Data Tamu akan dihapus secara Permanent!',
      icon: 'warning',
      type: 'warning',
      showCancelButton: !0,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: 'Lanjutkan'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          method: "GET",
          url: "{{url('page/data-tamu/destroy')}}"+"/"+tamuID,
          success:function(response)
          {
            setTimeout(function(){
              Swal.fire({
                title: "Data Dihapus!",
                icon: "success",
                type: "success"
              });
              $(".pegawai_table").load(location.href + " .pegawai_table");
            }, 50);
          }
        })
      }
    });
  });

  var urlAjax = "";
  $(".choose_warga").click(function() {
    $("#modal_list_warga").modal('show');
  });
  $(function () {
    $("#example2").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false, "lengthMenu": true
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
  $(".change_warga").click(function() {
    var pegawaiID = $(this).attr('more_id');
    var pegawaiNama = $(this).attr('more_nama');
    var pegawaiAlamat = $(this).attr('more_alamat');
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
        $("#alamat_warga").append('<option value="'+pegawaiAlamat+'">'+pegawaiAlamat+'</option>');
      }
    }
  });

  // document.addEventListener('DOMContentLoaded', function () {
   function webCamGet() {
     Webcam.set({
      height: 250,
      image_format: 'jpeg',
      jpeg_quality: 100,
      dest_width: 640,
      dest_height: 480
    });
     Webcam.attach('#webcam');
     $("#foto_tamu").val('');
   }
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
    Webcam.reset('#webcam');
    document.getElementById('webcam-container').style.display = 'block';
    document.getElementById('preview-container').style.display = 'none';

    document.getElementById('reset-btn').style.display = 'none';
    document.getElementById('preview-photo').src = '';
    webCamGet();
  });
 // });
 function TanggalIndonesia(tanggal) {
  const months = [
  "Januari", "Februari", "Maret", "April", "Mei", "Juni",
  "Juli", "Agustus", "September", "Oktober", "November", "Desember"
  ];
  
  const days = [
  "Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"
  ];

  const now = tanggal ? new Date(tanggal) : new Date();
  const day = days[now.getDay()];
  const date = now.getDate();
  const month = months[now.getMonth()];
  const year = now.getFullYear();

  return `${day}, ${date} ${month} ${year}`;
}
$("#contentEditTamu").css('display','none');
function get_edit(tamuID, action) {
  $.ajax({
    type: "GET",
    url: "{{url('page/data-tamu/getEdit')}}?id_tamu="+tamuID,
    success: function(response) {
      $.each(response, function(key, value) {
        if (action == 'edit') {
          $("#loading").hide();
          $("#contentEditTamu").css('display','block');
          $("#label_form_tamu").html('<i class="fas fa-edit"> Form Ubah Tamu</i>');
          $(".submit").html('<i class="fas fa-edit"></i> Ubah')
          $(".submit").removeClass('btn-primary');
          $(".submit").addClass('btn-success');
          Webcam.reset('#webcam');
          $("#jekel_tamu").val(value.jekel_tamu);
          $("#id_tamu").val(value.id_tamu);
          $("#nama_tamu").val(value.nama_tamu);
          $("#foto_tamuLama").val(value.foto_tamu);
          $("#no_tamu").val(value.no_tamu);
          $("#id_keperluan").val(value.id_keperluan).trigger('change_warga');
          $("#id_warga").append('<option value="'+value.id_warga+'">'+value.nama_warga+'</option>');
          $("#alamat_warga").append('<option value="'+value.alamat_warga+'">'+value.alamat_warga+'</option>');
          $("#jumlah_tamu").val(value.jumlah_tamu);
          $("#jenis_kendaraan").val(value.jenis_kendaraan);
          $("#no_plat").val(value.no_plat);
          $("#alamat_tamu").val(value.alamat_tamu);
          // webCamGet();
          $("#reset-btn").trigger('click');
        }else{
          $("#jekel_tamu_view").html(value.jekel_tamu);
          $("#nama_warga_view").html(value.nama_warga);
          $("#nama_tamu_view").html(value.nama_tamu);
          $("#no_tamu_view").html(value.no_tamu);
          $("#nama_keperluan_view").html(value.nama_keperluan);
          $("#alamat_warga").html(value.alamat_warga);
          $("#jumlah_tamu_view").html(value.jumlah_tamu);
          $("#jenis_kendaraan_view").html(value.jenis_kendaraan);
          $("#no_plat_view").html(value.no_plat);
          $("#alamat_tamu_view").html(value.alamat_tamu);
          $("#keterangan_view").html(value.keterangan);
          $("#created_at_tanggal_view").html(TanggalIndonesia(value.created_at));
          $("#created_at_waktu_view").html(value.created_at.substr(11,8));
          if (value.status_warga == 'dirumah') {
            $("#status_warga_view").html('<span class="badge bg-success text-white">Dirumah</span>');
          }else if(value.status_warga == 'tidak dirumah 0'){
            $("#status_warga_view").html('<span class="badge bg-danger text-white">Tidak Dirumah<br>(tidak terima tamu)</span>');
          }else{
            $("#status_warga_view").html('<span class="badge bg-danger text-white">Tidak Dirumah<br>(titip pesan ke petugas)</span>');
          }
          if (value.foto_tamu != null) {
            $("#foto_tamu_view").html('<img src="{{asset('foto')}}/'+value.foto_tamu+'" class="img-fluid">');
          }else{
            $("#foto_tamu_view").html('');
          }
        }
      });
    },
    error: function(response) {
      get_edit(tamuID,action);
    }
  });
}
$(document).on('click','.new',function() {
  $("#loading").show();
  $("#contentDataTamu").css('display','none');
  setTimeout(function() {
    $("#contentEditTamu").css('display','block');
    $(".submit").html('<i class="fa fa-check"></i> Simpan')
    $(".submit").removeClass('btn-success');
    $(".submit").addClass('btn-primary');
    $("#loading").hide();
    $("#label_form_tamu").html('<i class="fas fa-plus"> Form Tambah Tamu</i>');
    Webcam.reset('#webcam');
    $("#reset-btn").trigger('click');
    var tamuID = $(this).attr('more_id');
    var action = $(this).attr('more_action');
    $("#tamuForm")[0].reset();
    $("#id_warga").empty();
    $("#alamat_warga").empty();
    $("#jekel_tamu").val(null).trigger('change');
    $("#id_keperluan").val(null).trigger('change');
    urlAjax = "{{route('save_tamu')}}";
  }, 600);
});
$(document).on('click','.edit',function() {
  var tamuID = $(this).attr('more_id');
  var action = $(this).attr('more_action');
  $("#tamuForm")[0].reset();
  $("#id_warga").empty();
  $("#alamat_warga").empty();
  $("#jekel_tamu").val(null).trigger('change');
  $("#id_keperluan").val(null).trigger('change');
  $("#contentDataTamu").css('display','none');
  $("#loading").show();
  urlAjax = "{{route('update_tamu')}}";
  get_edit(tamuID,action);
});
$(document).on('click','.view',function() {
  var tamuID = $(this).attr('more_id');
  var action = $(this).attr('more_action');
  $("#modal_form_view").modal('show');
  get_edit(tamuID,action);
});
$(document).on('click','.back',function() {
  $("#contentDataTamu").css('display','block');
  $("#contentEditTamu").css('display','none');
  Webcam.reset('#webcam');
});
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
          Swal.fire({
            icon: 'success',
            type: 'success',
            title: 'Success',
            text: response.message
          });
          $("#contentEditTamu").css('display','none');
          $("#contentDataTamu").css('display','block');
          $(".pegawai_table").load(location.href + " .pegawai_table");
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
@endsection
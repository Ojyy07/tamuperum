 @extends('page/layout/app')

 @section('title','Dashboard Admin')

 @section('content')
 <div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
          <li class="breadcrumb-item active"><a href="{{route('index')}}" class="text-muted">Dashboard v1</a></li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-6 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{$tamu_harian}}</h3>

            <p>Tamu Harian</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href=" {{route('data_tamu')}} " class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-6 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{$tamu_all}}</h3>

            <p>Tamu Keseluruhan</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href=" {{route('data_tamu')}} " class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
   <!--  <div class="row">
      <div class="col-lg-6">
        <canvas id="bar-chart"></canvas>
      </div>
      <div class="col-lg-6">
        <canvas id="pie-chart"></canvas>
      </div>
    </div> -->
    <div class="row mt-2">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Tamu hari ini
            </h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered table-hover table-striped pegawai_table" id="tamu_dash">
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
                  <th>Alamat Tamu</th>
                  <th>Jumlah Tamu</th>
                  <th>Waktu</th>
                </tr>
              </thead>
              <tbody id="content_tamu">
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
                  <td>
                    @if($dt->foto_tamu == NULL)
                    <span class="badge bg-info">Tanpa foto</span>
                    @else
                    <img src="{{asset('foto')}}/{{$dt->foto_tamu}}" width="65" height="65" class="img rounded-pill">
                    @endif
                  </td>
                  <td>{{$dt->nama_tamu}}</td>
                  <td>{{$dt->jekel_tamu}}</td>
                  <td>{{$dt->alamat_tamu}}</td>
                  <td>{{$dt->jenis_kendaraan}}<br>{{$dt->no_plat}}</td>
                  <td>{{$dt->alamat_warga}}<br>{{$dt->nama_warga}}</td>
                  <td>{{$dt->nama_keperluan}}</td>
                  <td>{{$dt->alamat_tamu}}</td>
                  <td>{{$dt->jumlah_tamu}}</td>
                  <td>{{tanggal_indonesia($dt->created_at)}}<br> {{$timeOnly}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> 
</section>
<script>
  $(function () {
    $("#tamu_dash").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>
<script type="text/javascript">
  function read() {
   $.ajax({
    type: "GET",
    url: "{{route('get_tamu_dash')}}",
    success: function(response) {
      if (response > 0) {
        document.location.href = '';
      }
    },
    error: function(response) {
      read();
    }
  });
 }
 $(document).ready(function() {
  setInterval(function(){
    read()
  }, 3000);   
})
</script>
@endsection
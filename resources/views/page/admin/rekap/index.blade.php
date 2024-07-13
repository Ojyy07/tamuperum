 @extends('page/layout/app')

 @section('title','Rekapitulasi Tamu')

 @section('content')
 <section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Rekapitulasi Tamu</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Rekap</a></li>
          <li class="breadcrumb-item active">Rekapitulasi Tamu</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row mb-2">
     <div class="col-lg-5 pb-4" style="background: white;box-shadow:2px 2px grey;">
      <?php  
      if (empty($_GET['awal'])) {
        $awal = "";
        $akhir = "";
      }else{
        $awal = $_GET['awal'];
        $akhir = $_GET['akhir'];
      }
      ?>
      <form method="get" action="">
        @csrf
        <input type="date" required="" title="Tanggal Awal" class="form-control mt-2" name="awal">
        <input type="date" required="" class="form-control mt-2" title="Tanggal Akhir" name="akhir">
        <button class="btn btn-sm btn-primary mt-2"><i class="fas fa-filter"></i> Tampilkan</button>
        <a href="{{route('export_rekap_tamu',['awal'=>$awal,'akhir'=>$akhir,'type'=>'PDF'])}}" target="_blank" class="btn btn-sm btn-danger mt-2 ml-2" style="float: right;"><i class="fas fa-file-pdf"></i></a>
        <a href="{{route('export_rekap_tamu',['awal'=>$awal,'akhir'=>$akhir,'type'=>'Excel'])}}" target="_blank" class="btn btn-sm btn-success mt-2" style="float: right;"><i class="fas fa-file-excel"></i></a>
      </form>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Rekapitulasi Tamu
          </h3>
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
                <th>Alamat Tamu</th>
                <th>Jumlah Tamu</th>
                <th>Waktu</th>
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
              <td>{{tanggal_indonesia($dt->created_at)}} {{$timeOnly}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
</section>
@endsection

@section('scripts')
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>
@endsection
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Export Laporan Data Tamu</title>

  <link rel="stylesheet" href="{{asset('panel/print.css')}}">
</head>
<style type="text/css">
  @page {
    margin: 100px 25px;
  }

  header {
    position: fixed;
    top: -100px;
    left: 0px;
    right: 0px;
    height: 50px;
    font-size: 20px !important;

    /** Extra personal styles **/
    /*background-color: #008B8B;*/
    /*color: white;*/
    text-align: center;
    line-height: 35px;
  }

  footer {
    position: fixed; 
    bottom: -30px; 
    left: 0px; 
    right: 0px;
    height: 50px; 
    font-size: 20px !important;

    /** Extra personal styles **/
    /*background-color: #008B8B;*/
    /*color: white;*/
    text-align: center;
    line-height: 35px;
  }
</style>
<body>
 @if($_GET['type']=="Excel")
 <?php  
 header("Content-type: application/vnd-ms-excel");
 header('Content-Disposition: attachment; filename=Rekap Data Tamu.xls'); 
 ?>
 @endif
 <?php  
 $app = App\Models\Tamu::getApp();
 ?>
 <header>
  <img src="{{asset('foto')}}/{{$app->logo_profil}}" style="float: left;" class="img mt-3" width="70">
  <center>
    {{$app->nama_profil}} <br>Rekapitulasi Data Tamu<br>
    <small>Periode : {{$_GET['awal']}} - {{$_GET['akhir']}}</small>
  </center>
</header>
<!-- <footer>
  <center>
    BUKU TAMU <br>Rekapitulasi Data Tamu<br>
    <small>Periode : {{$_GET['awal']}} - {{$_GET['akhir']}}</small>
  </center>
</footer> -->
<main>
 <div class="card-body">
   @if($_GET['type']=="PDF")
   <table class="table table-bordered">
    @else
    <table style="width: 100%;" border="1">
      @endif
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
          <img src="{{asset('foto')}}/{{$dt->foto_tamu}}" width="50" height="50" class="img rounded-pill">
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
</main>
</body>
</html>

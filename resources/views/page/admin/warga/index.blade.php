 @extends('page/layout/app')

 @section('title','Data warga')

 @section('content')
 <section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Warga</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Data Master</a></li>
          <li class="breadcrumb-item active">Data Warga</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Warga
            </h3>
            <button style="float: right;" type="button" class="btn btn-sm btn-primary new">
              <i class="fas fa-plus"></i> Tambah Warga
            </button>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-hover table-striped warga_table">
              <thead>
                <tr>
                  <th>No. </th>
                  <th>NIK</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Telepon</th>
                  <th>Alamat</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $dt)
                <tr>
                  <td>{{$loop->index+1}}.</td>
                  <td>{{$dt->nik_warga}}</td>
                  <td>{{$dt->nama_warga}}</td>
                  <td>{{$dt->email_warga}}</td>
                  <td>{{$dt->telepon_warga}}</td>
                  <td>{{$dt->alamat_warga}}</td>
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
                    <a href="javascript:void(0)" more_id="{{$dt->id_warga}}" class="btn btn-sm btn-success edit"><i class="fas fa-edit"></i></a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-danger delete" more_id="{{$dt->id_warga}}"><i class="fas fa-trash"></i></a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" data-backdrop="static" id="modal_form_warga">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" id="wargaForm">
            @csrf
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label>NIK <span class="text text-danger">*</span></label>
                  <input type="text" hidden="" name="id_warga" id="id_warga">
                  <input type="number" class="form-control" required="" name="nik_warga" id="nik_warga">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Nama <span class="text text-danger">*</span></label>
                  <input type="text" class="form-control" required="" name="nama_warga" id="nama_warga">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Email <span class="text text-danger">*</span></label>
                  <input type="email" class="form-control" required="" name="email_warga" id="email_warga">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Telepon <span class="text text-danger">*</span></label>
                  <input type="number" class="form-control" required="" name="telepon_warga" id="telepon_warga">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Status Warga <span class="text text-danger">*</span></label>
                  <select class="form-control select2" required="" style="width: 100%;" name="status_warga" id="status_warga">
                    <option value="dirumah">Dirumah</option>
                    <option value="tidak dirumah 1">Tidak Dirumah (titip pesan ke petugas)</option>
                    <option value="tidak dirumah 0">Tidak Dirumah (tidak terima tamu)</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Keterangan <span id="required_keterangan" class="text-danger"></span></label>
                  <input type="text" class="form-control" id="keterangan" name="keterangan">
                </div>
              </div>
               <div class="col-lg-12">
                <div class="form-group">
                  <label>Alamat <span class="text-danger">*</span></label>
                  <textarea class="form-control" rows="4" name="alamat_warga" id="alamat_warga" required=""></textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-loading" id="modal-loading" style="display: none;">
            <span class="fa fa-spinner fa-spin fa-3x"></span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
  $("#status_warga").select2({
    placeholder: ":. PILIH STATUS .:"
  });
  var ajaxUrl = "";
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print","colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
  var keterangan = $("#keterangan").val();
  $("#status_warga").change(function() {
    var statusWarga = $(this).val();
    if (statusWarga == 'tidak dirumah 0' || statusWarga == 'tidak dirumah 1') {
      $("#keterangan").attr('required',true);
      $("#keterangan").attr('readonly',false);
      $("#keterangan").val(keterangan);
      $("#required_keterangan").html('*');
    }else{
      $("#keterangan").attr('required',false);
      $("#keterangan").attr('readonly',true);
      $("#keterangan").val('');
      $("#required_keterangan").html('');
    }
  })
  $(".new").click(function() {
    $("#wargaForm")[0].reset();
    $(".select2").val(null).trigger('change');
    $(".modal-title").html('<i class="fas fa-plus"> Tambah warga');
    $("#modal_form_warga").modal('show');
    ajaxUrl = "{{route('save_warga')}}";
    keterangan = '';
  });
  $(function () {
    $('#wargaForm').submit(function(e) {
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
        url: ajaxUrl,
        data: formData,
        success: function (response) {
          hide_loading();
          if (response.status == 'true') {
            $("#wargaForm")[0].reset();
            $('#modal_form_warga').modal('hide');
            Swal.fire({
              icon: 'success',
              type: 'success',
              title: 'Success',
              text: response.message
            });
            $(".warga_table").load(location.href + " .warga_table");
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
  $(document).on('click','.edit',function() {
    var wargaID = $(this).attr('more_id');
    $("#wargaForm")[0].reset();
    $(".modal-title").html('<i class="fas fa-edit"> Ubah Warga');
    $("#modal_form_warga").modal('show');
    ajaxUrl = "{{route('save_warga')}}";
    if (wargaID) {
      show_loading();
      get_edit(wargaID);
    }
  });
  function get_edit(wargaID) {
    $.ajax({
      type: "GET",
      url: "{{url('page/data-warga/getEdit/')}}"+"/"+wargaID,
      success: function(response) {
        if (response) {
          hide_loading();
          $.each(response, function(key, value) {
            $("#id_warga").val(value.id_warga);
            $("#nik_warga").val(value.nik_warga);
            $("#status_warga").val(value.status_warga).trigger('change');
            $("#nama_warga").val(value.nama_warga);
            $("#email_warga").val(value.email_warga);
            $("#telepon_warga").val(value.telepon_warga);
            $("#alamat_warga").val(value.alamat_warga);
            keterangan = value.keterangan;
            if (value.status_warga == 'tidak dirumah 0' || value.status_warga == 'tidak dirumah 1') {
              $("#keterangan").val(keterangan);
            }else{
              $("#keterangan").val('');
            }
          });
        }
      },
      error: function(response) {
        get_edit(wargaID);
      }
    });
  }
  $(document).on('click', '.delete', function (event) {
    wargaID = $(this).attr('more_id');
    event.preventDefault();
    Swal.fire({
      title: 'Lanjut Hapus Data?',
      text: 'Data warga akan dihapus secara Permanent!',
      icon: 'warning',
      type: 'warning',
      showCancelButton: !0,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: 'Lanjutkan'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          method: "GET",
          url: "{{url('page/data-warga/destroy')}}"+"/"+wargaID,
          success:function(response)
          {
            setTimeout(function(){
              Swal.fire({
                title: "Data Dihapus!",
                icon: "success",
                type: "success"
              });
              $(".warga_table").load(location.href + " .warga_table");
            }, 50);
          }
        })
      }
    });
  });
</script>
@endsection
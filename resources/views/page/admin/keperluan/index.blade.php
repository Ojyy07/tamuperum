 @extends('page/layout/app')

 @section('title','Data Keperluan')

 @section('content')
 <section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data Keperluan</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Data Master</a></li>
          <li class="breadcrumb-item active">Keperluan</li>
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
            <h3 class="card-title">Data Keperluan
            </h3>
            <button style="float: right;" type="button" class="btn btn-sm btn-primary new">
              <i class="fas fa-plus"></i> Tambah Keperluan
            </button>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-hover table-striped keperluan_table">
              <thead>
                <tr>
                  <th>No. </th>
                  <th>Keperluan</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $dt)
                <tr>
                  <td>{{$loop->index+1}}.</td>
                  <td>{{$dt->nama_keperluan}}</td>
                  <td>
                    <a href="javascript:void(0)" more_id="{{$dt->id_keperluan}}" class="btn btn-sm btn-success edit"><i class="fas fa-edit"></i></a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-danger delete" more_id="{{$dt->id_keperluan}}"><i class="fas fa-trash"></i></a>
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
  <div class="modal fade" data-backdrop="static" id="modal_form_keperluan">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" id="formKeperluan">
            @csrf
            <div class="row">
              <div class="col-12">
                <div class="form-group">
                  <input type="text" hidden="" id="id_keperluan" name="id_keperluan">
                  <label>Keperluan <span class="text text-danger">*</span></label>
                  <input type="text" class="form-control" required="" name="nama_keperluan" id="nama_keperluan">
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
  var ajaxUrl = "";
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print","colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
  $(".new").click(function() {
    $("#formKeperluan")[0].reset();
    // $("#id_keperluan").val('');
    $(".modal-title").html('<i class="fas fa-plus"> Tambah Keperluan');
    $("#modal_form_keperluan").modal('show');
    ajaxUrl = "{{route('save_keperluan')}}";
  });
  $(function () {
    $('#formKeperluan').submit(function(e) {
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
            $("#formKeperluan")[0].reset();
            $('#modal_form_keperluan').modal('hide');
            Swal.fire({
              icon: 'success',
              type: 'success',
              title: 'Success',
              text: response.message
            });
            $(".keperluan_table").load(location.href + " .keperluan_table");
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
    var keperluanID = $(this).attr('more_id');
    $("#formKeperluan")[0].reset();
    $(".modal-title").html('<i class="fas fa-edit"> Ubah keperluan');
    $("#modal_form_keperluan").modal('show');
    ajaxUrl = "{{route('save_keperluan')}}";
    if (keperluanID) {
      show_loading();
      get_edit(keperluanID);
    }
  });
  function get_edit(keperluanID) {
    $.ajax({
      type: "GET",
      url: "{{url('page/data-keperluan/getEdit')}}"+"/"+keperluanID,
      success: function(response) {
        if (response) {
          hide_loading();
          $.each(response, function(key, value) {
            $("#id_keperluan").val(value.id_keperluan);
            $("#nama_keperluan").val(value.nama_keperluan);
          });
        }
      },
      error: function(response) {
        get_edit(keperluanID);
      }
    });
  }
  $(document).on('click', '.delete', function (event) {
    keperluanID = $(this).attr('more_id');
    event.preventDefault();
    Swal.fire({
      title: 'Lanjut Hapus Data?',
      text: 'Data keperluan akan dihapus secara Permanent!',
      icon: 'warning',
      type: 'warning',
      showCancelButton: !0,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: 'Lanjutkan'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          method: "GET",
          url: "{{url('page/data-keperluan/destroy')}}"+"/"+keperluanID,
          success:function(response)
          {
            setTimeout(function(){
              Swal.fire({
                title: "Data Dihapus!",
                icon: "success",
                type: "success"
              });
              $(".keperluan_table").load(location.href + " .keperluan_table");
            }, 50);
          }
        })
      }
    });
  });
</script>
@endsection
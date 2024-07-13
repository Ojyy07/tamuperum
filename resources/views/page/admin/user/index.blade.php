 @extends('page/layout/app')

 @section('title','Data User')

 @section('content')
 <section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Data User</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Data Master</a></li>
          <li class="breadcrumb-item active">Data User</li>
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
            <h3 class="card-title">Data User
            </h3>
            <button style="float: right;" type="button" class="btn btn-sm btn-primary new">
              <i class="fas fa-plus"></i> Tambah User
            </button>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-hover table-striped user_table">
              <thead>
                <tr>
                  <th>No. </th>
                  <th>Nama</th>
                  <th>NIK</th>
                  <th>Email</th>
                  <th>Telepon</th>
                  <th>Username</th>
                  <th>Role</th>
                  <th>Foto</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $dt)
                <tr>
                  <td>{{$loop->index+1}}.</td>
                  <td>{{$dt->name}}</td>
                  <td>{{$dt->nik}}</td>
                  <td>{{$dt->email}}</td>
                  <td>{{$dt->telepon}}</td>
                  <td>{{$dt->username}}</td>
                  <td>
                    @if($dt->level == 'Security')
                    <span class="badge bg-secondary">Security</span>
                    @else
                    <span class="badge bg-warning">Leader Security</span>
                    @endif
                  </td>
                  <td>
                    @if($dt->foto == NULL)
                    <span class="badge bg-primary">belum ada foto</span>
                    @else
                    <img src="{{asset('foto')}}/{{$dt->foto}}" class="rounded-circle" width="50" height="50">
                    @endif
                  </td>
                  <td>
                    <a href="javascript:void(0)" more_id="{{$dt->id}}" class="btn btn-sm btn-success edit"><i class="fas fa-edit"></i></a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-danger delete" more_id="{{$dt->id}}"><i class="fas fa-trash"></i></a>
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
  <div class="modal fade" data-backdrop="static" id="modal_form_user">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" id="UserForm" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Nama <span class="text text-danger">*</span></label>
                  <input type="text" hidden="" name="id" id="id">
                  <input type="text" class="form-control" required="" name="name" id="name">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label>NIK <span class="text text-danger">*</span></label>
                  <input type="number" class="form-control" required="" name="nik" id="nik">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Email <span class="text text-danger">*</span></label>
                  <input type="email" class="form-control" required="" name="email" id="email">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Username <span class="text text-danger">*</span></label>
                  <input type="text" class="form-control" required="" name="username" id="username">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Telepon <span class="text text-danger">*</span></label>
                  <input type="number" class="form-control" required="" name="telepon" id="telepon">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Role <span class="text text-danger">*</span></label>
                  <select class="select2 form-control" id="level" name="level">
                    <option value="Leader Security">Leader Security</option>
                    <option value="Security">Security</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Password <span class="text text-danger password_label"></span></label>
                  <input type="password" class="form-control password" name="password" id="password">
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label>Confirm Password <span class="text text-danger password_label"></span></label>
                  <input type="password" class="form-control password" name="confirm_password" id="confirm_password">
                </div>
              </div>
              <div class="col-lg-12">
                <div class="form-group">
                  <label>Foto</label>
                  <input type="text" hidden="" id="fotoLama" name="fotoLama">
                  <input type="file" class="form-control" name="foto" id="foto">
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
  $("#level").select2({
    placeholder: ":. PILIH ROLE .:"
  });
  var ajaxUrl = "";
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print","colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
  $(".new").click(function() {
    $("#UserForm")[0].reset();
    $(".select2").val(null).trigger('change');
    $(".modal-title").html('<i class="fas fa-plus"> Tambah User');
    $("#modal_form_user").modal('show');
    $(".password").attr('required',true);
    $(".password_label").html('*');
    ajaxUrl = "{{route('save_user')}}";
  });
  $(function () {
    $('#UserForm').submit(function(e) {
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
            $("#UserForm")[0].reset();
            $('#modal_form_user').modal('hide');
            Swal.fire({
              icon: 'success',
              type: 'success',
              title: 'Success',
              text: response.message
            });
            $(".user_table").load(location.href + " .user_table");
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
  function get_edit(UserID) {
    $.ajax({
      type: "GET",
      url: "{{url('page/data-user/getEdit')}}"+"/"+UserID,
      success: function(response) {
        if (response) {
          hide_loading();
          $.each(response, function(key, value) {
            $("#id").val(value.id);
            $("#name").val(value.name);
            $("#nik").val(value.nik);
            $("#email").val(value.email);
            $("#username").val(value.username);
            $("#telepon").val(value.telepon);
            $("#fotoLama").val(value.foto);
            $("#level").val(value.level).trigger('change');
          });
        }
      },
      error: function(response) {
        get_edit(UserID);
      }
    });
  }
  $(document).on('click','.edit',function() {
    var UserID = $(this).attr('more_id');
    $("#UserForm")[0].reset();
    $(".modal-title").html('<i class="fas fa-edit"> Ubah User');
    $("#modal_form_user").modal('show');
    $(".password").removeAttr('required');
    $(".password_label").html('');
    $(document).on('keyup','#password',function() {
      if ($(this).val() != '') {
        $(".password_label").html('*');
        $(".password").attr('required',true);
      }else{
        $(".password_label").html('');
        $(".password").removeAttr('required');
      }
    })
    ajaxUrl = "{{route('update_user')}}";
    if (UserID) {
      show_loading();
      get_edit(UserID);
    }
  });
  $(document).on('click', '.delete', function (event) {
    UserID = $(this).attr('more_id');
    event.preventDefault();
    Swal.fire({
      title: 'Lanjut Hapus Data?',
      text: 'Data User akan dihapus secara Permanent!',
      icon: 'warning',
      type: 'warning',
      showCancelButton: !0,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: 'Lanjutkan'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          method: "GET",
          url: "{{url('page/data-user/destroy')}}"+"/"+UserID,
          success:function(response)
          {
            setTimeout(function(){
              Swal.fire({
                title: "Data Dihapus!",
                icon: "success",
                type: "success"
              });
              $(".user_table").load(location.href + " .user_table");
            }, 50);
          }
        })
      }
    });
  });
</script>
@endsection
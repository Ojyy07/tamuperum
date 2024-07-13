  @extends('page/layout/app')

  @section('title','Profil Settings')

  @section('content')
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Profil Setting</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
            <li class="breadcrumb-item active">Profil</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  @foreach($data as $dt)
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                src="{{asset('foto')}}/{{$dt->logo_profil}}"
                alt="User profile picture">
              </div>

              <h3 class="profile-username text-center">{{$dt->nama_profil}}</h3>

              <p class="text-muted text-center">{{$dt->alamat_profil}}</p>

             <!--  <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Followers</b> <a class="float-right">1,322</a>
                </li>
                <li class="list-group-item">
                  <b>Following</b> <a class="float-right">543</a>
                </li>
                <li class="list-group-item">
                  <b>Friends</b> <a class="float-right">13,287</a>
                </li>
              </ul>

              <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- About Me Box -->

          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                <!-- /.tab-pane -->
                <div class="active tab-pane" id="settings">
                  <form class="form-horizontal" method="POST" action="{{route('update_profil_setting')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                      <label for="inputName" class="col-sm-2 col-form-label">Nama <span class="text-danger">*</span></label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{$dt->nama_profil}}" name="nama_profil" placeholder="Nama Profil">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEmail" class="col-sm-2 col-form-label">Foto/Logo</label>
                      <div class="col-sm-10">
                        <input type="file" class="form-control" name="logo_profil">
                        <input type="text" hidden="" class="form-control" name="id_profil" value="{{$dt->id_profil}}">
                        <input type="text" hidden="" class="form-control" name="logo_profilLama" value="{{$dt->logo_profil}}">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputName2" class="col-sm-2 col-form-label">Alamat <span class="text-danger">*</span></label>
                      <div class="col-sm-10">
                        <textarea class="form-control" rows="4" required="" name="alamat_profil">{{$dt->alamat_profil}}</textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-check"></i> Simpan</button>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  @endforeach
  @endsection
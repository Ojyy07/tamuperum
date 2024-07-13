 <div class="user-panel mt-3 pb-3 mb-3 d-flex">
  <div class="image">
    <!-- <img src="{{asset('panel/dist/img/user2-160x160.jpg')}}" class="rounded-pill elevation-2" style="float: left;width: 45px;" alt="User Image"> -->
  </div>
  <div class="info text-white" style="width: 100%;">
    <?php  
    if ($prof->foto == NULL) {
      $image = 'panel/dist/img/user2-160x160.jpg';
    }else{
      $image = 'foto/'.$prof->foto;
    }
    ?>
    <img src="{{asset($image)}}" class="rounded-pill elevation-2" style="float: left;width: 45px;height: 45px;" alt="User Image">
    <a href="" class="d-block">&nbsp;&nbsp;&nbsp;{{Auth::user()->name}}</a>
    <small>&nbsp;&nbsp;&nbsp;{{Auth::user()->level}}</small>
  </div>
</div>

<!-- SidebarSearch Form -->
<div class="form-inline">
  <div class="input-group" data-widget="sidebar-search">
    <input class="form-control form-control-sidebar" type="search" placeholder="Cari Menu" aria-label="Search">
    <div class="input-group-append">
      <button class="btn btn-sidebar">
        <i class="fas fa-search fa-fw"></i>
      </button>
    </div>
  </div>
</div>

<!-- Sidebar Menu -->
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" id="menu" data-widget="treeview" role="menu" data-accordion="false">
    @if(Auth::user()->level == 'Admin' OR Auth::user()->level == 'Leader Security')
    <li class="nav-item">
      <a href="{{route('dashboard')}}" class="nav-link">
        <i class="nav-icon fas fa-home"></i>
        <p>
          Dashboard
        </p>
      </a>
    </li>
    @endif
    @if(Auth::user()->level == 'Admin' OR Auth::user()->level == 'Leader Security')
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-suitcase"></i>
        <p>
          Data Master
          <i class="fas fa-angle-left right"></i>
          <span class="badge badge-info right">3</span>
        </p>
      </a>
      <ul class="nav nav-treeview">
        @if(Auth::user()->level == 'Admin')
        <li class="nav-item">
          <a href="{{ route('data_user') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>User Petugas</p>
          </a>
        </li>
        @else
        <li class="nav-item">
          <a href="{{route('data_keperluan')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Keperluan</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{route('data_warga')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Warga</p>
          </a>
        </li>
        @endif
      </ul>
    </li>
    @endif
    @if(Auth::user()->level == 'Security')
    <li class="nav-item">
      <a href=" {{route('data_tamu')}} " class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>
          Data Tamu
        </p>
      </a>
    </li>
    @endif
    @if(Auth::user()->level == 'Admin' OR Auth::user()->level == 'Leader Security')
    <li class="nav-item">
      <a href=" {{ route('rekap_tamu') }} " class="nav-link">
        <i class="nav-icon fas fa-columns"></i>
        <p>
          Rekapitulasi Tamu
        </p>
      </a>
    </li>
    @endif
    @if(Auth::user()->level == 'Admin')
    <li class="nav-header">SETTINGS PROFIL</li>
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-chart-pie"></i>
        <p>
          Pengaturan
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('profil_setting') }}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Profil</p>
          </a>
        </li>
      </ul>
    </li>
    @endif
  </ul>
</nav>
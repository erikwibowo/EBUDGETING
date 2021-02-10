<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('template/admin/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">{{ config('variable.webname') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('template/admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2 mt-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ session('user_id') }}</a>
          <small class="text-light">{{ session('opd') }}</small>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      {{-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> --}}

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-header">MENU UTAMA</li>
          <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::segment(2) == '' ? 'active':'' }}">
              <i class="fas fa-tachometer-alt nav-icon"></i>
              <p>Dashboard</p>
            </a>
          </li>
          @if (session('otorisasi') == 'ADMINISTRATOR')
          <li class="nav-item">
            <a href="{{ route('admin.otorisasi.index') }}" class="nav-link {{ Request::segment(2) == 'otorisasi' ? 'active':'' }}">
              <i class="fas fa-user nav-icon"></i>
              <p>Otorisasi</p>
            </a>
          </li>
          @endif
          <li class="nav-header">ANGGARAN</li>
          <li class="nav-item {{ (Request::segment(2) == 'input-anggaran' || Request::segment(2) == 'input-rka') ? 'menu-open':'' }}">
            <a href="#" class="nav-link {{ Request::segment(2) == 'input-anggaran' ? 'active':'' }}">
              <i class="nav-icon fas fa-money-bill-wave nav-icon"></i>
              <p>
                Input Anggaran
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.input-anggaran.penyusunan') }}" class="nav-link {{ ((Request::segment(2) == 'input-anggaran' || Request::segment(2) == 'input-rka') && Request::segment(3) == 'penyusunan') ? 'active':'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Penyusunan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.input-anggaran.parsial1') }}" class="nav-link {{ ((Request::segment(2) == 'input-anggaran' || Request::segment(2) == 'input-rka') && Request::segment(3) == 'parsial1') ? 'active':'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Parsial 1</p>
                </a>
              </li>
              {{-- <li class="nav-item">
                <a href="{{ route('admin.input-anggaran.penyusunan') }}" class="nav-link {{ (Request::segment(2) == 'input-anggaran' && Request::segment(3) == 'parsial2') ? 'active':'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Parsial 2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.input-anggaran.penyusunan') }}" class="nav-link {{ (Request::segment(2) == 'input-anggaran' && Request::segment(3) == 'parsial3') ? 'active':'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Parsial 3</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.input-anggaran.penyusunan') }}" class="nav-link {{ (Request::segment(2) == 'input-anggaran' && Request::segment(3) == 'parsial4') ? 'active':'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Parsial 4</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.input-anggaran.penyusunan') }}" class="nav-link {{ (Request::segment(2) == 'input-anggaran' && Request::segment(3) == 'parsial5') ? 'active':'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Parsial 5</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.input-anggaran.penyusunan') }}" class="nav-link {{ (Request::segment(2) == 'input-anggaran' && Request::segment(3) == 'perubahan') ? 'active':'' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Perubahan</p>
                </a>
              </li> --}}
            </ul>
          </li>
          {{-- <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-circle"></i>
              <p>
                Level 1
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Level 2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Level 2
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Level 2</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-circle nav-icon"></i>
              <p>Level 1</p>
            </a>
          </li> --}}
          <li class="nav-header"></li>
          <li class="nav-item">
            <a href="#" class="nav-link bg-danger" data-toggle="modal" data-target="#modal-logout">
              <i class="fas fa-lock nav-icon"></i>
              <p>KELUAR</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
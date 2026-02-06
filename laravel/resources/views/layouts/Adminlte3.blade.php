<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $template = App\Models\Template::where('id', '<>', '~')->first();
    @endphp
    <title>{{ $template->nama }}</title>
    <link href="{{ asset($template->logo_kecil) }}" rel="icon">

    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adminlte3.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('layout/adminlte3/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    @section('header')

    @show

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img style="border-radius:28px" class="animation__wobble" src="{{ asset($template->logo_kecil) }}"
                alt="Logo" height="75" width="auto">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        {{ ucfirst(Auth::user()->name) }} <i class="far fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- <span class="dropdown-item dropdown-header">Profil</span> -->
                        @if (Auth::user()->user_level == 3)
                            <div class="dropdown-divider"></div>
                            <a href="{{ url('dashboard') }}" class="dropdown-item">
                                <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                            </a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <a href="{{ url('profil') }}" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i> Profil
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                            class="dropdown-item">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="brand-link" style="font-size:1rem">
                <img src="{{ asset($template->logo_kecil) }}" style="max-height: 30px;" alt="Logo"
                    class="brand-image img-circle elevation-3">
                <span style="font-weight:500 !important;"
                    class="brand-text font-weight-light">{{ $template->nama }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview"
                        role="menu" data-accordion="false">

                        <li class="nav-item">
                            <a href="{{ url('home') }}" class="nav-link {{ $menu == 'home' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Home
                                </p>
                            </a>
                        </li>

                        <li class="nav-header">MENU</li>

                        @if (Auth::user()->user_level == 1)
                                            @if (Auth::user()->role_id !== null)
                                                                @php
                                                                    $role_menu = App\Models\RoleMenu::where('role_id', Auth::user()->role_id)
                                                                        ->pluck('menu')
                                                                        ->toArray();
                                                                @endphp

                                                                @if (in_array('Website Setting', $role_menu))
                                                                    <li class="nav-item">
                                                                        <a href="{{ url('template') }}" class="nav-link {{ $menu == 'template' ? 'active' : '' }}">
                                                                            <i class="nav-icon fas fa-cogs"></i>
                                                                            <p>
                                                                                Website Setting
                                                                            </p>
                                                                        </a>
                                                                    </li>
                                                                @endif

                                                                @if (in_array('Informasi', $role_menu))
                                                                    <li class="nav-item">
                                                                        <a href="{{ url('informasi') }}"
                                                                            class="nav-link {{ $menu == 'informasi' ? 'active' : '' }}">
                                                                            <i class="nav-icon fas fa-newspaper"></i>
                                                                            <p>
                                                                                Informasi
                                                                            </p>
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                                @if (in_array('Running Text', $role_menu))
                                                                    <li class="nav-item">
                                                                        <a href="{{ url('runningtexts') }}"
                                                                            class="nav-link {{ $menu == 'running-text' ? 'active' : '' }}">
                                                                            <i class="nav-icon fas fa-text-width"></i>
                                                                            <p>
                                                                                Running Text
                                                                            </p>
                                                                        </a>
                                                                    </li>
                                                                @endif


                                                                @if (
                                                                    in_array('Bank Soal', $role_menu) ||
                                                                    in_array('Kategori Paket', $role_menu) ||
                                                                    in_array('Paket Latihan', $role_menu) ||
                                                                    in_array('Paket Pembelian', $role_menu) ||
                                                                    in_array('Kategori Materi', $role_menu) ||
                                                                    in_array('Voucher', $role_menu)
                                                                )
                                                                                    <li class="nav-item {{ $menu == 'master' ? 'menu-open' : '' }}">
                                                                                        <a href="#" class="nav-link {{ $menu == 'master' ? 'active' : '' }}">
                                                                                            <i class="nav-icon fas fa-sliders-h"></i>
                                                                                            <p>
                                                                                                Master
                                                                                                <i class="right fas fa-angle-left"></i>
                                                                                            </p>
                                                                                        </a>

                                                                                        @if (in_array('Bank Soal', $role_menu))
                                                                                            <ul class="nav nav-treeview">
                                                                                                <li class="nav-item">
                                                                                                    <a href="{{ url('kategorisoal') }}"
                                                                                                        class="nav-link {{ $submenu == 'kategorisoal' ? 'active' : '' }}">
                                                                                                        <i class="fas fa-file-import"></i>
                                                                                                        <p>
                                                                                                            Bank Soal
                                                                                                        </p>
                                                                                                    </a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        @endif


                                                                                        @if (in_array('Kategori Paket', $role_menu))
                                                                                            <ul class="nav nav-treeview">
                                                                                                <li class="nav-item">
                                                                                                    <a href="{{ url('paketkategori') }}"
                                                                                                        class="nav-link {{ $submenu == 'paketkategori' ? 'active' : '' }}">
                                                                                                        <i class="fas fa-list-ol"></i>
                                                                                                        <p>
                                                                                                            Kategori Paket
                                                                                                        </p>
                                                                                                    </a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        @endif

                                                                                        @if (in_array('Paket Latihan', $role_menu))
                                                                                            <ul class="nav nav-treeview">
                                                                                                <li class="nav-item">
                                                                                                    <a href="{{ url('paketsoalmst') }}"
                                                                                                        class="nav-link {{ $submenu == 'paketsoalmst' ? 'active' : '' }}">
                                                                                                        <i class="fas fa-file-signature"></i>
                                                                                                        <p>
                                                                                                            Paket Latihan
                                                                                                        </p>
                                                                                                    </a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        @endif

                                                                                        @if (in_array('Paket Pembelian', $role_menu))
                                                                                            <ul class="nav nav-treeview">
                                                                                                <li class="nav-item">
                                                                                                    <a href="{{ url('paketmst') }}"
                                                                                                        class="nav-link {{ $submenu == 'paketmst' ? 'active' : '' }}">
                                                                                                        <i class="fas fa-project-diagram"></i>
                                                                                                        <p>
                                                                                                            Paket Pembelian
                                                                                                        </p>
                                                                                                    </a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        @endif

                                                                                        @if (in_array('Kategori Meteri', $role_menu))
                                                                                            <ul class="nav nav-treeview">
                                                                                                <li class="nav-item">
                                                                                                    <a href="{{ url('kategorimateri') }}"
                                                                                                        class="nav-link {{ $submenu == 'kategorimateri' ? 'active' : '' }}">
                                                                                                        <i class="fas fa-project-diagram"></i>
                                                                                                        <p>
                                                                                                            Kategori Pemaketan
                                                                                                        </p>
                                                                                                    </a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        @endif

                                                                                        @if (in_array('Voucher', $role_menu))
                                                                                            <ul class="nav nav-treeview">
                                                                                                <li class="nav-item">
                                                                                                    <a href="{{ url('kodepotongan') }}"
                                                                                                        class="nav-link {{ $submenu == 'kodepotongan' ? 'active' : '' }}">
                                                                                                        <i class="fas fa-percent"></i>
                                                                                                        <p>
                                                                                                            Voucher
                                                                                                        </p>
                                                                                                    </a>
                                                                                                </li>
                                                                                            </ul>
                                                                                        @endif
                                                                                    </li>
                                                                @endif

                                                                @if (in_array('User', $role_menu))
                                                                    <li class="nav-item">
                                                                        <a href="{{ url('user') }}" class="nav-link {{ $menu == 'user' ? 'active' : '' }}">
                                                                            <i class="nav-icon fa fa-users"></i>
                                                                            <p>
                                                                                User
                                                                            </p>
                                                                        </a>
                                                                    </li>
                                                                @endif

                                                                @if (in_array('Class', $role_menu))
                                                                    <li class="nav-item">
                                                                        <a href="{{ url('kelas') }}" class="nav-link {{ $menu == 'kelas' ? 'active' : '' }}">
                                                                            <i class="nav-icon fa fa-video-camera"></i>
                                                                            <p>
                                                                                Class
                                                                            </p>
                                                                        </a>
                                                                    </li>
                                                                @endif

                                                                @if (in_array('Mentor', $role_menu))
                                                                    <li class="nav-item">
                                                                        <a href="{{ url('mentor') }}" class="nav-link {{ $menu == 'mentor' ? 'active' : '' }}">
                                                                            <i class="nav-icon fa fa-video-camera"></i>
                                                                            <p>
                                                                                Mentor Class
                                                                            </p>
                                                                        </a>
                                                                    </li>
                                                                @endif

                                                                @if (in_array('Role', $role_menu))
                                                                    <li class="nav-item">
                                                                        <a href="{{ url('role') }}" class="nav-link {{ $menu == 'role' ? 'active' : '' }}">
                                                                            <i class="nav-icon fa fa-book"></i>
                                                                            <p>
                                                                                Role
                                                                            </p>
                                                                        </a>
                                                                    </li>
                                                                @endif

                                                                @if (in_array('Role Menu', $role_menu))
                                                                    <li class="nav-item">
                                                                        <a href="{{ url('role-menu') }}"
                                                                            class="nav-link {{ $menu == 'role_menu' ? 'active' : '' }}">
                                                                            <i class="nav-icon fa fa-bell"></i>
                                                                            <p>
                                                                                Role Menu
                                                                            </p>
                                                                        </a>
                                                                    </li>
                                                                @endif

                                                                @if (in_array('Paket', $role_menu))
                                                                    <li class="nav-item {{ $menu == 'transaksi' ? 'menu-open' : '' }}">
                                                                        <a href="#" class="nav-link {{ $menu == 'transaksi' ? 'active' : '' }}">
                                                                            <i class="nav-icon fas fa-wallet"></i>
                                                                            <p>
                                                                                Transaksi
                                                                                <i class="right fas fa-angle-left"></i>
                                                                            </p>
                                                                        </a>

                                                                        <ul class="nav nav-treeview">
                                                                            <li class="nav-item">
                                                                                <a href="{{ url('listtransaksi/paket') }}"
                                                                                    class="nav-link {{ $submenu == 'paket' ? 'active' : '' }}">
                                                                                    <i class="fas fa-wallet"></i>
                                                                                    <p>
                                                                                        Paket
                                                                                    </p>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                @endif
                                            @else
                                                        <li class="nav-item">
                                                            <a href="{{ url('template') }}" class="nav-link {{ $menu == 'template' ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-cogs"></i>
                                                                <p>
                                                                    Website Setting
                                                                </p>
                                                            </a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="{{ url('informasi') }}"
                                                                class="nav-link {{ $menu == 'informasi' ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-newspaper"></i>
                                                                <p>
                                                                    Informasi
                                                                </p>
                                                            </a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="{{ url('faq-admin') }}"
                                                                class="nav-link {{ $menu == 'faq-admin' ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-newspaper"></i>
                                                                <p>
                                                                    Faq
                                                                </p>
                                                            </a>
                                                        </li>

                                                        <li class="nav-item {{ $menu == 'master' ? 'menu-open' : '' }}">
                                                            <a href="#" class="nav-link {{ $menu == 'master' ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-sliders-h"></i>
                                                                <p>
                                                                    Master
                                                                    <i class="right fas fa-angle-left"></i>
                                                                </p>
                                                            </a>
                                                            <!-- <ul class="nav nav-treeview">
                                                  <li class="nav-item">
                                                    <a href="{{ url('template') }}" class="nav-link {{ $submenu == 'template' ? 'active' : '' }}">
                                                      <i class="fas fas fa-sliders-h"></i>
                                                      <p>
                                                        Website
                                                      </p>
                                                    </a>
                                                  </li>
                                                </ul> -->
                                                            <!-- <ul class="nav nav-treeview">
                                                  <li class="nav-item">
                                                    <a href="{{ url('masterrekening') }}" class="nav-link {{ $submenu == 'masterrekening' ? 'active' : '' }}">
                                                      <i class="fas fa-wallet"></i>
                                                      <p>
                                                        Rekening / E-Wallet
                                                      </p>
                                                    </a>
                                                  </li>
                                                </ul> -->
                                                            <ul class="nav nav-treeview">
                                                                <li class="nav-item">
                                                                    <a href="{{ url('kategorisoal') }}"
                                                                        class="nav-link {{ $submenu == 'kategorisoal' ? 'active' : '' }}">
                                                                        <i class="fas fa-file-import"></i>
                                                                        <p>
                                                                            Bank Soal Pilihan Ganda
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                            {{-- <ul class="nav nav-treeview">
                                                                <li class="nav-item">
                                                                    <a href="{{ url('kategorisoalkecermatan') }}"
                                                                        class="nav-link {{ $submenu == 'kategorisoalkecermatan' ? 'active' : '' }}">
                                                                        <i class="fas fas fa-sliders-h"></i>
                                                                        <p>
                                                                            Bank Soal Kecermatan
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                            </ul> --}}
                                                            <ul class="nav nav-treeview">
                                                                <li class="nav-item">
                                                                    <a href="{{ url('paketkategori') }}"
                                                                        class="nav-link {{ $submenu == 'paketkategori' ? 'active' : '' }}">
                                                                        <i class="fas fa-list-ol"></i>
                                                                        <p>
                                                                            Kategori Paket
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                            <!-- <ul class="nav nav-treeview">
                                                  <li class="nav-item">
                                                    <a href="{{ url('kategorisoalkecermatan') }}" class="nav-link {{ $submenu == 'kategorisoalkecermatan' ? 'active' : '' }}">
                                                      <i class="fas fa-file-import"></i>
                                                      <p>
                                                        Bank Soal Kecermatan
                                                      </p>
                                                    </a>
                                                  </li>
                                                </ul> -->
                                                            <ul class="nav nav-treeview">
                                                                <li class="nav-item">
                                                                    <a href="{{ url('paketsoalmst') }}"
                                                                        class="nav-link {{ $submenu == 'paketsoalmst' ? 'active' : '' }}">
                                                                        <i class="fas fa-file-signature"></i>
                                                                        <p>
                                                                            Paket Soal Pilihan Ganda
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                            {{-- <ul class="nav nav-treeview">
                                                                <li class="nav-item">
                                                                    <a href="{{ url('paketsoalkecermatan') }}"
                                                                        class="nav-link {{ $submenu == 'paketsoalkecermatan' ? 'active' : '' }}">
                                                                        <i class="fas fa-file-signature"></i>
                                                                        <p>
                                                                            Paket Soal Kecermatan
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                            </ul> --}}

                                                            <ul class="nav nav-treeview">
                                                                <li class="nav-item">
                                                                    <a href="{{ url('paketmst') }}"
                                                                        class="nav-link {{ $submenu == 'paketmst' ? 'active' : '' }}">
                                                                        <i class="fas fa-project-diagram"></i>
                                                                        <p>
                                                                            Paket Pembelian
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                            <ul class="nav nav-treeview">
                                                                <li class="nav-item">
                                                                    <a href="{{ url('kategorimateri') }}"
                                                                        class="nav-link {{ $submenu == 'kategorimateri' ? 'active' : '' }}">
                                                                        <i class="fas fa-project-diagram"></i>
                                                                        <p>
                                                                            Kategori Pemaketan
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                            <ul class="nav nav-treeview">
                                                                <li class="nav-item">
                                                                    <a href="{{ url('kodepotongan') }}"
                                                                        class="nav-link {{ $submenu == 'kodepotongan' ? 'active' : '' }}">
                                                                        <i class="fas fa-percent"></i>
                                                                        <p>
                                                                            Voucher
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="{{ url('user') }}" class="nav-link {{ $menu == 'user' ? 'active' : '' }}">
                                                                <i class="nav-icon fa fa-users"></i>
                                                                <p>
                                                                    User
                                                                </p>
                                                            </a>
                                                        </li>
                                                        {{-- <li class="nav-item">
                                                            <a href="{{ url('kelas') }}" class="nav-link {{ $menu == 'kelas' ? 'active' : '' }}">
                                                                <i class="nav-icon fa fa-video-camera"></i>
                                                                <p>
                                                                    Class
                                                                </p>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="{{ url('role') }}" class="nav-link {{ $menu == 'role' ? 'active' : '' }}">
                                                                <i class="nav-icon fa fa-book"></i>
                                                                <p>
                                                                    Role
                                                                </p>
                                                            </a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="{{ url('role-menu') }}"
                                                                class="nav-link {{ $menu == 'role_menu' ? 'active' : '' }}">
                                                                <i class="nav-icon fa fa-bell"></i>
                                                                <p>
                                                                    Role Menu
                                                                </p>
                                                            </a>
                                                        </li> --}}

                                                        <li class="nav-item {{ $menu == 'transaksi' ? 'menu-open' : '' }}">
                                                            <a href="#" class="nav-link {{ $menu == 'transaksi' ? 'active' : '' }}">
                                                                <i class="nav-icon fas fa-wallet"></i>
                                                                <p>
                                                                    Transaksi
                                                                    <i class="right fas fa-angle-left"></i>
                                                                </p>
                                                            </a>

                                                            <ul class="nav nav-treeview">
                                                                <li class="nav-item">
                                                                    <a href="{{ url('listtransaksi/paket') }}"
                                                                        class="nav-link {{ $submenu == 'paket' ? 'active' : '' }}">
                                                                        <i class="fas fa-wallet"></i>
                                                                        <p>
                                                                            Paket
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                            <!-- <ul class="nav nav-treeview">
                                                  <li class="nav-item">
                                                    <a href="{{ url('listtransaksi/hadiah') }}" class="nav-link {{ $submenu == 'hadiah' ? 'active' : '' }}">
                                                      <i class="fas fa-wallet"></i>
                                                      <p>
                                                        Hadiah
                                                      </p>
                                                    </a>
                                                  </li>
                                                </ul> -->
                                                        </li>
                                            @endif







                        @endif
                        <!-- <li class="nav-item">
            <a href="{{ url('affiliate') }}" class="nav-link {{ $menu == 'affiliate' ? 'active' : '' }}">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                User Affiliate
              </p>
            </a>
          </li>  -->
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            @section('contentheader')

                            @show
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            @section('contentheadermenu')

                            @show
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            @section('content')

            @show

            <!-- Modal Photo -->
            <div class="modal fade" id="modal-image">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal-title-image"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="text-align:center;padding:0px">
                            <a id="modal-body-href" target="_blank" href=""><img style="width:100%;height:auto"
                                    id="modal-body-image" src="" alt=""></a>
                        </div>
                        <!-- <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <!-- <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0
    </div>
  </footer> -->
    </div>
    <!-- ./wrapper -->

    @section('footer')

    @show

    <!-- Global -->
    <script src="{{ asset('js/global.js') }}"></script>

    <!-- Loading Overlay -->
    <script src='https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js'>
    </script>
    <!-- Select2 -->
    <script src="{{ asset('layout/adminlte3/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- CUSTOM -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js"
        integrity="sha512-jNDtFf7qgU0eH/+Z42FG4fw3w7DM/9zbgNPe3wfJlCylVDTT3IgKW5r92Vy9IHa6U50vyMz5gRByIu4YIXFtaQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function () {
            $('._lazyload').lazyload();
            $('[data-toggle="tooltip"]').tooltip({
                trigger: 'hover'
            });
        });
    </script>
    <!-- Pooper -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script> -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script> -->
</body>

</html>
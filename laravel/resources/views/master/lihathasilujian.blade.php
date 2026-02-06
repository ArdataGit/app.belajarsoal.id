@extends('layouts.Adminlte3')

@section('header')
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('layout/adminlte3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('layout/adminlte3/dist/css/adminlte.min.css') }}">
  
@endsection

@section('contentheader')
<h1 class="m-0">Hasil Ujian {{$user->name}}</h1>
@endsection

@section('contentheadermenu')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="{{url('user')}}">User</a></li>
    <li class="breadcrumb-item active">Hasil Ujian</li>
</ol>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

      <!-- <ul class="nav nav-pills" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="pill" href="#pilgan">Paket Soal Pilihan Ganda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="pill" href="#kecermatan">Paket Soal Kecermatan</a>
          </li>
        </ul> -->

        <!-- Tab panes -->
        <div class="tab-content">
          <div id="pilgan" class="tab-pane active"><br>
            
          <div class="row">
            <div class="col-12">
              <div class="card">
                <!-- <div class="card-header">
                  <h3 class="card-title">Foto Beranda</h3>
                </div> -->
                <!-- /.card-header -->
                <div class="card-body">
                <!-- <span data-toggle="tooltip" data-placement="left" title="Tambah Data">
                  <button data-toggle="modal" data-target="#modal-tambah" type="button" class="btn btn-sm btn-primary btn-add-absolute">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                  </button>
                </span> -->
                <!-- <button data-toggle="modal" data-target="#modal-tambah" type="button" class="btn btn-md btn-primary btn-absolute">Tambah</button> -->
                  <table id="tabledata" class="table  table-striped">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>Judul</th>
                      <!-- <th>KKM</th> -->
                      <th>Nilai</th>
                      <th>Tgl.Mengerjakan</th>
                      <!-- <th>Lulus</th> -->
                      <th>Detail</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $key)
                    <tr>
                      <td width="1%">{{$loop->iteration}}</td>
                      <td width="25%">{{$key->judul}}</td>
                      <!-- <td width="5%">{{$key->kkm}}</td> -->
                      <td width="5%">{{$key->point ? $key->point : 0 }}</td>
                      <td width="20%">{{Carbon\Carbon::parse($key->mulai)->translatedFormat('l, d F Y , H:i:s')}}</td>
                      <!-- <td width="5%" class="_align_center">
                        @if($key->nilai < $key->kkm)
                            <button class="btn btn-sm btn-danger" style="white-space: nowrap;">Tidak Lulus</button>
                        @else
                            <button class="btn btn-sm btn-success">Lulus</button>
                        @endif
                      </td> -->
                      <td width="1%" class="_align_center">
                        <div class="btn-group">
                          <span data-toggle="tooltip" data-placement="left" title="Hasil">
                            <a target="_blank" href="{{url('detailhasil')}}/{{Crypt::encrypt($key->id)}}" type="button" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                          </span>
                          <!-- <span data-toggle="tooltip" data-placement="left" title="Sertifikat">
                            <a target="_blank" href="{{url('sertifikat')}}/{{base64_encode($key->id)}}/{{base64_encode($user->id)}}" type="button" class="btn btn-sm btn-warning"><i class="fas fa-certificate"></i></a>
                          </span>
                          <span data-toggle="tooltip" data-placement="left" title="Piagam">
                            <a target="_blank" href="{{url('piagam')}}/{{base64_encode($key->id)}}/{{base64_encode($user->id)}}" type="button" class="btn btn-sm btn-danger"><i class="fas fa-file-text"></i></a>
                          </span> -->
                        </div>
                      </td>
                     
                    </tr>
                    @endforeach
                    </tbody>
                    <!-- <tfoot>
                    <tr>
                      <th>Rendering engine</th>
                      <th>Browser</th>
                      <th>Platform(s)</th>
                      <th>Engine version</th>
                      <th>CSS grade</th>
                    </tr>
                    </tfoot> -->
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>

          </div>
          <div id="kecermatan" class="tab-pane fade"><br>
            
          <div class="row">
            <div class="col-12">
              <div class="card">
                <!-- <div class="card-header">
                  <h3 class="card-title">Foto Beranda</h3>
                </div> -->
                <!-- /.card-header -->
                <div class="card-body">
                <!-- <span data-toggle="tooltip" data-placement="left" title="Tambah Data">
                  <button data-toggle="modal" data-target="#modal-tambah" type="button" class="btn btn-sm btn-primary btn-add-absolute">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                  </button>
                </span> -->
                <!-- <button data-toggle="modal" data-target="#modal-tambah" type="button" class="btn btn-md btn-primary btn-absolute">Tambah</button> -->
                  <table id="tabledata2" class="table  table-striped">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>Judul</th>
                      <th>KKM</th>
                      <th>Nilai</th>
                      <th>Tgl.Mengerjakan</th>
                      <th>Lulus</th>
                      <th>Detail</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($datakecermatan as $key)
                    <tr>
                      <td width="1%">{{$loop->iteration}}</td>
                      <td width="25%">{{$key->judul}}</td>
                      <td width="5%">{{$key->kkm}}</td>
                      <td width="5%">{{$key->nilai ? $key->nilai : 0 }}</td>
                      <td width="20%">{{Carbon\Carbon::parse($key->mulai)->translatedFormat('l, d F Y , H:i:s')}}</td>
                      <td width="5%" class="_align_center">
                        @if($key->nilai < $key->kkm)
                            <button class="btn btn-sm btn-danger" style="white-space: nowrap;">Tidak Lulus</button>
                        @else
                            <button class="btn btn-sm btn-success">Lulus</button>
                        @endif
                      </td>
                      <td width="1%" class="_align_center">
                        <a target="_blank" href="{{url('detailhasilkecermatan')}}/{{Crypt::encrypt($key->id)}}" class="btn btn-sm btn-info">Lihat</a>
                      </td>
                    </tr>
                    @endforeach
                    </tbody>
                    <!-- <tfoot>
                    <tr>
                      <th>Rendering engine</th>
                      <th>Browser</th>
                      <th>Platform(s)</th>
                      <th>Engine version</th>
                      <th>CSS grade</th>
                    </tr>
                    </tfoot> -->
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>


          </div>
        </div>


        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection

@section('footer')
<!-- Custom Input File -->
<script src="{{ asset('layout/adminlte3/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- jQuery -->
<script src="{{ asset('layout/adminlte3/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('layout/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- jquery-validation -->
<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('layout/adminlte3/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('layout/adminlte3/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('layout/adminlte3/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('layout/adminlte3/dist/js/demo.js') }}"></script>
<!-- Page specific script -->
<!-- DatePicker -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/themes/dark.css">
<!--  Flatpickr  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.2.3/flatpickr.js"></script>
<script>
  $(document).ready(function(){

    datatableUser("tabledata");
    datatableUser("tabledata2");

  });
</script>

@endsection
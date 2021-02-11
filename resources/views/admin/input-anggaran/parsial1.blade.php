@extends('admin.layout.master')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0">{{ $title }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Input anggaran</li>
                    <li class="breadcrumb-item active">Parsial 1</li>
                </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                {{-- <div class="card-header">
                    <h3 class="card-title">
                        <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i> Tambah</a>
                    </h3>
                </div> --}}
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover datatable">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Uraian</th>
                                <th>Susun</th>
                                <th>Parsial</th>
                                <th>Selisih</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $jsusun = 0;
                                $jparsial = 0;
                                $jselisih = 0;
                            @endphp
                            @foreach ($data as $i)
                                <tr style="{{ $i->tipe == 'P' ? 'font-weight: 900; background: rgba(108, 122, 137, 0.2)':($i->tipe == 'S' ? 'font-weight: 300':'font-weight: 500; background: rgba(108, 122, 137, 0.1)') }}">
                                    <td>{{ $i->kode }}</td>
                                    <td>{{ $i->uraian }}</td>
                                    <td class="text-right">@rp($i->susun)</td>
                                    <td class="text-right">@rp($i->parsial)</td>
                                    <td class="text-right">@rp($i->selisih)</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-sm btn-info" title="Indikator"><i class="fas fa-list-ul"></i></a>
                                            @if ($i->tipe == 'S')
                                                <a href="{{ route('admin.input-rka.parsial1').'?kdsub='.$i->kode.'&kdsuburusan='.$i->kdsuburusan.'&tipe='.substr($i->kode, 5, 2) }}" class="btn btn-sm btn-warning" title="Input RKA"><i class="fas fa-pencil-alt"></i></a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @if ($i->tipe == "S")
                                    @php
                                        $jsusun += $i->susun;
                                        $jparsial += $i->parsial;
                                        $jselisih += $i->selisih;
                                    @endphp
                                @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center" colspan="2">Total</th>
                                <th class="text-right">@rp($jsusun)</th>
                                <th class="text-right">@rp($jparsial)</th>
                                <th class="text-right">@rp($jselisih)</th>
                                <th></th>
                            </tr>
                        </tfoot>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('.datatable').DataTable();
        });
    </script>
@endsection
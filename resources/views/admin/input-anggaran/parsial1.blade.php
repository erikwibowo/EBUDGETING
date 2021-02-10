@extends('admin.layout.master')
@section('content')
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
                    <table class="table table-bordered table-hover datatable yajra-datatable">
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
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
        </div>
    </div>
@endsection
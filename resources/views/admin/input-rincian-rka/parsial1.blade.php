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
                    <li class="breadcrumb-item"><a href="{{ route('admin.input-anggaran.parsial1') }}">Input Anggaran</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.input-rka.parsial1').'?kdurusan='.Request::input('kdurusan').'&kdsuburusan='.Request::input('kdsuburusan').'&kdprogram='.Request::input('kdprogram').'&kdgiat='.Request::input('kdgiat').'&kdsub='.Request::input('kdsub').'&tipe='.Request::input('tipe') }}">Input RKA</a></li>
                    <li class="breadcrumb-item active">Input Rincian RKA</li>
                    <li class="breadcrumb-item active">Parsial 1</li>
                </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <a href="{{ route('admin.input-rka.parsial1').'?kdurusan='.Request::input('kdurusan').'&kdsuburusan='.Request::input('kdsuburusan').'&kdprogram='.Request::input('kdprogram').'&kdgiat='.Request::input('kdgiat').'&kdsub='.Request::input('kdsub').'&tipe='.Request::input('tipe') }}" class="btn btn-sm btn-warning"><i class="fas fa-arrow-left"></i> Kembali</a>
                        <button class="btn btn-sm btn-primary" id="btn-tambah-rekening"><i class="fas fa-plus"></i> Header</button>
                        <div class="row mt-2 ml-1">
                            <h4>{{ $rek->kdrek." ".$rek->nmrek }}</h4>
                        </div>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Uraian</th>
                                <th>Susun</th>
                                <th>Ubah</th>
                                <th>Selisih</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $jsusun = 0;
                                $jubah = 0;
                                $jselisih = 0;
                            @endphp
                            @foreach ($data as $i)
                                <tr style="{{ $i->tipe == 'H' ? 'font-weight: bold':'' }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $i->uraian }}</td>
                                    <td class="text-right">@rp($i->susun)</td>
                                    <td class="text-right">@rp($i->ubah)</td>
                                    <td class="text-right">@rp($i->selisih)</td>
                                    <td>
                                        <div class="btn-group">
                                            @if ($i->tipe == "H")
                                                <button title="Lihat/Edit" class="btn btn-sm btn-primary btn-edit-rinci-rka-h"><i class="fas fa-pencil-alt"></i></button>
                                                <button title="Tambah Sub Header" class="btn btn-sm btn-success btn-tambah-sub-rinci-rka"><i class="fas fa-plus"></i> Sub Header</button>
                                            @else
                                                <a href="{{ route('admin.input-rincian-rka.data-rinci-parsial1').'?kdurusan='.$i->kdurusan.'&kdsuburusan='.$i->kdsuburusan.'&kdprogram='.$i->kdprogram.'&kdgiat='.$i->kdgiat.'&kdsub='.$i->kdsub.'&tipe='.Request::input('tipe').'&kdrek='.$i->kdrek.'&nourut='.$i->nourut.'&urut='.$i->urut }}" title="Lihat/Edit" class="btn btn-sm btn-primary btn-edit-rinci-rka-s"><i class="fas fa-eye"></i></a>
                                            @endif
                                            @if (!$i->kunci == "T")
                                            <button title="Hapus" class="btn btn-sm btn-danger btn-delete-rinci-rka"><i class="fas fa-trash"></i></button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @php
                                    $jsusun += $i->susun;
                                    $jubah += $i->ubah;
                                    $jselisih += $i->selisih;
                                @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center" colspan="2">Total</th>
                                <th class="text-right">@rp($jsusun)</th>
                                <th class="text-right">@rp($jubah)</th>
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

    {{-- START SCRIPT --}}
    <script>
        $(document).ready(function(){
            $('.datatable').DataTable();
            $('#btn-tambah-rekening').on('click', function(){
                let id = $(this).attr("data-id");
                $('#modal-tambah-rekening').modal('show');
                $('#modal-tambah-rekening').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            });
            $('.btn-delete-rekening').on('click', function(){
                let kdsub = $(this).attr("data-kdsub");
                let kdsuburusan = $(this).attr("data-kdsuburusan");
                let nmrek = $(this).attr("data-nmrek");
                let kdrek = $(this).attr("data-kdrek");
                $('#delete-data').html(nmrek);
                $('#dkdsub').val(kdsub);
                $('#dkdsuburusan').val(kdsuburusan);
                $('#dkdrek').val(kdrek);
                $('#modal-delete-rekening').modal('show');
                $('#modal-delete-rekening').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            });
        });
    </script>
    {{-- END SCRIPT --}}

    {{-- BEGIN MODAL --}}
    <div class="modal fade" id="modal-tambah-rekening">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Rekening</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.input-rka.create-parsial1') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <table class="table table-bordered table-hover table-striped datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode Rekening</th>
                                <th>Rekening</th>
                                <th>Pilih</th>
                            </tr>
                        </thead>
                        {{-- <tbody>
                            @foreach ($rekening as $i)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $i->kdrek }}</td>
                                    <td>{{ $i->nmrek }}</td>
                                    <td><input type="checkbox" value="{{ $i->kdrek }}" name="kdrek[]"></td>
                                </tr>
                            @endforeach
                        </tbody> --}}
                    </table>
            </div>
            <div class="modal-footer justify-content-between">
                <input type="hidden" name="tipe" value="{{ Request::input('tipe') }}">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success">Tambah</button>
            </div>
            </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="modal-delete-rekening">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Hapus Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.input-rka.delete-parsial1') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <p class="modal-text">Apakah anda yakin akan menghapus? <b id="delete-data"></b></p>
                    <input type="hidden" name="kdsub" id="dkdsub">
                    <input type="hidden" name="kdsuburusan" id="dkdsuburusan">
                    <input type="hidden" name="kdrek" id="dkdrek">
                    <input type="hidden" name="tipe" value="{{ Request::input('tipe') }}">
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
            </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{-- END MODAL --}}
@endsection
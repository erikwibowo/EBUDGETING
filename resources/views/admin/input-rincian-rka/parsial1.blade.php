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
                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-tambah-header"><i class="fas fa-plus"></i> Header</button>
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
                                    <td>{{ $i->tipe == "S" ? '- '.$i->uraian:$i->uraian }}</td>
                                    <td class="text-right">@rp($i->susun)</td>
                                    <td class="text-right">@rp($i->ubah)</td>
                                    <td class="text-right">@rp($i->selisih)</td>
                                    <td>
                                        <div class="btn-group">
                                            @if ($i->tipe == "H")
                                                <button title="Lihat/Edit" data-kdurusan="{{ $i->kdurusan }}" data-kdsuburusan="{{ $i->kdsuburusan }}" data-kdprogram="{{ $i->kdprogram }}" data-kdgiat="{{ $i->kdgiat }}" data-kdsub="{{ $i->kdsub }}" data-kdrek="{{ $i->kdrek }}" data-nourut="{{ $i->nourut }}" data-uraian="{{ $i->uraian }}" class="btn btn-sm btn-primary btn-detail-header"><i class="fas fa-pencil-alt"></i></button>
                                                <button title="Tambah Sub Header" data-kdurusan="{{ $i->kdurusan }}" data-kdsuburusan="{{ $i->kdsuburusan }}" data-kdprogram="{{ $i->kdprogram }}" data-kdgiat="{{ $i->kdgiat }}" data-kdsub="{{ $i->kdsub }}" data-kdrek="{{ $i->kdrek }}" data-nourut="{{ $i->nourut }}" class="btn btn-sm btn-success btn-tambah-subheader"><i class="fas fa-plus"></i> Rinci</button>
                                            @else
                                                <button title="Lihat/Edit" class="btn btn-sm btn-primary btn-detail-subheader" data-kdurusan="{{ $i->kdurusan }}" data-kdsuburusan="{{ $i->kdsuburusan }}" data-kdprogram="{{ $i->kdprogram }}" data-kdgiat="{{ $i->kdgiat }}" data-kdsub="{{ $i->kdsub }}" data-kdrek="{{ $i->kdrek }}" data-nourut="{{ $i->nourut }}" data-urut="{{ $i->urut }}"><i class="fas fa-eye"></i></button>
                                                @if ($i->kunci == "F")
                                                <button title="Hapus" class="btn btn-sm btn-danger btn-delete-subheader" data-kdurusan="{{ $i->kdurusan }}" data-kdsuburusan="{{ $i->kdsuburusan }}" data-kdprogram="{{ $i->kdprogram }}" data-kdgiat="{{ $i->kdgiat }}" data-kdsub="{{ $i->kdsub }}" data-kdrek="{{ $i->kdrek }}" data-nourut="{{ $i->nourut }}" data-urut="{{ $i->urut }}" data-uraian="{{ $i->uraian }}"><i class="fas fa-trash"></i></button>
                                                @endif
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
            $('.btn-delete-subheader').on('click', function(){
                $("#hs-kdurusan").val($(this).attr('data-kdurusan'));
                $("#hs-kdsuburusan").val($(this).attr('data-kdsuburusan'));
                $("#hs-kdprogram").val($(this).attr('data-kdprogram'));
                $("#hs-kdgiat").val($(this).attr('data-kdgiat'));
                $("#hs-kdsub").val($(this).attr('data-kdsub'));
                $("#hs-kdrek").val($(this).attr('data-kdrek'));
                $("#hs-nourut").val($(this).attr('data-nourut'));
                $("#hs-urut").val($(this).attr('data-urut'));
                $("#delete-data").text($(this).attr('data-uraian'));
                $('#modal-delete-subheader').modal('show');
                $('#modal-delete-subheader').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            });
            $('.btn-detail-header').on('click', function(){
                $('#modal-detail-header').modal('show');
                $('#modal-detail-header').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $("#dh-kdurusan").val($(this).attr('data-kdurusan'));
                $("#dh-kdsuburusan").val($(this).attr('data-kdsuburusan'));
                $("#dh-kdprogram").val($(this).attr('data-kdprogram'));
                $("#dh-kdgiat").val($(this).attr('data-kdgiat'));
                $("#dh-kdsub").val($(this).attr('data-kdsub'));
                $("#dh-kdrek").val($(this).attr('data-kdrek'));
                $("#dh-nourut").val($(this).attr('data-nourut'));
                $("#dh-uraian").val($(this).attr('data-uraian'));
            })
            $(".btn-detail-subheader").on('click', function(){
                let kdurusan = $(this).attr('data-kdurusan');
                let kdsuburusan = $(this).attr('data-kdsuburusan');
                let kdprogram = $(this).attr('data-kdprogram');
                let kdgiat = $(this).attr('data-kdgiat');
                let kdsub = $(this).attr('data-kdsub');
                let kdrek = $(this).attr('data-kdrek');
                let nourut = $(this).attr('data-nourut');
                let urut = $(this).attr('data-urut');
                $.ajax({
                    url: "{{ route('admin.input-rincian-rka.data-rinci-parsial1') }}",
                    method: "POST",
                    dataType: "JSON",
                    data:{
                        kdurusan: kdurusan,
                        kdsuburusan: kdsuburusan,
                        kdprogram: kdprogram,
                        kdgiat: kdgiat,
                        kdsub: kdsub,
                        kdrek: kdrek,
                        nourut: nourut,
                        urut: urut,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data){
                        console.log(data)
                        $('#modal-detail-subheader').modal('show');
                        $('#modal-detail-subheader').modal({
                            backdrop: 'static',
                            keyboard: false
                        });
                        $("#ds-kdurusan").val(data.kdurusan);
                        $("#ds-kdsuburusan").val(data.kdsuburusan);
                        $("#ds-kdprogram").val(data.kdprogram);
                        $("#ds-kdgiat").val(data.kdgiat);
                        $("#ds-kdsub").val(data.kdsub);
                        $("#ds-kdrek").val(data.kdrek);
                        $("#ds-nourut").val(data.nourut);
                        $("#ds-urut").val(data.urut);
                        $("#ds-uraian").val(data.uraian);
                        $("#ds-sat1").val(data.sat1);
                        $("#ds-sat2").val(data.sat2);
                        $("#ds-sat3").val(data.sat3);
                        $("#ds-sat4").val(data.sat4);
                        $("#ds-vol1").val(data.vol1);
                        $("#ds-vol2").val(data.vol2);
                        $("#ds-vol3").val(data.vol3);
                        $("#ds-vol4").val(data.vol4);
                        $("#ds-volume").val(data.volume);
                        $("#ds-satuan").val(data.satuan);
                        $("#ds-harga").val(data.harga);
                        $("#ds-jumlah").val(data.jumlah);
                    }
                });
            });
            $('.btn-tambah-subheader').on('click', function(){
                $('#modal-tambah-subheader').modal('show');
                $('#modal-tambah-subheader').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#loading-index').hide();
                $('#table-index').hide();
                $("#ts-kdurusan").val($(this).attr('data-kdurusan'));
                $("#ts-kdsuburusan").val($(this).attr('data-kdsuburusan'));
                $("#ts-kdprogram").val($(this).attr('data-kdprogram'));
                $("#ts-kdgiat").val($(this).attr('data-kdgiat'));
                $("#ts-kdsub").val($(this).attr('data-kdsub'));
                $("#ts-kdrek").val($(this).attr('data-kdrek'));
                $("#ts-nourut").val($(this).attr('data-nourut'));
            })
            $('#btn-index').on('click', function(){
                getIndex();
            });
            $('#q-index').on('keypress', function(e) {
                if(e.which == 13) {
                    getIndex();
                }
            });

            function getIndex() {
                $('#loading-index').text("Memuat...");
                $('#loading-index').show(500);
                $('#table-index').hide();
                let q = $('#q-index').val();
                $.ajax({
                    url: "{{ config('variable.api-index') }}",
                    method: "GET",
                    dataType: "JSON",
                    data:{
                        tahun: 2021,
                        keyword: q
                    },
                    success: function(data){
                        if (data.data.length > 0) {
                            $('#loading-index').hide(500);
                            $('#table-index').show();
                            let html = ``; 
                            for (let i = 0; i < data.data.length; i++) {
                                html += `
                                    <tr>
                                        <td>
                                            <input type="radio" class="radio-index" data-uraian="${data.data[i].namassh}" data-spesifikasi="${data.data[i].spesifikasi}" data-harga="${data.data[i].harga}" data-satuan="${data.data[i].satuan}" value="${data.data[i].kodessh}" name="idssh" required>
                                        </td>
                                        <td>${data.data[i].namassh}</td>
                                        <td>${data.data[i].kelompok}</td>
                                        <td>${data.data[i].spesifikasi}</td>
                                        <td>${data.data[i].satuan}</td>
                                        <td>${data.data[i].harga}</td>
                                        <td>${data.data[i].keterangan}</td>
                                    </tr>
                                `;
                            }
                            $('#data-index').html(html);
                        }else{
                            $('#loading-index').text("Data SSH tidak ditemukan. Coba lagi dengan keyword lain");
                        }
                    }
                });
            }

            $(document).on("click", '.radio-index', function() {
                $("#ts-uraian").val($(this).attr('data-uraian'));
                $("#ts-spesifikasi").val($(this).attr('data-spesifikasi'));
                $("#ts-harga").val($(this).attr('data-harga'));
                $("#ts-satuan").val($(this).attr('data-satuan'));
            });
        });
    </script>
    {{-- END SCRIPT --}}

    {{-- BEGIN MODAL --}}
    <div class="modal fade" id="modal-tambah-header">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Header</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.input-rka.create-parsial1') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <label>Nama Header</label>
                        <div class="input-group">
                            <textarea class="form-control @error('uraian') is-invalid @enderror" placeholder="Ketikkan nama header..." name="uraian" required></textarea>
                            @error('uraian')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="modal-detail-header">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Header</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.input-rka.create-parsial1') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <label>Nama Header</label>
                        <div class="input-group">
                            <textarea class="form-control @error('uraian') is-invalid @enderror" placeholder="Ketikkan nama header..." id="dh-uraian" name="uraian" required></textarea>
                            @error('uraian')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <input type="hidden" id="dh-kdurusan" name="kdurusan">
                <input type="hidden" id="dh-kdsuburusan" name="kdsuburusan">
                <input type="hidden" id="dh-kdprogram" name="kdprogram">
                <input type="hidden" id="dh-kdgiat" name="kdgiat">
                <input type="hidden" id="dh-kdsub" name="kdsub">
                <input type="hidden" id="dh-kdrek" name="kdrek">
                <input type="hidden" id="dh-nourut" name="nourut">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="modal-tambah-subheader">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Rincian RKA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row m-1 mb-3">
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control" id="q-index" placeholder="Ketikkan nama ssh...">
                        <span class="input-group-append">
                            <button type="button" class="btn btn-success btn-flat" id="btn-index">Cari</button>
                        </span>
                    </div>
                </div>
                <h4 class="text-center" id="loading-index">Memuat...</h4>
                <form action="{{ route('admin.input-rincian-rka.create-parsial1') }}" method="POST">
                    @csrf
                    <div class="table-responsive" style="display: block; position: relative; height: 500px; overflow: auto;" id="table-index">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Pilih</th>
                                    <th>Nama SSH</th>
                                    <th>Kelompok</th>
                                    <th>Spesifikasi</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="data-index">
                            </tbody>
                        </table>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <input type="hidden" id="ts-kdurusan" name="kdurusan">
                <input type="hidden" id="ts-kdsuburusan" name="kdsuburusan">
                <input type="hidden" id="ts-kdprogram" name="kdprogram">
                <input type="hidden" id="ts-kdgiat" name="kdgiat">
                <input type="hidden" id="ts-kdsub" name="kdsub">
                <input type="hidden" id="ts-kdrek" name="kdrek">
                <input type="hidden" id="ts-nourut" name="nourut">
                <input type="hidden" id="ts-uraian" name="uraian">
                <input type="hidden" id="ts-spesifikasi" name="spesifikasi">
                <input type="hidden" id="ts-harga" name="harga">
                <input type="hidden" id="ts-satuan" name="satuan">
                <input type="hidden" name="tipe" value="{{ Request::input('tipe') }}">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="modal-detail-subheader">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Rincian RKA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.input-rka.create-parsial1') }}" method="POST">
                    @csrf
                    <div class="input-group row mb-1">
                        <label class="col-sm-3 col-form-label">Uraian Sub Header</label>
                        <div class="col-sm-9">
                            <textarea type="" class="form-control @error('uraian') is-invalid @enderror" id="ds-uraian" name="uraian" required placeholder="Ketikkan uraian sub header..."></textarea>
                            @error('uraian')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="input-group row mb-1">
                        <label class="col-sm-3 col-form-label">Volume 1</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control @error('vol1') is-invalid @enderror" id="ds-vol1" name="vol1" required placeholder="Ketikkan volume 1...">
                            @error('vol1')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <label class="col-sm-2 col-form-label">Satuan 1</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control @error('sat1') is-invalid @enderror" id="ds-sat1" name="sat1" required placeholder="Ketikkan satuan 1...">
                            @error('sat1')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="input-group row mb-1">
                        <label class="col-sm-3 col-form-label">Volume 2</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control @error('vol2') is-invalid @enderror" id="ds-vol2" name="vol2" required placeholder="Ketikkan volume 1...">
                            @error('vol2')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <label class="col-sm-2 col-form-label">Satuan 2</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control @error('sat2') is-invalid @enderror" id="ds-sat2" name="sat2" required placeholder="Ketikkan satuan 1...">
                            @error('sat2')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="input-group row mb-1">
                        <label class="col-sm-3 col-form-label">Volume 3</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control @error('vol3') is-invalid @enderror" id="ds-vol3" name="vol3" required placeholder="Ketikkan volume 3...">
                            @error('vol3')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <label class="col-sm-2 col-form-label">Satuan 3</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control @error('sat3') is-invalid @enderror" id="ds-sat3" name="sat3" required placeholder="Ketikkan satuan 3...">
                            @error('sat3')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="input-group row mb-1">
                        <label class="col-sm-3 col-form-label">Volume 4</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control @error('vol4') is-invalid @enderror" id="ds-vol4" name="vol4" required placeholder="Ketikkan volume 4...">
                            @error('vol4')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <label class="col-sm-2 col-form-label">Satuan 4</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control @error('sat4') is-invalid @enderror" id="ds-sat4" name="sat4" required placeholder="Ketikkan satuan 4...">
                            @error('sat4')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="input-group row mb-1">
                        <label class="col-sm-3 col-form-label">Harga</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('harga') is-invalid @enderror" id="ds-harga" name="harga" required placeholder="Ketikkan harga...">
                            @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="input-group row mb-1">
                        <label class="col-sm-3 col-form-label">Volume</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('volume') is-invalid @enderror" id="ds-volume" readonly name="volume" required placeholder="Ketikkan volume...">
                            @error('volume')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="input-group row mb-1">
                        <label class="col-sm-3 col-form-label">Satuan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('satuan') is-invalid @enderror" id="ds-satuan" readonly name="satuan" required placeholder="Ketikkan satuan...">
                            @error('satuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="input-group row mb-1">
                        <label class="col-sm-3 col-form-label">Jumlah</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('jumlah') is-invalid @enderror" id="ds-jumlah" name="jumlah" required placeholder="Ketikkan jumlah...">
                            @error('jumlah')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <input type="hidden" id="ds-kdurusan" name="kdurusan">
                <input type="hidden" id="ds-kdsuburusan" name="kdsuburusan">
                <input type="hidden" id="ds-kdprogram" name="kdprogram">
                <input type="hidden" id="ds-kdgiat" name="kdgiat">
                <input type="hidden" id="ds-kdsub" name="kdsub">
                <input type="hidden" id="ds-kdrek" name="kdrek">
                <input type="hidden" id="ds-nourut" name="nourut">
                <input type="hidden" id="ds-urut" name="urut">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="modal-delete-subheader">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Hapus Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.input-rincian-rka.delete-parsial1') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <p class="modal-text">Apakah anda yakin akan menghapus? <b id="delete-data"></b></p>
                    <input type="hidden" id="hs-kdurusan" name="kdurusan">
                    <input type="hidden" id="hs-kdsuburusan" name="kdsuburusan">
                    <input type="hidden" id="hs-kdprogram" name="kdprogram">
                    <input type="hidden" id="hs-kdgiat" name="kdgiat">
                    <input type="hidden" id="hs-kdsub" name="kdsub">
                    <input type="hidden" id="hs-kdrek" name="kdrek">
                    <input type="hidden" id="hs-nourut" name="nourut">
                    <input type="hidden" id="hs-urut" name="urut">
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
@extends('admin.layout.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i> Tambah</a>
                    </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped datatable yajra-datatable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User ID</th>
                                <th>Password</th>
                                <th>OPD</th>
                                <th>Otorisasi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
        </div>
    </div>
<script>
    $(function() {
        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.otorisasi.index') }}",
            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'user_id',
                    name: 'user_id'
                },
                {
                    data: 'password',
                    name: 'password'
                },
                {
                    data: 'nmurusan',
                    name: 'nmurusan'
                },
                {
                    data: 'otorisasi',
                    name: 'otorisasi'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: true
                },
            ]
        });
    });
    $(document).ready(function() {
        $(document).on("click", '.btn-edit', function() {
            let id = $(this).attr("data-id");
            $('#modal-edit').modal('show');
            $('#modal-edit').modal({
                backdrop: 'static',
                keyboard: false
            });
            $.ajax({
                url: "{{ route('admin.otorisasi.data') }}",
                type: "POST",
                dataType: "JSON",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    console.log(data);
                    $("#id").val(data.id);
                    $("#user_id").val(data.user_id);
                    $("#opd").val(data.opd);
                    $("#password").val(data.password);
                    $("#otorisasi").val(data.otorisasi);
                },
            });
        });
        $(document).on("click", '.btn-delete', function() {
            let id = $(this).attr("data-id");
            let name = $(this).attr("data-name");
            $("#did").val(id);
            $("#delete-data").html(name);
            $('#modal-delete').modal('show');
            $('#modal-delete').modal({
                backdrop: 'static',
                keyboard: false
            });
        });
    });
</script>
<div class="modal fade" id="modal-tambah">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Tambah Data</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.otorisasi.create') }}" method="POST">
                @csrf
                <div class="input-group">
                    <label>ID</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('id') is-invalid @enderror" placeholder="User ID" name="id" value="{{ old('id') }}" required>
                        @error('id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>User ID</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('user_id') is-invalid @enderror" placeholder="User ID" name="user_id" value="{{ old('user_id') }}" required>
                        @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" autocomplete="off" required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>OPD</label>
                    <div class="input-group">
                        <select class="form-control @error('opd') is-invalid @enderror" name="opd" value="{{ old('opd') }}">
                            <option value="-">-- Tidak Ada --</option>
                            @foreach ($urusan as $u)
                                <option value="{{ $u->kdurusan }}">{{ $u->kdurusan." - ".$u->nmurusan }}</option>
                            @endforeach
                        </select>
                        @error('opd')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Level</label>
                    <div class="input-group">
                        <select class="form-control @error('otorisasi') is-invalid @enderror" name="otorisasi" value="{{ old('otorisasi') }}" required>
                            <option value="ADMINISTRATOR">ADMINISTRATOR</option>
                            <option value="AUDITOR">AUDITOR</option>
                            <option value="BAPPEDA">BAPPEDA</option>
                            <option value="BENDAHARA PENERIMAAN">BENDAHARA PENERIMAAN</option>
                            <option value="BENDAHARA PENGELUARAN">BENDAHARA PENGELUARAN</option>
                            <option value="BENDAHARA PPKD">BENDAHARA PPKD</option>
                            <option value="PPK">PPK</option>
                            <option value="SIMPEL">SIMPEL</option>
                        </select>
                        @error('otorisasi')
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
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Edit Data</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.otorisasi.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="input-group">
                    <label>ID</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('id') is-invalid @enderror" placeholder="ID" name="id" id="id" value="{{ old('id') }}" disabled>
                        @error('id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>User ID</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('user_id') is-invalid @enderror" placeholder="User ID" name="user_id" id="user_id" value="{{ old('user_id') }}" readonly>
                        @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <div class="input-group">
                        <input type="text" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" id="password" autocomplete="off" required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>OPD</label>
                    <div class="input-group">
                        <select class="form-control @error('opd') is-invalid @enderror" name="opd" id="opd" value="{{ old('opd') }}">
                            <option value="-">-- Tidak Ada --</option>
                            @foreach ($urusan as $u)
                                <option value="{{ $u->kdurusan }}">{{ $u->kdurusan." - ".$u->nmurusan }}</option>
                            @endforeach
                        </select>
                        @error('opd')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input-group">
                    <label>Level</label>
                    <div class="input-group">
                        <select class="form-control @error('otorisasi') is-invalid @enderror" name="otorisasi" id="otorisasi" value="{{ old('otorisasi') }}" required>
                            <option value="ADMINISTRATOR">ADMINISTRATOR</option>
                            <option value="AUDITOR">AUDITOR</option>
                            <option value="BAPPEDA">BAPPEDA</option>
                            <option value="BENDAHARA PENERIMAAN">BENDAHARA PENERIMAAN</option>
                            <option value="BENDAHARA PENGELUARAN">BENDAHARA PENGELUARAN</option>
                            <option value="BENDAHARA PPKD">BENDAHARA PPKD</option>
                            <option value="PPK">PPK</option>
                            <option value="SIMPEL">SIMPEL</option>
                        </select>
                        @error('otorisasi')
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
<div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Hapus Data</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.otorisasi.delete') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('DELETE')
                <p class="modal-text">Apakah anda yakin akan menghapus? <b id="delete-data"></b></p>
                <input type="hidden" name="id" id="did">
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
@endsection
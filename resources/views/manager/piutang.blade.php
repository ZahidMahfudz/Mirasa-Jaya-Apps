@extends('manager.layout')
@section('main_content')
    <h1>Piutang Usaha</h1>
    <div>
        <p>
            Update :
            @foreach ($total_piutang as $total_piutang)
                {{ Carbon\Carbon::parse($total_piutang->update)->format('d F Y') }}

        </p>
    </div>

    <div>
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahPiutang">Tambah Piutang</button>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <p><b>Total Piutang :
                    {{ number_format($total_piutang->total_piutang) }}
            @endforeach
            </b></p>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Toko</th>
                        <th>Tanggal Piutang</th>
                        <th>Keterangan</th>
                        <th>Total Piutang</th>
                        <th>Pelunasan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($piutang as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nama_toko }}</td>
                            <td>{{ Carbon\Carbon::parse($item->tanggal_piutang)->format('d F Y') }}</td>
                            <td>{{ $item->Keterangan }}</td>
                            <td>{{ number_format($item->total_piutang) }}</td>
                            <td>
                                <a href="/piutanglunas/{{ $item->id }}" class="btn btn-danger""> Belum Lunas</a>
                            </td>
                            <td>
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editPiutang-{{ $item->id }}">Edit</button>
                            </td>
                        </tr>
                        <div class="modal fade" id="editPiutang-{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Edit Piutang</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="editPiutang/{{ $item->id }}" method="post">
                                            @csrf
                                            <div class="mt-2">
                                                <label for="nama_toko" class="form-label">Nama Toko :</label>
                                                <input type="text" name="nama_toko" id="nama_toko" class="form-control" value="{{ $item->nama_toko }}" disabled>
                                            </div>
                                            <div class="mt-2">
                                                <label for="tanggal_piutang" class="form-label">Tanggal Piutang:</label>
                                                <input type="Date" name="tanggal_piutang" id="tanggal_piutang" class="form-control  @error('tanggal_piutang') is-invalid @enderror" value="{{ old('tanggal_piutang', $item->tanggal_piutang) }}">
                                                @error('tanggal_piutang')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mt-2">
                                                <label for="total_piutang" class="form-label">Total Piutang:</label>
                                                <input type="number" name="total_piutang" id="total_piutang" class="form-control  @error('total_piutang') is-invalid @enderror" value="{{ old('total_piutang', $item->total_piutang) }}">
                                                @error('total_piutang')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mt-2">
                                                <label for="keterangan" class="form-label">Keterangan :</label>
                                                <input type="text" name="keterangan" id="keterangan" class="form-control  @error('keterangan') is-invalid @enderror" value="{{ old('keterangan', $item->Keterangan) }}">
                                                @error('keterangan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mt-2">
                                                <label for="oleh" class="form-label">Oleh :</label>
                                                <input type="text" name="oleh" id="oleh" class="form-control  @error('oleh') is-invalid @enderror" value="{{ old('oleh', $item->oleh) }}">
                                                @error('oleh')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Edit</button>
                                            </div>
                                        </form>
                                    </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <p><b>Pemberi Piutang Usaha</b></p>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-sm border border-dark align-middle w-50">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Total Piutang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($totalsby as $total)
                        <tr>
                            <td>{{ $total->oleh }}</td>
                            <td>{{ number_format($total->total) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="tambahPiutang" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Piutang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/user/manager/tambahpiutang" method="post">
                            @csrf
                            <div class="mt-2">
                                <label for="nama_toko" class="form-label">Nama Toko :</label>
                                <input type="text" name="nama_toko" id="nama_toko" class="form-control  @error('nama_toko') is-invalid @enderror" value="{{ old('nama_toko') }}">
                                @error('nama_toko')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="tanggal_piutang" class="form-label">Tanggal Piutang:</label>
                                <input type="Date" name="tanggal_piutang" id="tanggal_piutang" class="form-control  @error('tanggal_piutang') is-invalid @enderror" value="{{ old('tanggal_piutang') }}">
                                @error('tanggal_piutang')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="total_piutang" class="form-label">Total Piutang:</label>
                                <input type="number" name="total_piutang" id="total_piutang" class="form-control  @error('total_piutang') is-invalid @enderror" value="{{ old('total_piutang') }}">
                                @error('total_piutang')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="keterangan" class="form-label">Keterangan :</label>
                                <input type="text" name="keterangan" id="keterangan" class="form-control  @error('keterangan') is-invalid @enderror" value="{{ old('keterangan') }}">
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="oleh" class="form-label">Oleh :</label>
                                <input type="text" name="oleh" id="oleh" class="form-control  @error('oleh') is-invalid @enderror" value="{{ old('oleh') }}">
                                @error('oleh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                    </form>
                </div>
        </div>
    </div>
@endsection

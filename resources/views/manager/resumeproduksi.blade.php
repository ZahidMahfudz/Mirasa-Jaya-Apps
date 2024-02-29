<head>
    <title>Mirasa Jaya - Resume Produksi</title>
</head>

@extends('manager.layout')
@section('main_content')
    <h1>Resume Produksi</h1>

    <div class="mt-2">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahResume">Tambah Resume</button>
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editResume">Edit Resume</button>
    </div>

    <div class="modal fade" id="tambahResume" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Resume</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/user/manager/tambahResume" method="POST">
                            @csrf
                            <div>
                                <label for="tanggal_resume" class="form-label">Tanggal Resume:</label>
                                <input type="date" name="tanggal_resume" id="tanggal_resume" class="form-control  @error('tanggal_resume') is-invalid @enderror" value="{{ old('tanggal_resume') }}" required>
                                @error('tanggal_resume')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="nama_produk" class="form-label">Nama Produk :</label>
                                <select name="nama_produk" id="nama_produk" class="form-select">
                                    <option selected>Pilih Produk</option>
                                    @foreach ($produk as $produk)
                                        <option value="{{ $produk->nama_produk }}">{{ $produk->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-2">
                                <label for="in" class="form-label">IN:</label>
                                <input type="number" name="in" id="in" class="form-control  @error('in') is-invalid @enderror" value="{{ old('in') }}" required>
                                @error('in')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="OUT" class="form-label">OUT:</label>
                                <input type="number" name="OUT" id="OUT" class="form-control  @error('OUT') is-OUTvalid @enderror" value="{{ old('OUT') }}" required>
                                @error('OUT')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="modal-footer mt-3">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editResume" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Resume</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/user/manager/editResume" method="POST">
                            @csrf
                            <div>
                                <label for="tanggal_resume" class="form-label">Tanggal Resume:</label>
                                <input type="date" name="tanggal_resume" id="tanggal_resume" class="form-control  @error('tanggal_resume') is-invalid @enderror" value="{{ old('tanggal_resume') }}" required>
                                @error('tanggal_resume')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="nama_produk" class="form-label">Nama Produk :</label>
                                <select name="nama_produk" id="nama_produk" class="form-select">
                                    <option selected>Pilih Produk</option>
                                    @foreach ($produks as $produks)
                                        <option value="{{ $produks->nama_produk }}">{{ $produks->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-2">
                                <label for="in" class="form-label">IN:</label>
                                <input type="number" name="in" id="in" class="form-control  @error('in') is-invalid @enderror" value="{{ old('in') }}" required>
                                @error('in')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="OUT" class="form-label">OUT:</label>
                                <input type="number" name="OUT" id="OUT" class="form-control  @error('OUT') is-OUTvalid @enderror" value="{{ old('OUT') }}" required>
                                @error('OUT')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="modal-footer mt-3">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                <thead>
                    <tr>
                        <th rowspan="2">Nama Produk</th>
                        @foreach ($uniqueDates as $tanggal)
                            <th colspan="3">{{ $tanggal }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach ($uniqueDates as $tanggal)
                            <th>in</th>
                            <th>out</th>
                            <th>sisa</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groupedData as $nama_produk => $data_per_produk)
                        <tr>
                            <td>{{ $nama_produk }}</td>
                            @foreach ($uniqueDates as $tanggal)
                                @php
                                    $data_tanggal = $data_per_produk->where('tanggal', $tanggal)->first();
                                @endphp
                                <td>{{ $data_tanggal ? $data_tanggal->in : '' }}</td>
                                <td>{{ $data_tanggal ? $data_tanggal->out : '' }}</td>
                                <td>{{ $data_tanggal ? $data_tanggal->sisa : '' }}</td>
                            @endforeach
                        </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

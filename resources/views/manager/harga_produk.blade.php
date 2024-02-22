<title>Mirasa Jaya - Harga Produk</title>

@extends('manager.layout')
@section('main_content')
<h1>Harga Produk</h1>

<div class="mt-2">
    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahProduk">Tambah Produk</button>
</div>
<div class="mt-3">
    <table class="table table-bordered table-striped table-sm border border-dark align-middle">
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th>Nama Produk</th>
                <th>Harga Satuan</th>
                <th style="width: 12%;;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama_produk }}</td>
                    <td>{{ number_format($item->harga_satuan) }}</td>
                    <td>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editProduk-{{ $item->id }}">Edit</button>
                        <a href="/delete/{{ $item->id }}" class="btn btn-danger">Hapus</a>
                    </td>
                </tr>

                <div class="modal fade" id="editProduk-{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Edit Produk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="/editproduk/{{ $item->id }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nama_produk" class="form-label">Nama Produk :</label>
                                        <input type="text" name="nama_produk" class="form-control" value="{{ $item->nama_produk }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="harga_satuan" class="form-label">Harga Satuan:</label>
                                        <input type="number" name="harga_satuan" class="form-control" value="{{ $item->harga_satuan }}">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Edit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        </tbody>
    </table>
</div>

  <!-- Modal -->
        <div class="modal fade" id="tambahProduk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="tambahproduk" method="POST">
                                @csrf
                                <div>
                                    <label for="nama_produk" class="form-label">Nama Produk :</label>
                                    <input type="text" name="nama_produk" id="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror" value="{{ old('nama_produk') }}">
                                    @error('nama_produk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label for="harga_satuan" class="form-label">Harga Satuan:</label>
                                    <input type="number" name="harga_satuan" id="harga_satuan" class="form-control  @error('harga_satuan') is-invalid @enderror" value="{{ old('harga_satuan') }}">
                                    @error('harga_satuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
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

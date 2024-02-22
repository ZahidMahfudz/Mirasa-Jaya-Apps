<title>Hutang Bahan Baku</title>

@extends('manager.layout')
@section('main_content')
    <h1>Hutang Bahan Baku</h1>
    <div>
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahHutang">Tambah Hutang</button>
    </div>

    <div class="mt-3">
        <p><b>Total Hutang :
            @foreach ($totalHutangBahanBaku as $total)
                {{ number_format($total->total_hutang_bahan_baku) }}
            @endforeach
        </b></p>
        <table class="table table-bordered table-striped table-sm border border-dark align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Bahan</th>
                    <th>QTY</th>
                    <th>Satuan</th>
                    <th>Harga/Sat</th>
                    <th>Jumlah</th>
                    <th>Supplier</th>
                    <th>Pelunasan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hutangbahanbaku as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nama_bahan }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->satuan }}</td>
                        <td>{{ number_format($item->harga_satuan) }}</td>
                        <td>{{ number_format($item->jumlah) }}</td>
                        <td>{{ $item->supplier }}</td>
                        <td>
                            <a href="/lunas/{{ $item->id }}" class="btn btn-danger">Belum Lunas</a>
                        </td>
                        <td>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editHutang-{{ $item->id }}">Edit</button>
                        </td>
                    </tr>

                    <div class="modal fade" id="editHutang-{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Edit Produk</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="edithutang/{{ $item->id }}" method="post">
                                        @csrf
                                        <div>
                                            <label for="nama_bahan" class="form-label">Nama Bahan :</label>
                                            <select name="nama_bahan" id="nama_bahan" class="form-select">
                                                <option selected disabled>{{ $item->nama_bahan }}</option>
                                        </select>
                                        </div>
                                        <div class="mt-2">
                                            <label for="qty" class="form-label">qty :</label>
                                            <input type="number" name="qty" id="qty" class="form-control " value="{{ $item->qty }}">
                                        </div>
                                        <div class="mt-2">
                                            <label for="supplier" class="form-label">Supplier:</label>
                                            <input type="text" name="supplier" id="supplier" class="form-control" value="{{ $item->supplier }}">
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

    <div class="modal fade" id="tambahHutang" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah hutang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="tambahhutang" method="post">
                            @csrf
                            <div>
                                <label for="nama_bahan" class="form-label">Nama Bahan :</label>
                                <select name="nama_bahan" id="nama_bahan" class="form-select">
                                    <option selected>Pilih Bahan Baku</option>
                                    @foreach ($bahanbaku as $bahan)
                                        <option value="{{ $bahan->nama_bahan }}">{{ $bahan->nama_bahan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-2">
                                <label for="qty" class="form-label">qty :</label>
                                <input type="number" name="qty" id="qty" class="form-control  @error('qty') is-invalid @enderror" value="{{ old('qty') }}">
                                @error('qty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="supplier" class="form-label">Supplier:</label>
                                <input type="text" name="supplier" id="supplier" class="form-control  @error('supplier') is-invalid @enderror" value="{{ old('supplier') }}">
                                @error('supplier')
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

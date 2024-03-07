<head>
    <title>Mirasa Jaya - Rekap Pemasaran</title>
</head>

@extends('manager.layout')
@section('main_content')
    <h1>Rekapitulasi Pemasaran</h1>

    <div class="mt-2">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahDO">Tambah DO</button>
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahNota">Tambah Nota</button>
    </div>

    <div class="modal fade" id="tambahDO" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah DO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="tambahDO" method="POST">
                            @csrf
                            <div>
                                <label for="tanggal_DO" class="form-label">Tanggal DO:</label>
                                <input type="date" name="tanggal_DO" id="tanggal_DO" class="form-control  @error('tanggal_DO') is-invalid @enderror" value="{{ old('tanggal_DO') }}">
                                @error('tanggal_DO')
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
                                <label for="jumlah" class="form-label">Jumlah:</label>
                                <input type="number" name="jumlah" id="jumlah" class="form-control  @error('jumlah') is-invalid @enderror" value="{{ old('jumlah') }}">
                                @error('jumlah')
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

    <div class="modal fade" id="tambahNota" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Nota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/user/manager/tambahNota" method="POST">
                            @csrf
                            <div>
                                <label for="jenis_nota">Jenis Nota</label>
                                <select name="jenis_nota" id="jenis_nota" class="form-select" required>
                                    <option selected>Pilih Jenis Nota</option>
                                    <option value="nota_cash">Cash</option>
                                    <option value="nota_noncash">Non Cash</option>
                                </select>
                            </div>
                            <div class="mt-2">
                                <label for="tanggal_Nota" class="form-label">Tanggal Nota:</label>
                                <input type="date" name="tanggal_Nota" id="tanggal_Nota" class="form-control  @error('tanggal_Nota') is-invalid @enderror" value="{{ old('tanggal_Nota') }}" required>
                                @error('tanggal_Nota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="nama_toko" class="form-label">Nama Toko:</label>
                                <input type="text" name="nama_toko" id="nama_toko" class="form-control  @error('nama_toko') is-invalid @enderror" value="{{ old('nama_toko') }}" required>
                                @error('nama_toko')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="QTY" class="form-label">QTY:</label>
                                <input type="number" name="QTY" id="QTY" class="form-control  @error('QTY') is-invalid @enderror" value="{{ old('QTY') }}" required>
                                @error('QTY')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="nama_produk_nota" class="form-label">Nama Barang :</label>
                                <select name="nama_produk_nota" id="nama_produk_nota" class="form-select" required>
                                    <option selected>Pilih Produk</option>
                                    @foreach ($produks as $item)
                                        <option value="{{ $item->nama_produk }}">{{ $item->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer mt-4">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <div>
                <p><b>Filter Penjualan</b></p>
            </div>
            <div>
                <form action="filter" method="GET">
                    <div class="row">
                        {{-- <div class="col-sm-1">
                            <p>Mulai : </p>
                        </div> --}}
                        <div class="col-sm">
                            {{-- <label for="startDate" class="form-label">Mulai:</label> --}}
                            <input type="date" class="form-control" id="startDate" name="startDate" value="{{ $startDate ?? '' }}" placeholder="mulai">
                        </div>
                        <div class="col-sm-1 text-center">
                            <p>s/d</p>
                        </div>
                        <div class="col-sm">
                            {{-- <label for="endDate" class="form-label">Selesai:</label> --}}
                            <input type="date" class="form-control" id="endDate" name="endDate" value="{{ $endDate ?? '' }}" placeholder="selesai">
                        </div>
                        <div class="col-sm">
                            <label for="submit" class="form-label"></label>
                            <button type="submit" class="btn btn-primary" name="submit" id="submit">Filter</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#laporan_penjualan" type="button" role="tab" aria-controls="laporan_penjualan" aria-selected="false">Laporan Penjualan</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#nota_cash" type="button" role="tab" aria-controls="nota_cash" aria-selected="false">Nota Cash</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#nota_noncash" type="button" role="tab" aria-controls="nota_noncash" aria-selected="false">Nota Non Cash</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="laporan_penjualan" role="tabpanel" aria-labelledby="laporan_penjualan-tab">
                    <div class="mt-2">
                        //tampilkan datanya sesuai rujukan
                        <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                            <thead>
                                <tr>
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">Nama Produk</th>
                                    <th colspan="{{ count($dropout) }}">DO</th>
                                    <th rowspan="2">Jumlah</th>
                                    <th rowspan="2">Nota Cash</th>
                                    <th rowspan="2">Nota Non Cash</th>
                                    <th>SSS</th>
                                </tr>
                                <tr>
                                    // tampilkan data yang sudah di fetch dalam fungsi sesuai rujukan
                                    @foreach ($dropout as $do)
                                        <th>Tanggal DO</th>
                                    @endforeach
                                    <th>Tanggal SSS</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        //sampai bagian ini
                    </div>
                </div>
                <div class="tab-pane fade" id="nota_cash" role="tabpanel" aria-labelledby="nota_cash-tab">
                    <div class="mt-3">
                        <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                             <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Toko</th>
                                    <th>Tanggal Nota</th>
                                    <th>QTY</th>
                                    <th>Nama Barang</th>
                                    <th>Aksi</th>
                                </tr>
                             </thead>
                             <tbody>
                                @php
                                    $totalQtycash = 0; // Inisialisasi total qty di luar loop
                                @endphp
                                @foreach ($notacash as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1  }}</td>
                                        <td>{{ $item->nama_toko  }}</td>
                                        <td>{{ Carbon\Carbon::parse($item->tanggal)->format('d F Y')  }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ $item->nama_barang  }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editnotacash-{{ $item->id }}">Edit</button>
                                            <a href="/deletenota/{{ $item->id }}" class="btn btn-danger btn-sm">Hapus</a>
                                        </td>
                                    </tr>
                                    @php
                                        $totalQtycash += $item->qty; // Menambahkan qty pada setiap iterasi ke totalQty
                                    @endphp
                                    <div class="modal fade" id="editnotacash-{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Edit Nota Cash</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="editNota/{{ $item->id }}" method="POST">
                                                        @csrf
                                                        <div>
                                                            <label for="jenis_nota">Jenis Nota</label>
                                                            <select name="jenis_nota" id="jenis_nota" class="form-select" disabled>
                                                                <option>{{ $item->jenis_nota }}</option>
                                                            </select>
                                                        </div>
                                                        <div class="mt-2">
                                                            <label for="tanggal_Nota" class="form-label">Tanggal Nota:</label>
                                                            <input type="date" name="tanggal_Nota" id="tanggal_Nota" class="form-control  @error('tanggal_Nota') is-invalid @enderror" value="{{ $item->tanggal }}" disabled>
                                                            @error('tanggal_Nota')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="mt-2">
                                                            <label for="nama_toko" class="form-label">Nama Toko:</label>
                                                            <input type="text" name="nama_toko" id="nama_toko" class="form-control  @error('nama_toko') is-invalid @enderror" value="{{ $item->nama_toko }}" disabled>
                                                            @error('nama_toko')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="mt-2">
                                                            <label for="QTY" class="form-label">QTY:</label>
                                                            <input type="number" name="QTY" id="QTY" class="form-control  @error('QTY') is-invalid @enderror" value="{{ $item->qty }}" required>
                                                            @error('QTY')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div>
                                                            <label for="nama_produk_nota" class="form-label">Nama Barang :</label>
                                                            <select name="nama_produk_nota" id="nama_produk_nota" class="form-select" required>
                                                                <option value="{{ $item->nama_barang }}" selected>{{ $item->nama_barang }}</option>
                                                                @foreach ($produks as $itemproduk)
                                                                    @if ($itemproduk->nama_produk != $item->nama_barang)
                                                                        <option value="{{ $itemproduk->nama_produk }}">{{ $itemproduk->nama_produk }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="modal-footer mt-4">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Edit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    <tr>
                                        <td colspan="3"><b>Total</b></td>
                                        {{-- <td></td> --}}
                                        <td>{{ $totalQtycash }}</td>
                                    </tr>
                             </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="nota_noncash" role="tabpanel" aria-labelledby="nota_noncash-tab">
                    <div class="mt-3">
                        <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Toko</th>
                                    <th>Tanggal Nota</th>
                                    <th>QTY</th>
                                    <th>Nama Barang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalQtynoncash = 0; // Inisialisasi total qty di luar loop
                                @endphp
                                @foreach ($notanoncash as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->nama_toko }}</td>
                                        <td>{{ Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}</td>
                                        <td>{{ $item->qty  }}</td>
                                        <td>{{ $item->nama_barang  }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editnotanoncash-{{ $item->id }}">Edit</button>
                                            <a href="deletenota/{{ $item->id }}" class="btn btn-danger btn-sm">Hapus</a>
                                        </td>
                                    </tr>
                                    @php
                                        $totalQtynoncash += $item->qty;
                                    @endphp
                                    <div class="modal fade" id="editnotanoncash-{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Edit Nota Cash</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="editNota/{{ $item->id }}" method="POST">
                                                        @csrf
                                                        <div>
                                                            <label for="jenis_nota">Jenis Nota</label>
                                                            <select name="jenis_nota" id="jenis_nota" class="form-select" disabled>
                                                                <option>{{ $item->jenis_nota }}</option>
                                                            </select>
                                                        </div>
                                                        <div class="mt-2">
                                                            <label for="tanggal_Nota" class="form-label">Tanggal Nota:</label>
                                                            <input type="date" name="tanggal_Nota" id="tanggal_Nota" class="form-control  @error('tanggal_Nota') is-invalid @enderror" value="{{ $item->tanggal }}" disabled>
                                                            @error('tanggal_Nota')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="mt-2">
                                                            <label for="nama_toko" class="form-label">Nama Toko:</label>
                                                            <input type="text" name="nama_toko" id="nama_toko" class="form-control  @error('nama_toko') is-invalid @enderror" value="{{ $item->nama_toko }}" disabled>
                                                            @error('nama_toko')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="mt-2">
                                                            <label for="QTY" class="form-label">QTY:</label>
                                                            <input type="number" name="QTY" id="QTY" class="form-control  @error('QTY') is-invalid @enderror" value="{{ $item->qty }}" required>
                                                            @error('QTY')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div>
                                                            <label for="nama_produk_nota" class="form-label">Nama Barang :</label>
                                                            <select name="nama_produk_nota" id="nama_produk_nota" class="form-select" required>
                                                                <option value="{{ $item->nama_barang }}" selected>{{ $item->nama_barang }}</option>
                                                                @foreach ($produks as $itemproduk)
                                                                    @if ($itemproduk->nama_produk != $item->nama_barang)
                                                                        <option value="{{ $itemproduk->nama_produk }}">{{ $itemproduk->nama_produk }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="modal-footer mt-4">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Edit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                        </div>
                                    </div>
                                @endforeach
                                <tr>
                                    <td colspan="3"><b>Total</b></td>
                                    {{-- <td></td> --}}
                                    <td>{{ $totalQtynoncash }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

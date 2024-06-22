<head>
    <title>Mirasa Jaya - Rekap Pemasaran</title>
</head>

@extends('manager.layout')
@section('main_content')
    <h1>Rekapitulasi Pemasaran</h1>

    <div class="mt-2">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahNota">Tambah
            Nota</button>
    </div>

    <div class="modal fade" id="tambahNota" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                            <input type="date" name="tanggal_Nota" id="tanggal_Nota"
                                class="form-control  @error('tanggal_Nota') is-invalid @enderror"
                                value="{{ old('tanggal_Nota') }}" required>
                            @error('tanggal_Nota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <label for="nama_toko" class="form-label">Nama Toko:</label>
                            <input type="text" name="nama_toko" id="nama_toko"
                                class="form-control  @error('nama_toko') is-invalid @enderror"
                                value="{{ old('nama_toko') }}" required>
                            @error('nama_toko')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-2">
                            <label for="QTY" class="form-label">QTY:</label>
                            <input type="number" name="QTY" id="QTY"
                                class="form-control  @error('QTY') is-invalid @enderror" value="{{ old('QTY') }}"
                                required>
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
                <form action="filterrekappemasaran" method="GET">
                    <div class="row">
                        {{-- <div class="col-sm-1">
                            <p>Mulai : </p>
                        </div> --}}
                        <div class="col-sm">
                            {{-- <label for="startDate" class="form-label">Mulai:</label> --}}
                            <input type="date" class="form-control" id="startDate" name="startDate"
                                value="{{ $startDate ?? '' }}" placeholder="mulai">
                        </div>
                        <div class="col-sm-1 text-center">
                            <p>s/d</p>
                        </div>
                        <div class="col-sm">
                            {{-- <label for="endDate" class="form-label">Selesai:</label> --}}
                            <input type="date" class="form-control" id="endDate" name="endDate"
                                value="{{ $endDate ?? '' }}" placeholder="selesai">
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
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                        data-bs-target="#laporan_penjualan" type="button" role="tab"
                        aria-controls="laporan_penjualan" aria-selected="false">Laporan Penjualan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#nota_cash"
                        type="button" role="tab" aria-controls="nota_cash" aria-selected="false">Nota Cash</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#nota_noncash"
                        type="button" role="tab" aria-controls="nota_noncash" aria-selected="false">Nota Non
                        Cash</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="laporan_penjualan" role="tabpanel"
                    aria-labelledby="laporan_penjualan-tab">
                    <div class="mt-3">
                        <div class="alert alert-warning mt-2" role="alert">
                            <p style="margin-bottom: 0;"><b>PENTING!</b></p>
                            <ul style="margin-bottom: 0;">
                                <li>Untuk mengubah Drop Out, silakan edit pada Resume Produksi bagian out.</li>
                                <li>Untuk penambahan nota, dilakukan setiap hari Sabtu untuk mencegah terjadinya kesalahan data.</li>
                                <li>Nota ditambahkan secara urut sesuai tanggal dari 6 hari ke belakang.</li>
                            </ul>
                        </div>
                        <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Nama Produk
                                    </th>
                                    <th style="text-align: center;">SSS</th>
                                    <th colspan="{{ count($uniqueDates) }}" style="text-align: center;">Drop Out</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Total</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Nota Cash</th>
                                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Nota Non Cash
                                    </th>
                                    <th style="text-align: center;">SSS</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center;">{{ $startDate }}</th>
                                    @foreach ($uniqueDates as $tanggal)
                                        <th style="text-align: center;">{{ $tanggal }}</th>
                                    @endforeach
                                    <th style="text-align: center;">{{ $endDate }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sss = 0;
                                    $grandtotalproduk = 0;
                                    $grandtotalsssstart = 0;
                                    $grandtotalsssend = 0;
                                    $total_cash = 0;
                                    $total_non_cash = 0;
                                @endphp
                                @foreach ($groupedData as $nama_produk => $data_per_produk)
                                    <tr>
                                        <td>{{ $nama_produk }}</td>
                                        @php
                                            $total_produk = 0;
                                            $total_out = 0;
                                            $start_sss = 0;
                                            $end_sss = 0;
                                        @endphp
                                        @foreach ($sssstart as $start)
                                            @if ($start->nama_produk == $nama_produk)
                                                <td>{{ $start->sss }}</td>
                                                @php
                                                    $start_sss = $start->sss;
                                                    $grandtotalsssstart += $start_sss;
                                                @endphp
                                            @endif
                                        @endforeach
                                        @foreach ($uniqueDates as $tanggal)
                                            @php
                                                $data_tanggal = $data_per_produk->where('tanggal', $tanggal)->first();
                                                $out = $data_tanggal ? $data_tanggal->out : 0;
                                                $total_out += $out;
                                                $total_produk += $out;
                                            @endphp
                                            <td>{{ $out != 0 ? $out : '' }}</td>
                                        @endforeach
                                        @php
                                            $produk_sss = $total_produk + $start_sss;
                                            if ($start_sss == 0) {
                                                $produk_sss = $total_produk;
                                            }
                                            $grandtotalproduk += $produk_sss;
                                        @endphp
                                        <td>{{ $produk_sss != 0 ? $produk_sss : '' }}</td>
                                        @foreach ($sumnotapemasaran as $item)
                                            @if ($item->nama_barang == $nama_produk)
                                                <td>{{ $item->jumlah_nota_cash ?? '' }}</td>
                                                <td>{{ $item->jumlah_nota_non_cash ?? '' }}</td>
                                                @php
                                                    $total_cash += $item->jumlah_nota_cash;
                                                    $total_non_cash += $item->jumlah_nota_non_cash;
                                                @endphp
                                                {{-- @else
                                                <td>0</td>
                                                <td>0</td> --}}
                                            @endif
                                        @endforeach
                                        @foreach ($sssend as $end)
                                            @if ($end->nama_produk == $nama_produk)
                                                <td>{{ $end->sss }}</td>
                                                @php
                                                    $end_sss = $end->sss;
                                                    $grandtotalsssend += $end_sss;
                                                @endphp
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                                <tr>
                                    <td style="text-align: center;"><b>Total</b></td>
                                    <td>{{ $grandtotalsssstart }}</td>
                                    @foreach ($uniqueDates as $tanggal)
                                        @php
                                            $total_out_column = $groupedData->sum(function ($data_per_produk) use (
                                                $tanggal,
                                            ) {
                                                $data_tanggal = $data_per_produk->where('tanggal', $tanggal)->first();
                                                return $data_tanggal ? $data_tanggal->out : 0;
                                            });
                                        @endphp
                                        <td>{{ $total_out_column }}</td>
                                    @endforeach
                                    <td>{{ $grandtotalproduk ?? '' }}</td>
                                    <td>{{ $total_cash }}</td>
                                    <td>{{ $total_non_cash }}</td>
                                    <td>{{ $grandtotalsssend }}</td>
                                </tr>
                            </tbody>
                        </table>
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
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->nama_toko }}</td>
                                        <td>{{ Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editnotacash-{{ $item->id }}">Edit</button>
                                            <a href="/deletenota/{{ $item->id }}"
                                                class="btn btn-danger btn-sm">Hapus</a>
                                        </td>
                                    </tr>
                                    @php
                                        $totalQtycash += $item->qty; // Menambahkan qty pada setiap iterasi ke totalQty
                                    @endphp
                                    <div class="modal fade" id="editnotacash-{{ $item->id }}"
                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Edit Nota Cash</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="editNota/{{ $item->id }}" method="POST">
                                                        @csrf
                                                        <div>
                                                            <label for="jenis_nota">Jenis Nota</label>
                                                            <select name="jenis_nota" id="jenis_nota" class="form-select"
                                                                disabled>
                                                                <option>{{ $item->jenis_nota }}</option>
                                                            </select>
                                                        </div>
                                                        <div class="mt-2">
                                                            <label for="tanggal_Nota" class="form-label">Tanggal
                                                                Nota:</label>
                                                            <input type="date" name="tanggal_Nota" id="tanggal_Nota"
                                                                class="form-control  @error('tanggal_Nota') is-invalid @enderror"
                                                                value="{{ $item->tanggal }}" disabled>
                                                            @error('tanggal_Nota')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="mt-2">
                                                            <label for="nama_toko" class="form-label">Nama Toko:</label>
                                                            <input type="text" name="nama_toko" id="nama_toko"
                                                                class="form-control  @error('nama_toko') is-invalid @enderror"
                                                                value="{{ $item->nama_toko }}" disabled>
                                                            @error('nama_toko')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="mt-2">
                                                            <label for="QTY" class="form-label">QTY:</label>
                                                            <input type="number" name="QTY" id="QTY"
                                                                class="form-control  @error('QTY') is-invalid @enderror"
                                                                value="{{ $item->qty }}" required>
                                                            @error('QTY')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div>
                                                            <label for="nama_produk_nota" class="form-label">Nama Barang
                                                                :</label>
                                                            <select name="nama_produk_nota" id="nama_produk_nota"
                                                                class="form-select" required>
                                                                <option value="{{ $item->nama_barang }}" selected>
                                                                    {{ $item->nama_barang }}</option>
                                                                @foreach ($produks as $itemproduk)
                                                                    @if ($itemproduk->nama_produk != $item->nama_barang)
                                                                        <option value="{{ $itemproduk->nama_produk }}">
                                                                            {{ $itemproduk->nama_produk }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="modal-footer mt-4">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
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
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editnotanoncash-{{ $item->id }}">Edit</button>
                                            <a href="deletenota/{{ $item->id }}"
                                                class="btn btn-danger btn-sm">Hapus</a>
                                        </td>
                                    </tr>
                                    @php
                                        $totalQtynoncash += $item->qty;
                                    @endphp
                                    <div class="modal fade" id="editnotanoncash-{{ $item->id }}"
                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                        aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Edit Nota Cash</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="editNota/{{ $item->id }}" method="POST">
                                                        @csrf
                                                        <div>
                                                            <label for="jenis_nota">Jenis Nota</label>
                                                            <select name="jenis_nota" id="jenis_nota" class="form-select"
                                                                disabled>
                                                                <option>{{ $item->jenis_nota }}</option>
                                                            </select>
                                                        </div>
                                                        <div class="mt-2">
                                                            <label for="tanggal_Nota" class="form-label">Tanggal
                                                                Nota:</label>
                                                            <input type="date" name="tanggal_Nota" id="tanggal_Nota"
                                                                class="form-control  @error('tanggal_Nota') is-invalid @enderror"
                                                                value="{{ $item->tanggal }}" disabled>
                                                            @error('tanggal_Nota')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="mt-2">
                                                            <label for="nama_toko" class="form-label">Nama Toko:</label>
                                                            <input type="text" name="nama_toko" id="nama_toko"
                                                                class="form-control  @error('nama_toko') is-invalid @enderror"
                                                                value="{{ $item->nama_toko }}" disabled>
                                                            @error('nama_toko')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="mt-2">
                                                            <label for="QTY" class="form-label">QTY:</label>
                                                            <input type="number" name="QTY" id="QTY"
                                                                class="form-control  @error('QTY') is-invalid @enderror"
                                                                value="{{ $item->qty }}" required>
                                                            @error('QTY')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div>
                                                            <label for="nama_produk_nota" class="form-label">Nama Barang
                                                                :</label>
                                                            <select name="nama_produk_nota" id="nama_produk_nota"
                                                                class="form-select" required>
                                                                <option value="{{ $item->nama_barang }}" selected>
                                                                    {{ $item->nama_barang }}</option>
                                                                @foreach ($produks as $itemproduk)
                                                                    @if ($itemproduk->nama_produk != $item->nama_barang)
                                                                        <option value="{{ $itemproduk->nama_produk }}">
                                                                            {{ $itemproduk->nama_produk }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="modal-footer mt-4">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
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

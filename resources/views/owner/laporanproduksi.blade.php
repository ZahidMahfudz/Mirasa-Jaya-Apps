<head>
    <title>Mirasa Jaya - Laporan Produksi</title>
</head>

@extends('owner.layout')
@section('main_content')
    <h1>Laporan Produksi</h1>

    <div class="card mt-2">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="mt-1">
                        <h5>Rincian Laporan Produksi</h5>
                    </div>
                    <div class="mt-3">
                        <form action="filterlaporanproduksi" method="GET">
                            <div class="row">
                                <div class="col">
                                    <p>periode</p>
                                </div>
                                <div class="col">
                                    {{-- <label for="startDate" class="form-label">Mulai:</label> --}}
                                    <input type="date" class="form-control" id="startDate" name="startDate" value="{{ $startDate ?? '' }}">
                                </div>
                                <div class="col">
                                    <p>s/d</p>
                                </div>
                                <div class="col">
                                    {{-- <label for="endDate" class="form-label">Selesai:</label> --}}
                                    <input type="date" class="form-control" id="endDate" name="endDate" value="{{ $endDate ?? '' }}">
                                </div>
                                <div class="col">
                                    {{-- <label for="submit" class="form-label"></label> --}}
                                    <button type="submit" class="btn btn-primary" name="submit" id="submit">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-1">
                    <a href="" onclick=" this.href='cetak-laporan-produksi/'+ document.getElementById('startDate').value + '/' + document.getElementById('endDate').value " class="btn btn-secondary" target="_blank" >Cetak</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        @foreach ($uniqueDates as $tanggal)
                            <th>{{ $tanggal }}</th>
                        @endforeach
                        <th>jumlah</th>
                        <th>harga/sat</th>
                        <th>total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandTotalProduk = 0;
                        $grandTotalHargaProduk =0;
                    @endphp
                    @foreach ($groupedData as $nama_produk => $data_per_produk)
                        <tr>
                            <td>{{ $nama_produk }}</td>
                            @php
                                $total_in = 0;
                                $total_produk = 0;
                                $total_jumlah_produk = 0;
                                $total_harga_produk = 0;
                            @endphp
                            @foreach ($uniqueDates as $tanggal)
                            @php
                                $data_tanggal = $data_per_produk->where('tanggal', $tanggal)->first();
                                $in = $data_tanggal ? $data_tanggal->in : 0;
                                // Akumulasi jumlah in
                                $total_in += $in;
                                $total_produk += $in;
                            @endphp
                            <td>{{ $in != 0 ? $in : '' }}</td>
                            @endforeach
                            <td>{{ $total_produk }}</td>
                            <!-- Tampilkan harga satuan untuk produk ini -->
                            <td>{{ number_format($produk[$nama_produk] ?? 0) }}</td>
                            <!-- Hitung total berdasarkan total_produk dan harga satuan -->
                            <td>{{ number_format(($produk[$nama_produk] ?? 0) * $total_produk) }}</td>
                        </tr>
                        @php
                            $grandTotalProduk += $total_produk;
                            $grandTotalHargaProduk += ($produk[$nama_produk] ?? 0) * $total_produk;
                        @endphp
                    @endforeach
                    <tr>
                        <td><b>Total</b></td>
                        @foreach ($uniqueDates as $tanggal)
                            @php
                                // Menghitung total in, out, dan sisa untuk setiap tanggal
                                $total_in_column = $groupedData->sum(function ($data_per_produk) use ($tanggal) {
                                    $data_tanggal = $data_per_produk->where('tanggal', $tanggal)->first();
                                    return $data_tanggal ? $data_tanggal->in : 0;
                                });
                            @endphp
                            <td>{{ $total_in_column }}</td>
                        @endforeach
                        <td>{{ $grandTotalProduk }}</td>
                        <td></td>
                        <td>{{ number_format($grandTotalHargaProduk) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@extends('owner.layout')
@section('main_content')
    <h1>Rekapitulasi Pemasaran</h1>
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
                    <div>
                        <p>tab rekapitulasi penjualan</p>
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
                                    </tr>
                                    @php
                                        $totalQtycash += $item->qty; // Menambahkan qty pada setiap iterasi ke totalQty
                                    @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="2"></td>
                                        <td><b>Total</b></td>
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
                                    </tr>
                                    @php
                                        $totalQtynoncash += $item->qty;
                                    @endphp
                                @endforeach
                                <tr>
                                    <td colspan="2"></td>
                                    <td><b>Total</b></td>
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

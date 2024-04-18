@extends('owner.layout')
@section('main_content')
    <h1>Stok roti jadi</h1>
    <div class="card mt-2">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="mt-1">
                        <h5>Rincian Stok Roti Jadi</h5>
                    </div>
                    <div class="mt-3">
                        <form action="filterstokrotijadi" method="GET">
                            <div class="row">
                                <div class="col">
                                    <p>periode</p>
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
                    <a href="" onclick=" this.href='cetak-laporan-produksi/'+ document.getElementById('endDate').value " class="btn btn-secondary" target="_blank" >Cetak</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                <thead>
                    <th>Nama Produk</th>
                    <th>Gudang</th>
                    <th>SSS</th>
                    <th>Total</th>
                    <th>Harga Satuan</th>
                    <th>Harga Total</th>
                </thead>
                <tbody>
                    @foreach ($groupedData as $nama_produk => $data_per_produk)
                        <tr>
                            <td>{{ $nama_produk }}</td>
                            @php
                                $data_tanggal = $data_per_produk->where('tanggal', $endDate)->first();
                                $sisa = $data_tanggal ? $data_tanggal->sisa : 0;
                            @endphp
                            <td>{{ $sisa != 0 ? $sisa : '' }}</td>
                            <td>{{ $sss = 0 }}</td>
                            <td>{{ $sisa + $sss }}</td>
                            <td>{{ number_format($produk[$nama_produk] ?? 'N/A') }}</td>
                            <td>{{ number_format(($produk[$nama_produk] ?? 0) * ($sisa + $sss)) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

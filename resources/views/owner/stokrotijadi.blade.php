<x-layout-owner>
    <x-slot:title>Stok Roti Jadi</x-slot>
    <x-slot:tabs>Owner-Stok Roti Jadi</x-slot>

    <div class="card mt-2">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="mt-1">
                        <h5>Rincian Stok Roti Jadi</h5>
                    </div>
                    <div class="mt-3">
                        <form action="filterstokrotijadi" method="post">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <p>Tanggal</p>
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
                    <a href="" onclick=" this.href='cetak_stok_roti_jadi/'+ document.getElementById('endDate').value " class="btn btn-secondary" target="_blank" >Cetak</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                <thead>
                    <th>Nama Produk</th>
                    <th style="width: 10%">Gudang</th>
                    <th style="width: 10%">SSS</th>
                     <th style="width: 10%">Total</th>
                    <th style="width: 15%">Harga Satuan</th>
                    <th style="width: 15%">Harga Total</th>
                </thead>
                <tbody>
                    @php
                        $totalGudang = 0;
                        $totalSSS = 0;
                        $grandTotal = 0;
                        $grandHargaTotal = 0;
                    @endphp
                    @foreach ($dataStokRotiJadi as $item)
                        <tr>
                            <td>{{ $item->nama_produk }}</td>
                            <td style="text-align: right;">{{ $item->sisa }}</td>
                            <td style="text-align: right;">{{ $item->sss }}</td>
                            <td style="text-align: right;">{{ $item->sss + $item->sisa }}</td>
                            <td style="text-align: right;">{{ number_format($item->harga_satuan) }}</td>
                            <td style="text-align: right;">{{ number_format($item->sisa * $item->harga_satuan) }}</td>
                            @php
                                $totalGudang += $item->sisa;
                                $totalSSS += $item->sss;
                                $grandTotal += $item->sss + $item->sisa;
                                $grandHargaTotal += $item->sisa * $item->harga_satuan;
                            @endphp
                        </tr>
                        @endforeach
                        <tr>
                            <td style="text-align: right;"><b>Total</b></td>
                            <td style="text-align: right;"><b>{{ $totalGudang }}</b></td>
                            <td style="text-align: right;"><b>{{ $totalSSS }}</b></td>
                            <td style="text-align: right;"><b>{{ $grandTotal }}</b></td>
                            <td><b></b></td>
                            <td style="text-align: right;"><b>{{ number_format($grandHargaTotal) }}</b></td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-layout-owner>

{{-- @extends('owner.layout')
@section('main_content')
    <h1>Stok roti jadi</h1>
    
@endsection --}}

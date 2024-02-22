<head>
    <title>Mirasa Jaya-Hutang Bahan Baku</title>
</head>

@extends('owner.layout')
@section('main_content')
    <h1>Hutang Bahan Baku</h1>

    <div>
        <p>
            @foreach ($totalHutangBahanBaku as $total)
                Update: {{ Carbon\Carbon::parse($total->update)->format('d F Y') }}
            @endforeach
        </p>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5>Rincian Hutang Bahan Baku</h5>
                </div>
                <div class="mt-1">
                    <a href="cetakhutangbahanbaku" class="btn btn-secondary" target="_blank" >Cetak</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div>
                <table class="table table-bordered table-sm border border-dark align-middle">
                    <tr>
                        <td><b>Total Hutang Bahan Baku per : {{ Carbon\Carbon::parse($total->update)->format('d F Y') }}</b></td>
                        <td><b>
                            @foreach ($totalHutangBahanBaku as $total)
                                   {{ number_format($total->total_hutang_bahan_baku) }}
                            @endforeach
                        </b></td>
                    </tr>
                </table>
            </div>
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
                        </tr>
                        @endforeach

                </tbody>
            </table>
        </div>
    </div>


    <div class="mt-1">

    </div>
@endsection

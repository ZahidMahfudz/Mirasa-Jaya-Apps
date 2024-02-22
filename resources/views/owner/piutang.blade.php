@extends('owner.layout')
@section('main_content')
    <h1>Piutang Usaha</h1>
    <div class="card mt-3">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5>Rincian Piutang Usaha</h5>
                </div>
                <div class="mt-1">
                    <a href="cetakpiutang" class="btn btn-secondary" target="_blank">Cetak</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div>
                <table class="table table-bordered table-sm border border-dark align-middle">
                    <tr>
                        @foreach ($total_piutang as $total)
                        <td><b>Total Piutang Usaha per: {{ Carbon\Carbon::parse($total->update)->format('d F Y') }}</b></td>
                        <td><b>
                            {{ number_format($total->total_piutang) }}
                        </b></td>
                        @endforeach
                    </tr>
                </table>
            </div>
            <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Toko</th>
                        <th>Tanggal Piutang</th>
                        <th>Keterangan</th>
                        <th>Total Piutang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($piutang as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nama_toko }}</td>
                            <td>{{ Carbon\Carbon::parse($item->tanggal_piutang)->format('d F Y') }}</td>
                            <td>{{ $item->Keterangan }}</td>
                            <td>{{ number_format($item->total_piutang) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
            </table>

            <div>
                <p><b>Oleh : </b></p>
            </div>

            <table class="table table-bordered table-striped table-sm border border-dark align-middle w-50">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Total Piutang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($totalsby as $total)
                        <tr>
                            <td>{{ $total->oleh }}</td>
                            <td>{{ number_format($total->total) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

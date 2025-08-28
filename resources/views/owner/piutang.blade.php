<x-layout-owner>
    <x-slot:title>Piutang Usaha</x-slot>
    <x-slot:tabs>Owner-Piutang Usaha</x-slot>

    <div class="card mt-3">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    {{-- <h5>Rincian Piutang Usaha</h5> --}}
                    <strong>Update : {{ \Carbon\Carbon::parse($update)->translatedFormat('d F Y') }}</strong>
                </div>
                <div class="mt-1">
                    <a href="cetakpiutang" class="btn btn-secondary" target="_blank">Cetak</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <p>Piutang masih berlaku : </p>
            <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                <thead class="text-center">
                    <tr>
                        <th style="width: 2%; text-align: center; vertical-align: middle;" rowspan="2">No</th>
                        <th style="width: 20%; vertical-align: middle;" rowspan="2">Nama Toko</th>
                        <th style="width: 5%; vertical-align: middle;" rowspan="2">Tanggal Piutang</th>
                        <th style="width: 15%; vertical-align: middle;" rowspan="2">Keterangan</th>
                        <th style="width: 30%; text-align: center; vertical-align: middle;" colspan="4">Item Nota</th>
                        <th style="width: 7%; text-align: right; vertical-align: middle;" rowspan="2">Total Piutang</th>
                    </tr>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Qty</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($piutangbelumlunas as $index => $item)
                        <tr>
                            <td style="text-align: center;" rowspan="{{ count($item->item_nota) + 1 }}">{{ $index + 1 }}</td>
                            <td rowspan="{{ count($item->item_nota) + 1 }}">{{ $item->nama_toko }}</td>
                            <td style="text-align: center;" rowspan="{{ count($item->item_nota) + 1 }}">{{ Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                            <td rowspan="{{ count($item->item_nota) + 1 }}">{{ $item->Keterangan }}</td>
                            @foreach ($item->item_nota as $key => $item_nota)
                                <tr>
                                    <td>{{ $item_nota->nama_produk }}</td>
                                    <td class="text-end">{{ number_format($item_nota->qty, 0, ',', '.') }}</td>
                                    <td class="text-end">{{ number_format($item_nota->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="text-end">{{ number_format($item_nota->qty * $item_nota->harga_satuan, 0, ',', '.') }}</td>
                                    @if ($key === 0)
                                        <td class="text-end" rowspan="{{ count($item->item_nota) }}">{{ number_format($item->total_nota, 0, ',', '.') }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tr>
                    @endforeach
                        <tr>
                            <td colspan="8" style="text-align: right;"><b>Total Piutang :</b></td>
                            <td style="text-align: right;">Rp.{{ number_format($total_piutang) }}</td>
                        </tr>
                </tbody>
            </table>

            <div>
                <p>Pemberi piutang : </p>
            </div>

            <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Total Piutang</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalPiutang = 0;
                    @endphp
                    @foreach ($totalsby as $total)
                        @php
                            $totalPiutang += $total->total;
                        @endphp
                        <tr>
                            <td>{{ $total->oleh }}</td>
                            <td style="text-align: right;">{{ number_format($total->total) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td style="text-align: right;"><b>Total Pemberi Piutang :</b></td>
                        <td style="text-align: right;">Rp.{{ number_format($totalPiutang) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-layout-owner>

{{-- @extends('owner.layout')
@section('main_content')
    <h1>Piutang Usaha</h1>
    

@endsection --}}

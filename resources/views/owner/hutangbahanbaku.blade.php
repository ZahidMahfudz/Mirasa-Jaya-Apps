<x-layout-owner>
    <x-slot:title>Hutang Bahan Baku</x-slot>
    <x-slot:tabs>Owner-Hutang Bahan Baku</x-slot>
    <div class="card mt-2">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    {{-- <h5>Rincian Piutang Usaha</h5> --}}
                    <strong>Update : {{ \Carbon\Carbon::parse($update)->translatedFormat('d F Y') }}</strong>
                </div>
                <div class="mt-1">
                    <a href="cetakhutangbahanbaku" class="btn btn-secondary" target="_blank">Cetak</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Bahan</th>
                        <th>QTY</th>
                        <th>Satuan</th>
                        <th>Harga/Sat</th>
                        <th>PPN</th>
                        <th>Jumlah</th>
                        <th>Supplier</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hutangbelumlunas as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ Carbon\Carbon::parse($item->tanggal)->format('d/m/y') }}</td>
                            <td>{{ $item->nama_bahan }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ $item->satuan }}</td>
                            <td style="text-align: right;">{{ number_format($item->harga_satuan) }}</td>
                            <td style="text-align: right;">{{ number_format($item->ppn) }}</td>
                            <td style="text-align: right;">{{ number_format($item->jumlah) }}</td>
                            <td>{{ $item->supplier }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="7" style="text-align: right;"><b>Total Hutang Bahan Baku :</b></td>
                        <td style="text-align: right;">
                            {{-- @foreach ($totalHutangBahanBaku as $total)
                                Rp.{{ number_format($total->total_hutang_bahan_baku) }}
                            @endforeach --}}
                            Rp.{{ number_format($totalHutangBahanBaku) }}
                        </td>
                        <td colspan="2"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <strong>Riwayat Hutang Bahan Baku</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                <thead>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Tanggal Lunas</th>
                    <th>Nama Bahan</th>
                    <th>QTY</th>
                    <th>Satuan</th>
                    <th>Harga Satuan</th>
                    <th>ppn</th>
                    <th>Jumlah</th>
                    <th>supplier</th>
                </thead>
                <tbody>
                    @foreach ($hutanglunas as $index => $lunas)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ Carbon\Carbon::parse($lunas->tanggal)->format('d/m/y') }}</td>
                            <td>{{ Carbon\Carbon::parse($lunas->tanggal_lunas)->format('d/m/y') }}</td>
                            <td>{{ $lunas->nama_bahan }}</td>
                            <td>{{ $lunas->qty }}</td>
                            <td>{{ $lunas->satuan }}</td>
                            <td style="text-align: right;">{{ number_format($lunas->harga_satuan) }}</td>
                            <td style="text-align: right;">{{ number_format($lunas->ppn) }}</td>
                            <td style="text-align: right;">{{ number_format($lunas->jumlah) }}</td>
                            <td>{{ $lunas->supplier }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout-owner>

<x-layout-owner>
    <x-slot:title>Aset Mesin dan Peralatan Produksi</x-slot>
    <x-slot:tabs>Owner-Aset Mesin dan Peralatan Produksi</x-slot>

    <table class="table table-bordered table-striped table-sm border border-dark align-middle">
        <thead>
            <tr>
                <th style="width: 2%; text-align:center;">No.</th>
                <th style="text-align:center;">Mesin / Alat</th>
                <th style="width: 5%; text-align:center;">Jumlah</th>
                <th style="text-align:center;">Harga Beli</th>
                <th style="text-align:center;">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $no = 1;
                $totalAset = 0; 
            @endphp
            @foreach ($assets as $jenis => $assetGroup)
                <tr>
                    <td colspan="5" style="font-weight: bold; text-align: left;">{{ str_replace('_', ' ', $jenis) }}</td>
                </tr>
                @foreach ($assetGroup as $asset)
                    <tr>
                        <td style="text-align:center;">{{ $no++ }}</td>
                        <td>{{ $asset['mesin/alat'] }}</td>
                        <td style="text-align:center;">{{ $asset->jumlah_unit }}</td>
                        <td style="text-align:right;">{{ number_format($asset->harga_beli, 0, ',', '.') }}</td>
                        <td style="text-align:right;">{{ number_format($asset->jumlah, 0, ',', '.') }}</td>
                    </tr>
                    @php
                        $totalAset += $asset->jumlah;
                    @endphp
                @endforeach
            @endforeach
            <tr>
                <td colspan='4' style="text-align: center;"><strong>Total</strong></td>
                <td style="text-align: right;"><strong>{{ number_format($totalAset, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>
</x-layout-owner>
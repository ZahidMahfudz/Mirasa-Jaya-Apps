<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JavaScript (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<h3>Stok Roti Jadi</h3>
<p>Tanggal : {{ Carbon\Carbon::parse($endDate ?? '')->translatedFormat('d F Y') }}</p>

<table class="table table-bordered table-sm border border-dark align-middle">
    <thead>
        <th>Nama Produk</th>
        <th style="width: 10%">Gudang</th>
        {{-- <th style="width: 10%">SSS</th>
        <th style="width: 10%">Total</th> --}}
        <th style="width: 15%">Harga Satuan</th>
        <th style="width: 15%">Harga Total</th>
    </thead>
    <tbody>
        @php
            $totalGudang = 0;
            // $totalSSS = 0;
            // $grandTotal = 0;
            $grandHargaTotal = 0;
        @endphp
        @foreach ($dataStokRotiJadi as $item)
            <tr>
                <td>{{ $item->nama_produk }}</td>
                <td style="text-align: right;">{{ $item->sisa }}</td>
                {{-- <td style="text-align: right;">{{ $item->sss }}</td>
                <td style="text-align: right;">{{ $item->sss + $item->sisa }}</td> --}}
                <td style="text-align: right;">{{ number_format($item->harga_satuan) }}</td>
                <td style="text-align: right;">{{ number_format( $item->sisa * $item->harga_satuan) }}</td>
                @php
                    $totalGudang += $item->sisa;
                    // $totalSSS += $item->SSS;
                    // $grandTotal += $item->sss + $item->sisa;
                    $grandHargaTotal += $item->sisa * $item->harga_satuan;
                @endphp
            </tr>
            @endforeach
            <tr>
                <td style="text-align: right;"><b>Total</b></td>
                <td style="text-align: right;"><b>{{ $totalGudang }}</b></td>
                {{-- <td style="text-align: right;"><b>{{ $totalSSS }}</b></td>
                <td style="text-align: right;"><b>{{ $grandTotal }}</b></td> --}}
                <td><b></b></td>
                <td style="text-align: right;"><b>{{ number_format($grandHargaTotal) }}</b></td>
            </tr>
    </tbody>
</table>

<script type="text/javascript">
    window.print();
</script>
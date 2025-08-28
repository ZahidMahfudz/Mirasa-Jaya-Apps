<head>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JavaScript (Popper.js included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Load Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

<title>Cetak Hutang Bahan Baku</title>
</head>

<h3>Hutang Bahan Baku</h3>

<div class="mt-0">
    <p>
        Update : {{ \Carbon\Carbon::parse($update)->translatedFormat('d F Y') }}
    </p>
    <table class="table table-bordered table-striped table-sm border border-dark align-middle">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Bahan</th>
                <th>QTY</th>
                <th>Harga/Sat</th>
                <th>Jumlah</th>
                <th>PPN</th>
                <th>Total</th>
                <th>Supplier</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hutangbelumlunas as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ Carbon\Carbon::parse($item->tanggal)->format('d/m/y') }}</td>
                    <td>{{ $item->nama_bahan }}</td>
                    <td>{{ $item->qty }} {{ $item->satuan }}</td>
                    <td style="text-align: right;">{{ number_format($item->harga_satuan) }}</td>
                    <td style="text-align: right;">{{ number_format($item->harga_satuan * $item->qty) }}</td>
                    <td style="text-align: right;">{{ number_format($item->ppn) }}</td>
                    <td style="text-align: right;">{{ number_format($item->jumlah) }}</td>
                    <td>{{ $item->supplier }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="7" style="text-align: right;"><b>Total Hutang Bahan Baku :</b></td>
                <td style="text-align: right;">
                    <b>Rp.{{ number_format($totalHutangBahanBaku) }}</b>
                </td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    window.print();
</script>

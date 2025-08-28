<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JavaScript (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <title>Cetak Perawatan Alat Produksi</title>
</head>

<h3>Perawatan Alat Produksi</h3>

<p>Periode 1 Januari 2024 - {{ Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') }}</p>

<div>
    <table class="table table-bordered border border-dark" id="table1">
        <thead>
            <tr>
                <th style="text-align: center; width:2%;">No</th>
                <th style="text-align: center; width:20%;">Tanggal</th>
                <th style="text-align: center;">Hal</th>
                <th style="text-align: center;">Jumlah</th>
                
            </tr>
        </thead>
        <tbody>
            @php
                $totalPerawatan = 0;
            @endphp
            @foreach ($perawatan_alat_produksi as $perawatan_alat_produks)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td style="text-align: center;">{{ \Carbon\Carbon::parse($perawatan_alat_produks->tanggal)->translatedFormat('d F Y') }}</td>
                    <td>{{ $perawatan_alat_produks->hal }}</td>
                    <td style="text-align: right;">{{ number_format($perawatan_alat_produks->jumlah) }}</td>
                </tr>
                @php
                    $totalPerawatan += $perawatan_alat_produks->jumlah;
                @endphp
            @endforeach
            <tr>
                <td colspan="3" style="text-align: right;"><strong>Total</strong></td>
                <td style="text-align: right;"><strong>{{ number_format($totalPerawatan) }}</strong></td>
            </tr>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    window.print();
</script>

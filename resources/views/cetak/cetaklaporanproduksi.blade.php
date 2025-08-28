<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JavaScript (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<h3>Laporan Produksi</h3>
<p>Periode : {{ Carbon\Carbon::parse($startDate ?? '')->format('d F Y') }} - {{ Carbon\Carbon::parse($endDate ?? '')->format('d F Y') }}</p>

<table class="table table-bordered table-striped table-sm border border-dark align-middle">
    <thead>
        <tr>
            <th>Nama Produk</th>
            @foreach ($uniqueDates as $tanggal)
                <th>{{ date('d', strtotime($tanggal)) }}</th>
            @endforeach
            <th>jumlah</th>
            <th>harga/sat</th>
            <th>total</th>
        </tr>
    </thead>
    <tbody>
        @php
            $grandTotalProduk = 0;
            $grandTotalHargaProduk =0;
        @endphp
        @foreach ($groupedData as $nama_produk => $data_per_produk)
            <tr>
                <td>{{ $nama_produk }}</td>
                @php
                    $total_in = 0;
                    $total_produk = 0;
                    $total_jumlah_produk = 0;
                    $total_harga_produk = 0;
                @endphp
                @foreach ($uniqueDates as $tanggal)
                @php
                    $data_tanggal = $data_per_produk->where('tanggal', $tanggal)->first();
                    $in = $data_tanggal ? $data_tanggal->in : 0;
                    // Akumulasi jumlah in
                    $total_in += $in;
                    $total_produk += $in;
                @endphp
                <td>{{ $in != 0 ? $in : '' }}</td>
                @endforeach
                <td>{{ $total_produk }}</td>
                <!-- Tampilkan harga satuan untuk produk ini -->
                <td>{{ $produk[$nama_produk] ?? 'N/A' }}</td>
                <!-- Hitung total berdasarkan total_produk dan harga satuan -->
                <td>{{ number_format(($produk[$nama_produk] ?? 0) * $total_produk) }}</td>
            </tr>
            @php
                $grandTotalProduk += $total_produk;
                $grandTotalHargaProduk += ($produk[$nama_produk] ?? 0) * $total_produk;
            @endphp
        @endforeach
        <tr>
            <td><b>Total</b></td>
            @foreach ($uniqueDates as $tanggal)
                @php
                    // Menghitung total in, out, dan sisa untuk setiap tanggal
                    $total_in_column = $groupedData->sum(function ($data_per_produk) use ($tanggal) {
                        $data_tanggal = $data_per_produk->where('tanggal', $tanggal)->first();
                        return $data_tanggal ? $data_tanggal->in : 0;
                    });
                @endphp
                <td>{{ $total_in_column }}</td>
            @endforeach
            <td>{{ $grandTotalProduk }}</td>
            <td></td>
            <td>{{ number_format($grandTotalHargaProduk) }}</td>
        </tr>
    </tbody>
</table>

<script type="text/javascript">
    window.print();
</script>

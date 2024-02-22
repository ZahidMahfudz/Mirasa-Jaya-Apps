<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JavaScript (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    </head>

<h3>Uang Masuk</h3>
<p>Periode : {{ Carbon\Carbon::parse($startDate ?? '')->format('d F Y') }} - {{ Carbon\Carbon::parse($endDate ?? '')->format('d F Y') }}</p>
<table class="table table-bordered table-sm border border-dark align-middle">
    <thead>
        <tr>
            <th>NO</th>
            <th>Nama Toko</th>
            <th>Tanggal Nota</th>
            <th>QTY</th>
            <th>Nama Produk/ Keterangan</th>
            <th>Harga Satuan</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($piutang as $index => $piutang)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $piutang->nama_toko }}</td>
                <td>{{ Carbon\Carbon::parse($piutang->tanggal)->format('d/m/Y') }}</td>
                <td> </td>
                <td>
                    @if ($piutang->tanggal_lunas == null)
                         -
                    @else
                        <p style="margin: 0;">{{ $piutang->keterangan }}</p>
                        <p style="margin: 0;">lunas : {{ Carbon\Carbon::parse($piutang->tanggal_lunas)->format('d/m/Y') }}</p>
                    @endif
                </td>
                <td> </td>
                <td>{{ number_format($piutang->total_piutang) }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="5" class="border-0"></td>
            <td><b>Total</b></td>
            <td><b>{{ number_format($jumlahpiutang) }}</b></td>
        </tr>
        <tr>
            <td colspan="7"><b>Retail</b></td>
        </tr>
        @foreach ($retail as $index => $retail)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td> </td>
                <td>{{ Carbon\Carbon::parse($retail->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $retail->qty }}</td>
                <td>{{ $retail->nama_produk }}</td>
                <td>{{ number_format($retail->harga_satuan) }}</td>
                <td>{{ number_format($retail->jumlah) }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="5" class="border-0"></td>
            <td><b>total</b></td>
            <td><b>{{ number_format($jumlahretail) }}</b></td>
        </tr>
        <tr>
            <td colspan="6"><b>total</b></td>
            <td><b>{{ number_format($piutangplusretail) }}</b></td>
        </tr>
    </tbody>
</table>

<table class="table table-bordered table-sm border border-dark align-middle mt-1">
    <tbody>
        <tr>
            @foreach ($totaluangmasuk as $totaluangmasuk)
                <th>Total Uang Masuk per {{ Carbon\Carbon::parse($totaluangmasuk->update)->format('d F Y') }} : </th>
                <th>{{ number_format($totaluangmasuk->total_uang_masuk) }}</th>
            @endforeach
        </tr>
    </tbody>
</table>

<script type="text/javascript">
    window.print();
</script>


<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JavaScript (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <title>Cetak Piutang</title>
</head>

<h3>Piutang Usaha</h3>

<div>
    @foreach ($total_piutang as $total)
    <p>update: {{ Carbon\Carbon::parse($total->update)->format('d F Y') }}</p>
    @endforeach
</div>

<div>
    <table class="table table-bordered table-sm border border-dark align-middle">
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
                <tr>
                    <td colspan="3" class="border-0"></td>
                    <td><b>Total</b></td>
                    <td><b>{{ number_format($total->total_piutang) }}</b></td>
                </tr>
            </tbody>
    </table>
</div>


<div class="mt-4">
    <p><b>Oleh : </b></p>
    <table class="table table-bordered table-sm border border-dark align-middle w-50">
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


<script type="text/javascript">
    window.print();
</script>

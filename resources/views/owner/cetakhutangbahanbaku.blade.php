<head>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JavaScript (Popper.js included) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Load Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
</head>

<h3>Hutang Bahan Baku</h3>

<div class="mt-0">
    <p>
        @foreach ($totalHutangBahanBaku as $total)
            Update: {{ $total->update }}
        @endforeach
    </p>
    <table class="table table-bordered table-striped table-sm border border-dark align-middle">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Bahan</th>
                <th>QTY</th>
                <th>Satuan</th>
                <th>Harga/Sat</th>
                <th>Jumlah</th>
                <th>Supplier</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hutangbahanbaku as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama_bahan }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->satuan }}</td>
                    <td>{{ number_format($item->harga_satuan) }}</td>
                    <td>{{ number_format($item->jumlah) }}</td>
                    <td>{{ $item->supplier }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="4"></td>
                    <td><b>Total</b></td>
                    @foreach ($totalHutangBahanBaku as $total)
                        <td colspan="2"><b>{{ number_format($total->total_hutang_bahan_baku) }}</b></td>
                    @endforeach
                </tr>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    window.print();
</script>

<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap JavaScript (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    
    <title>Cetak Drop Out</title>
</head>

<h3>Drop Out</h3>

<p>{{ \Carbon\Carbon::parse($dropOut->tanggal)->translatedFormat('d F Y') }}</p>

<div class="d-flex justify-content-center">
    <h1>Diambil</h1>
</div>

<table style="width: 100%;" class="table table-bordered table-sm border border-dark align-middle mt-3">
    <thead>
        <tr>
            <th style="text-align: center; vertcal-align: middle; width: 50%;" >Nama Barang</th>
            <th style="text-align: center; vertcal-align: middle; width: 50%;">Jumlah Barang</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalDO = 0;
        @endphp
        @foreach ($listDO as $item)
            <tr>
                <td>{{ $item->nama_barang }}</td>
                <td style="text-align: right;">{{ $item->jumlah_barang }}</td>
                @php
                    $totalDO += $item->jumlah_barang;
                @endphp
            </tr>
        @endforeach
        <tr>
            <td style="text-align: right;"><strong>Total :</strong></td>
            <td style="text-align: right;"><strong>{{ $totalDO }}</strong></td>
        </tr>
    </tbody>
</table>

<div class="row mt-5">
    <div class="col-6 text-center">
        <p>Pengambil</p>
        <br><br><br><br>
        <p>{{ $dropOut->nama_pengambil }}</p>
    </div>
    <div class="col-6 text-center">
        <p>Manager</p>
        <br><br><br><br>
        <p>____________________</p>
    </div>
</div>


<script type="text/javascript">
    window.print();
</script>
<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap JavaScript (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    
    <title>Cetak Gaji Karyawan</title>
    </head>
    
    <h3>Gaji Karyawan</h3>

    <p>Periode {{ Carbon\Carbon::parse($tanggalAwal)->translatedFormat('d F Y') }} - {{ Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') }}</p>

    <div>
        <table class="table table-bordered border border-dark">
            <tr>
                <td style="width: 70%;">Total Gaji Karyawan s/d {{ \Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') }}</td>
                <td style="width: 30%; text-align:right;">{{ number_format($totalGaji) }}</td>
            </tr>
        </table>
        <table class="table table-bordered border border-dark mt-2" id="table1">
            <thead>
                <tr>
                    <th style="width: 2%; text-align:center;">No</th>
                    <th style="width: 66,7%; text-align:center;">Tanggal</th>
                    <th style="width: 30%; text-align:center;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1;?>
                @foreach ($gaji_karyawan as $gaji_karyawans)
                <tr>
                    <td style="text-align:center;">{{ $no++ }}</td>
                    <td style="text-align:center;">{{ \Carbon\Carbon::parse($gaji_karyawans->tanggal)->translatedFormat('d F Y') }}</td>
                    <td style="text-align: right;">{{ number_format($gaji_karyawans->jumlah) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script type="text/javascript">
        window.print();
    </script>

<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap JavaScript (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    
    <title>Cetak THR dan Bingkisan Lebaran</title>
    </head>
    
    <h3>THR dan Bingkisan Lebaran</h3>

    <p>Periode 1 Januari - {{ Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') }}</p>

    <div>
        <table class="table table-bordered border border-dark" id="table1">
            <thead>
                <tr>
                    <th style="text-align: center; width:2%;">No</th>
                    <th style="text-align: center; width:20%;">Tanggal</th>
                    <th style="text-align: center; width:46.7%;">hal</th>
                    <th style="text-align: center;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($thr as $thrs)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td style="text-align: center;">{{ \Carbon\Carbon::parse($thrs->tanggal)->translatedFormat('d F Y') }}</td>
                    <td>{{ $thrs->hal }}</td>
                    <td style="text-align: right;">{{ number_format($thrs->jumlah) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3" style="text-align: right"><strong>Total</strong></td>
                    <td style="text-align: right"><strong>{{ number_format($totalTHR) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <script type="text/javascript">
        window.print();
    </script>

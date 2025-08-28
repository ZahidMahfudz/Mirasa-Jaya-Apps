<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap JavaScript (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    
    <title>Cetak Profit Owner</title>
    </head>
    
    <h3>Profit Owner</h3>

    <p>Periode 1 Januari - {{ Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') }}</p>

    <div>
        <table class="table table-bordered border border-dark" id="table1">
            <thead>
                <tr>
                    <th style="text-align: center; width:2%;">No</th>
                    <th style="text-align: center; width:20%;">Tanggal</th>
                    <th style="text-align: center; width:46.7%;">Pembayaran</th>
                    <th style="text-align: center;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($profit_owner as $profit_owners)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td style="text-align: center;">{{ \Carbon\Carbon::parse($profit_owners->tanggal)->translatedFormat('d F Y') }}</td>
                    <td>{{ $profit_owners->hal }}</td>
                    <td style="text-align: right;">{{ number_format($profit_owners->jumlah) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3" style="text-align: right"><strong>Total</strong></td>
                    <td style="text-align: right"><strong>{{ number_format($totalProfit) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <script type="text/javascript">
        window.print();
    </script>

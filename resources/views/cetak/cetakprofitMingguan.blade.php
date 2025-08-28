<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap JavaScript (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    
    <title>Cetak Profit Minggu Ini</title>
    </head>
    
    <h3>Profit Minggu Ini</h3>

    <div>
        <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            @foreach($data as $week)
                                <th style="border-bottom: 1px solid black; text-align:center;">{{ $week['tanggal'] }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Kas</td>
                            @foreach($data as $week)
                                <td style="text-align: right;">{{ number_format($week['kas']) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Piutang Usaha</td>
                            @foreach($data as $week)
                                <td style="text-align: right;">{{ number_format($week['piutang']) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Stock Roti Jadi</td>
                            @foreach($data as $week)
                                <td style="text-align: right;">{{ number_format($week['stok_roti_jadi']) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Stock Bahan Baku dan Kardus</td>
                            @foreach($data as $week)
                                <td style="text-align: right; border-bottom:1px solid #000;">{{ number_format($week['stok_bahan_baku']) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td> </td>
                            @foreach($data as $week)
                            <td style="text-align: right; border-top:1px solid #000;">{{ number_format($totaluang = $week['kas'] + $week['piutang'] + $week['stok_roti_jadi'] + $week['stok_bahan_baku']) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Hutang Bahan Baku</td>
                            @foreach($data as $week)
                            <td style="text-align: right; border-bottom:1px solid #000;">{{ number_format($week['hutang_bb']) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td style="font-weight:bold;"></td>
                            @foreach($data as $week)
                                <td style="text-align: right; font-weight:bold;">
                                    {{ number_format($totaluang - $week['hutang_bb']) }}
                                </td>
                            @endforeach
                        </tr>
                        <tr class="profit-row">
                            <td style="font-weight:bold;">Profit</td>
                            @foreach($data as $week)
                                <td>
                                    
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
    </div>

    <script type="text/javascript">
        window.print();
    </script>
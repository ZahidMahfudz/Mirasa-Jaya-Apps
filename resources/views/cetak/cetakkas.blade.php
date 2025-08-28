    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap JavaScript (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    
    <title>Cetak Kas</title>
</head>

    <div class="row">
          <div class="col" style="width: 10%;">
            <h3>Kas</h3>
            <div class="mt-2">
                <p>Hari : {{ \Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') }}</p>
            </div>
            <div>
                <table class="table table-bordered border border-dark">
                    <thead>
                        <tr>
                            <th style="text-align: center; width:60%;">Item Kas</th>
                            <th style="text-align: center;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalKas = 0;
                        @endphp
                        @foreach ($kas as $item)
                            <tr>
                                <td>{{ $item->kas }}</td>
                                <td style="text-align: right;">{{ number_format($item->jumlah) }}</td>
                            </tr>
                            @php
                                $totalKas += $item->jumlah;
                            @endphp
                        @endforeach
                        <tr>
                            <td>Bank Permata</td>
                            <td style="text-align: right;">{{ number_format($totalKasBankPermataSaldo) }}</td>
                            @php
                                $totalKas += $totalKasBankPermataSaldo;
                            @endphp
                        </tr>
                        <tr>
                            <td style="text-align: center;"><strong>Total</strong></td>
                            <td style="text-align: right;">{{ number_format($totalKas) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
          </div>
          <div class="col">
            <h3>Kas Bank Permata</h3>
            <table class="table table-bordered border border-dark" id="table1">
                <thead>
                    <tr>
                        <th rowspan="2" style="vertical-align: middle; text-align: center; width: 50px;">No</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Tanggal</th>
                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Hal</th>
                        <th colspan="2" style="text-align: center;">Mutasi</th>
                        <th colspan="1" style="text-align: center;">Saldo</th>
                    </tr>
                    <tr>
                        <th style="text-align: center;">Debit</th>
                        <th style="text-align: center;">Kredit</th>
                        <th style="text-align: center;">(Rupiah)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; ?>
                    @foreach ($kas_bank_permata as $data)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ \Carbon\Carbon::parse($data->tanggal)->locale('id')->translatedFormat('j F Y') }}</td>
                        <td>{{ $data->hal }}</td>
                        <td style="text-align: right;">{{ $data->debit !=0 ? number_format($data->debit) : '' }}</td>
                        <td style="text-align: right;">{{ $data->kredit !=0 ? number_format($data->kredit) : '' }}</td>
                        <td style="text-align: right;">{{ $data->saldo != 0 ? number_format($data->saldo) : '' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
        </div>

    <script type="text/javascript">
        window.print();
    </script>

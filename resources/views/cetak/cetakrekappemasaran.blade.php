<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JavaScript (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>Cetak Rekap Pemasaran</title>

    <style>
        @media print {
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>

<body>
    <section id="print-section-1" class="mb-5">
            <h4>Rekapitulasi Pemasaran</h4>
            <p >Periode : {{ \Carbon\Carbon::parse($startDate)->translatedFormat('l, d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->translatedFormat('l, d F Y') }}</p>

            <table class="table table-bordered border border-dark table-sm">
                        <thead class="text-center align-middle">
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2">Nama Produk</th>
                                <th rowspan="2">SSS {{ \Carbon\Carbon::parse($startDate)->format('d/m') }}</th>
                                <th colspan="{{ count($tanggalPeriode) }}">Drop Out Produk</th>
                                <th rowspan="2">Jumlah</th>
                                <th rowspan="2">Nota Cash</th>
                                <th rowspan="2">Nota Non Cash</th>
                                <th rowspan="2">SSS {{ \Carbon\Carbon::parse($endDate)->format('d/m') }}</th>
                            </tr>
                            <tr>
                                @foreach ($tanggalPeriode as $tanggal)
                                    <th>{{ \Carbon\Carbon::parse($tanggal)->format('d/m') }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalSSSAwal = 0;
                                $totalDropOutPerTanggal = array_fill_keys(collect($tanggalPeriode)->map(fn($tanggal) => \Carbon\Carbon::parse($tanggal)->toDateString())->toArray(), 0);
                                $totalDropOut = 0;
                                $totalNotaCash = 0;
                                $totalNotaNonCash = 0;
                                $totalSSSAkhir = 0;
                            @endphp
                            @foreach ($data as $i => $item)
                            <tr>
                                <td class="text-center">{{ $i + 1 }}</td>
                                <td class="text-start">{{ $item['nama_produk'] }}</td>
                                <td class="text-end">{{ number_format($item['sss_awal'], 0, ',', '.') }}</td>
                                @php
                                    $totalSSSAwal += $item['sss_awal'];
                                @endphp
                                @foreach ($tanggalPeriode as $tanggal)
                                    @php
                                        $dropOut = $item['dropout_per_tanggal'][$tanggal->toDateString()] ?? 0;
                                        $totalDropOutPerTanggal[$tanggal->toDateString()] += $dropOut;
                                    @endphp
                                    <td class="text-end">{{ number_format($dropOut, 0, ',', '.') }}</td>
                                @endforeach
                                <td class="text-end">{{ number_format($item['total_dropout'], 0, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($item['nota_cash'], 0, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($item['nota_noncash'], 0, ',', '.') }}</td>
                                <td class="text-end">{{ number_format($item['sss_akhir'], 0, ',', '.') }}</td>
                                @php
                                    $totalDropOut += $item['total_dropout'];
                                    $totalNotaCash += $item['nota_cash'];
                                    $totalNotaNonCash += $item['nota_noncash'];
                                    $totalSSSAkhir += $item['sss_akhir'];
                                @endphp
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" class="text-end">Total</th>
                                <th class="text-end">{{ number_format($totalSSSAwal, 0, ',', '.') }}</th>
                                @foreach ($tanggalPeriode as $tanggal)
                                    <th class="text-end">{{ number_format($totalDropOutPerTanggal[$tanggal->toDateString()], 0, ',', '.') }}</th>
                                @endforeach
                                <th class="text-end">{{ number_format($totalDropOut, 0, ',', '.') }}</th>
                                <th class="text-end">{{ number_format($totalNotaCash, 0, ',', '.') }}</th>
                                <th class="text-end">{{ number_format($totalNotaNonCash, 0, ',', '.') }}</th>
                                <th class="text-end">{{ number_format($totalSSSAkhir, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
    </section>

     <div class="page-break"></div>

    <section id="print-section-2">
        <h4>Nota Cash</h4>
        <p>Periode : {{ \Carbon\Carbon::parse($startDate)->translatedFormat('l, d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->translatedFormat('l, d F Y') }}</p>

        <table class="table table-bordered table-sm border border-dark align-middle mt-3">
                            <thead class="text-center align-middle">
                                <tr>
                                    <th style="width: 3%;">No</th>
                                    <th style="width: 40%;">Nama Toko</th>
                                    <th style="width: 10%;">Tanggal</th>
                                    <th style="width: 5%;">Jumlah</th>
                                    <th style="width: 25%;">Nama Produk</th>
                                    <th style="width: 15%;">Oleh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($notaCash->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada nota cash dalam periode ini.</td>
                                    </tr>
                                @else
                                @php
                                    $totalNotaCash = 0;
                                @endphp
                                    @foreach($notaCash as $nota)
                                        <tr>
                                            <td rowspan="{{ count($nota->item_nota) }}">{{ $loop->iteration }}</td>
                                            <td rowspan="{{ count($nota->item_nota) }}">{{ $nota->nama_toko }}</td>
                                            <td rowspan="{{ count($nota->item_nota) }}" class="text-center">{{ \Carbon\Carbon::parse($nota->tanggal)->format('d/m/Y') }}</td>
                                            @foreach ($nota->item_nota as $index => $item)
                                            @if ($index > 0)
                                            <tr>
                                            @endif
                                                @php
                                                    $totalNotaCash += $item->qty
                                                @endphp
                                                <td class="text-end">{{ number_format($item->qty, 0, ',', '.') }}</td>
                                                <td>{{ $item->nama_produk }}</td>
                                                @if ($index == 0)
                                                    <td rowspan="{{ count($nota->item_nota) }}">{{ $nota->oleh }}</td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total</strong></td>
                                        <td class="text-end"><strong>{{ number_format($totalNotaCash, 0, ',', '.') }}</strong></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
    </section>

    <div class="page-break"></div>

    <section id="print-section-3">
        <h4>Nota Non Cash</h4>
        <p>Periode : {{ \Carbon\Carbon::parse($startDate)->translatedFormat('l, d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->translatedFormat('l, d F Y') }}</p>
        
        <table class="table table-bordered table-sm border border-dark align-middle mt-3">
                            <thead class="text-center align-middle">
                                <tr>
                                    <th style="width: 3%;">No</th>
                                    <th style="width: 40%;">Nama Toko</th>
                                    <th style="width: 10%;">Tanggal</th>
                                    <th style="width: 5%;">Jumlah</th>
                                    <th style="width: 25%;">Nama Produk</th>
                                    <th style="width: 15%;">Oleh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($notaNonCash->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada nota Non cash dalam periode ini.</td>
                                    </tr>
                                @else
                                @php
                                    $totalNotaNonCash = 0;
                                @endphp
                                    @foreach($notaNonCash as $notanc)
                                        <tr>
                                            <td rowspan="{{ count($notanc->item_nota) }}">{{ $loop->iteration }}</td>
                                            <td rowspan="{{ count($notanc->item_nota) }}">{{ $notanc->nama_toko }}</td>
                                            <td rowspan="{{ count($notanc->item_nota) }}" class="text-center">{{ \Carbon\Carbon::parse($notanc->tanggal)->format('d/m/Y') }}</td>
                                            @foreach ($notanc->item_nota as $index => $item)
                                            @if ($index > 0)
                                            <tr>
                                            @endif
                                                @php
                                                    $totalNotaNonCash += $item->qty
                                                @endphp
                                                <td class="text-end">{{ number_format($item->qty, 0, ',', '.') }}</td>
                                                <td>{{ $item->nama_produk }}</td>
                                                @if ($index == 0)
                                                    <td rowspan="{{ count($notanc->item_nota) }}">{{ $notanc->oleh }}</td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total</strong></td>
                                        <td class="text-end"><strong>{{ number_format($totalNotaNonCash, 0, ',', '.') }}</strong></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
    </section>
</body>

<script type="text/javascript">
    window.print();
</script>




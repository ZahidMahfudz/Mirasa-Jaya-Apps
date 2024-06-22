<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JavaScript (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <title>Cetak Stok</title>

    <style>
        @media print {
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>
<body>
    <!-- Tabel Bahan Baku -->
    <div>
        <h3>Stok Bahan Baku</h3>
        <p>Hari: {{ $startDate }}</p>
        <table class="table table-bordered table-sm border border-dark align-middle">
            <thead>
                <tr>
                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Nama Bahan Baku</th>
                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Satuan</th>
                    <th style="text-align: center;">Gudang</th>
                    <th style="text-align: center;">Sisa Resep</th>
                    <th style="text-align: center;">Total Bahan Baku</th>
                    <th style="text-align: center;">WIP</th>
                    <th style="text-align: center;">Total Stok Bahan Baku</th>
                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Harga Satuan</th>
                    <th rowspan="2" style="text-align: center; vertical-align: middle;">Total</th>
                </tr>
                <tr>
                    <th style="text-align: center;">(zak)</th>
                    <th style="text-align: center;">(Kg)</th>
                    <th colspan="3" style="text-align: center;">(zak)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sumtotalbahanbaku = 0;
                @endphp

                @foreach ($stokbb as $bahanbaku)
                    @php
                        $satuanhargasat = $bb->firstWhere('nama_bahan', $bahanbaku->nama_bahan);
                        $gudang = $bahanbaku->gudang;
                        $sisaResep = $bahanbaku->sisa_resep;
                        $satuanPerZak = $satuanhargasat->banyak_satuan;
                        $hargaSatuan = $satuanhargasat->harga_persatuan;
                        $wip = 0;

                        foreach ($rekapReseps as $rekapResep) {
                            foreach ($rekapResep->resep->bahan_resep as $bahanResep) {
                                if ($bahanResep->nama_bahan === $bahanbaku->nama_bahan) {
                                    $wip += $bahanResep->jumlah_bahan_zak * $rekapResep->jumlah_resep;
                                }
                            }
                        }

                        $totalBahanBaku = $gudang + $sisaResep / $satuanPerZak;
                        $totalStokBahanBaku = $totalBahanBaku + $wip;
                        $totalHarga = $totalStokBahanBaku * $hargaSatuan;
                        $sumtotalbahanbaku += $totalHarga;
                    @endphp
                    <tr>
                        <td>{{ $bahanbaku->nama_bahan }}</td>
                        <td>{{ $satuanhargasat->satuan }} ({{ $satuanhargasat->banyak_satuan }} {{ $satuanhargasat->jenis_satuan }})</td>
                        <td>{{ $gudang }}</td>
                        <td>{{ $sisaResep }}</td>
                        <td>{{ $totalBahanBaku }}</td>
                        <td>{{ $wip }}</td>
                        <td>{{ $totalStokBahanBaku }}</td>
                        <td>{{ number_format($hargaSatuan) }}</td>
                        <td>{{ number_format($totalHarga) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="8" style="text-align: right;"><strong>Total</strong></td>
                    <td>{{ number_format($sumtotalbahanbaku) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Page break -->
    <div class="page-break"></div>

    <!-- Tabel Bahan Penolong -->
    <div>
        <h3>Stok Bahan Penolong</h3>
        <p>Hari: {{ $startDate }}</p>
        <table class="table table-bordered table-sm border border-dark align-middle">
            <thead>
                <tr>
                    <th style="text-align: center;">Nama Bahan Penolong</th>
                    <th style="text-align: center;">Satuan</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: center;">Harga Satuan</th>
                    <th style="text-align: center;">Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sumtotalbahanpenolong = 0;
                @endphp
                @foreach ($bp as $bp => $bahanpenolong)
                    <tr>
                        <td>{{ $bahanpenolong->nama_bahan }}</td>
                        <td>{{ $bahanpenolong->satuan }}</td>
                        @php
                            $jumlah = $stokbp->firstWhere('nama_bahan', $bahanpenolong->nama_bahan);
                        @endphp
                        @if ($bahanpenolong)
                            <td>{{ $jumlah->jumlah }}</td>
                            <td>{{ number_format($bahanpenolong->harga_persatuan) }}</td>
                            @php
                                $totalbp = $jumlah->jumlah * $bahanpenolong->harga_persatuan;
                                $sumtotalbahanpenolong += $totalbp
                            @endphp
                            <td>{{ number_format($totalbp) }}</td>
                        @else
                            <td colspan="5">Data bahan Penolong Tidak Ditemukan</td>
                        @endif
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4" style="text-align: right;"><strong>Total</strong></td>
                    <td>{{ number_format($sumtotalbahanpenolong) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Page break -->
    <div class="page-break"></div>

    <!-- Tabel WIP -->
    <div>
        <h3>Work In Progres (WIP)</h3>
        <p>Hari: {{ $startDate }}</p>
        <table class="table table-bordered table-sm border border-dark align-middle">
            <thead>
                <tr>
                    <th style="text-align: center;">No</th>
                    <th style="text-align: center;">Resep</th>
                    <th style="text-align: center;">Lini Produksi</th>
                    <th style="text-align: center;">Jumlah Resep</th>
                    <th style="text-align: center;">Bahan</th>
                    <th style="text-align: center;">Berat (gr)</th>
                    <th style="text-align: center;">Berat (kg)</th>
                    <th style="text-align: center;">Berat (zak)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rekapReseps as $rekapResep)
                    @foreach ($rekapResep->resep->bahan_resep as $index => $bahanResep)
                        <tr>
                            @if ($index === 0)
                                <td rowspan="{{ $rekapResep->resep->bahan_resep->count() }}">{{ $loop->parent->iteration }}</td>
                                <td rowspan="{{ $rekapResep->resep->bahan_resep->count() }}">{{ $rekapResep->resep->nama_resep }}</td>
                                <td rowspan="{{ $rekapResep->resep->bahan_resep->count() }}">{{ $rekapResep->resep->lini_produksi }}</td>
                                <td rowspan="{{ $rekapResep->resep->bahan_resep->count() }}">{{ $rekapResep->jumlah_resep }}</td>
                            @endif
                            <td>{{ $bahanResep->nama_bahan }}</td>
                            <td>{{ $bahanResep->jumlah_bahan_gr * $rekapResep->jumlah_resep }}</td>
                            <td>{{ $bahanResep->jumlah_bahan_kg * $rekapResep->jumlah_resep }}</td>
                            <td>{{ $bahanResep->jumlah_bahan_zak * $rekapResep->jumlah_resep }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</body>

<script type="text/javascript">
    window.print();
</script>

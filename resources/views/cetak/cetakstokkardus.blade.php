<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JavaScript (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <title>Cetak Stok Kardus</title>
</head>

<h3>Stok Kardus</h3>

<div>
    <p>Periode : {{ Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ Carbon\Carbon::parse($endDate)->format('d F Y') }}</p>
</div>
<div>
    <table class="table table-bordered table-sm border border-dark align-middle">
        <thead>
            <tr>
                <th rowspan="2" style="text-align: center; vertical-align: middle;">Nama Kardus</th>
                @foreach ($uniqueDates as $tanggal)
                    <th colspan="2" style="text-align: center; width:10%;">{{ Carbon\Carbon::parse($tanggal)->format('d/m') }}</th>
                @endforeach
            </tr>
            <tr>
                @foreach ($uniqueDates as $tanggal)
                    <th style="text-align: center;">Pakai</th>
                    <th style="text-align: center;">Sisa</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($groupedData as $nama_kardus => $data_per_kardus)
                <tr>
                    <td>{{ $nama_kardus }}</td>

                    @php
                        $total_pakai = 0;
                        $total_sisa = 0;
                    @endphp

                    @foreach ($uniqueDates as $tanggal)
                        @php
                            $data_tgl_kardus = $data_per_kardus->where('tanggal', $tanggal)->first();
                            $pakai = $data_tgl_kardus ? $data_tgl_kardus->pakai : 0;
                            $sisa = $data_tgl_kardus ? $data_tgl_kardus->sisa : 0;

                            $total_pakai += $pakai;
                            $total_sisa += $sisa;
                        @endphp
                        <td style="text-align: right;">{{ $pakai != 0 ? $pakai : '' }}</td>
                        <td style="text-align: right;">{{ $sisa != 0 ? $sisa : '' }}</td>
                    @endforeach
                </tr>

            @endforeach
            <tr>
                <td><b>Total</b></td>
                @foreach ($uniqueDates as $tanggal)
                    @php
                        $total_pakai_column = $groupedData->sum(function ($data_per_kardus) use ($tanggal) {
                            $data_tanggal = $data_per_kardus->where('tanggal', $tanggal)->first();
                            return $data_tanggal ? $data_tanggal->pakai : 0;
                        });
                        $total_sisa_column = $groupedData->sum(function ($data_per_kardus) use ($tanggal) {
                            $data_tanggal = $data_per_kardus->where('tanggal', $tanggal)->first();
                            return $data_tanggal ? $data_tanggal->sisa : 0;
                        });
                    @endphp
                    <td style="text-align: right;"><b>{{ $total_pakai_column }}</b></td>
                    <td style="text-align: right;"><b>{{ $total_sisa_column }}</b></td>
                @endforeach
            </tr>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    window.print();
</script>

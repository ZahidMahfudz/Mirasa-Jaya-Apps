<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JavaScript (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>Cetak Uang Masuk</title>
</head>

<h3>Uang Masuk</h3>
<p>Periode : {{ Carbon\Carbon::parse($startDate ?? '')->format('d F Y') }} - {{ Carbon\Carbon::parse($endDate ?? '')->format('d F Y') }}</p>
<table class="table table-bordered table-sm border border-dark align-middle">
    <thead class="text-center">
        <tr>
                                        <th style="width: 2%; vertical-align: middle;">No</th>
                                        <th style="width: 5%; vertical-align: middle;">Tanggal Nota</th>
                                        <th style="width: 5%; vertical-align: middle;">Jenis Nota</th>
                                        <th style="width: 20%; vertical-align: middle;">Nama Toko</th>
                                        <th style="width: 25%; vertical-align: middle;">Keterangan</th>
                                        <th style="width: 5%; vertical-align: middle;">Tanggal Lunas</th>
                                        <th style="width: 5%; vertical-align: middle;">Qty</th>
                                        <th style="width: 5%; vertical-align: middle;">Harga Satuan</th>
                                        <th style="width: 5%; vertical-align: middle;">Total</th>
                                    </tr>
    </thead>
                                <tbody>
                                    @php
                                        $totaluangmasuknota = 0;
                                    @endphp
                                    @foreach ($piutang as $index => $piutang)
                                        <tr>
                                            <td style="text-align: center;">{{ $index + 1 }}</td>
                                            <td style="text-align: center;">{{ Carbon\Carbon::parse($piutang->tanggal)->format('d/m/Y') }}</td>
                                            <td style="text-align: center;">
                                                @if($piutang->jenis_nota == 'nota_cash')
                                                    Cash
                                                @elseif($piutang->jenis_nota == 'nota_noncash')
                                                    Non Cash
                                                @endif
                                            </td>
                                            <td>{{ $piutang->nama_toko }}</td>
                                            <td>{{ $piutang->keterangan }}</td>
                                            <td style="text-align: center;">
                                                @if ($piutang->tanggal_lunas == null)
                                                    -
                                                @else
                                                    {{ Carbon\Carbon::parse($piutang->tanggal_lunas)->format('d/m/Y') }}
                                                @endif
                                            </td>
                                            <td> </td>
                                            <td> </td>
                                            <td style="text-align: right;">{{ number_format($piutang->total_nota) }}</td>
                                            @php
                                                $totaluangmasuknota += $piutang->total_nota;
                                            @endphp
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="8" style="text-align: right;"><b>Total Uang Masuk dari Nota/Piutang Periode {{ Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} - {{ Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }} </b></td>
                                        <td style="text-align: right;"><strong>Rp.{{ number_format($totaluangmasuknota) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7"><strong>Retail</strong></td>
                                    </tr>
                                    @php
                                        $totaluangmasukretail = 0;
                                    @endphp
                                    @foreach ($retail as $item)
                                        <tr>
                                            <td rowspan="{{ count($item->item_nota) }}" class="text-center">{{ $loop->iteration }}</td>
                                            <td rowspan="{{ count($item->item_nota) }}">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                            <td> </td>
                                            <td rowspan="{{ count($item->item_nota) }}">{{ $item->nama_toko }}</td>
                                            @foreach ($item->item_nota as $index => $product)
                                                @if ($index > 0)
                                                    <tr>
                                                @endif
                                                <td>{{ $product->nama_produk }}</td>
                                                <td> </td>
                                                <td class="text-end">{{ $product->qty }}</td>
                                                <td class="text-end">{{ number_format($product->harga_satuan, 0, ',', '.') }}</td>
                                                    @if ($index == 0)
                                                        <td rowspan="{{ count($item->item_nota) }}" class="text-end">{{ number_format($item->total_nota, 0, ',', '.') }}</td>
                                                    @endif
                                                    @php
                                                        $totaluangmasukretail += $product->qty * $product->harga_satuan;
                                                    @endphp
                                                </tr>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="8" style="text-align: right;"><b>Total Uang Masuk dari retail s/d {{ Carbon\Carbon::parse($update)->translatedFormat('d F Y') }}: </b></td>
                                        <td style="text-align: right;"><strong>Rp.{{ number_format($totaluangmasukretail) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th colspan="8">Total Uang Masuk Periode {{ Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} - {{ Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</th>
                                        <th>Rp.{{ number_format($totaluangmasuknota + $totaluangmasukretail) }}</th>
                                    </tr>
                                </tbody>
</table>

<script type="text/javascript">
    window.print();
</script>


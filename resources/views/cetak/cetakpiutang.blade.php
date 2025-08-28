<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JavaScript (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <title>Cetak Piutang</title>
</head>

<h3>Piutang Usaha</h3>

<div>
    {{-- @foreach ($total_piutang as $total)
    <p>update: {{ Carbon\Carbon::parse($total->update)->format('d F Y') }}</p>
    @endforeach --}}
    <p>update: {{ Carbon\Carbon::parse($update)->translatedFormat('d F Y') }}</p>
</div>

<div>
    <table class="table table-bordered table-sm border border-dark align-middle">
                <thead class="text-center">
                    <tr>
                        <th style="width: 2%; text-align: center; vertical-align: middle;" rowspan="2">No</th>
                        <th style="width: 20%; vertical-align: middle;" rowspan="2">Nama Toko</th>
                        <th style="width: 5%; vertical-align: middle;" rowspan="2">Tanggal Piutang</th>
                        <th style="width: 15%; vertical-align: middle;" rowspan="2">Keterangan</th>
                        <th style="width: 30%; text-align: center; vertical-align: middle;" colspan="4">Item Nota</th>
                        <th style="width: 7%; text-align: right; vertical-align: middle;" rowspan="2">Total Piutang</th>
                    </tr>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Qty</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($piutangbelumlunas as $index => $item)
                        <tr>
                            <td style="text-align: center;" rowspan="{{ count($item->item_nota) + 1 }}">{{ $index + 1 }}</td>
                            <td rowspan="{{ count($item->item_nota) + 1 }}">{{ $item->nama_toko }}</td>
                            <td style="text-align: center;" rowspan="{{ count($item->item_nota) + 1 }}">{{ Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                            <td rowspan="{{ count($item->item_nota) + 1 }}">{{ $item->Keterangan }}</td>
                            @foreach ($item->item_nota as $key => $item_nota)
                                <tr>
                                    <td>{{ $item_nota->nama_produk }}</td>
                                    <td class="text-end">{{ number_format($item_nota->qty, 0, ',', '.') }}</td>
                                    <td class="text-end">{{ number_format($item_nota->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="text-end">{{ number_format($item_nota->qty * $item_nota->harga_satuan, 0, ',', '.') }}</td>
                                    @if ($key === 0)
                                        <td class="text-end" rowspan="{{ count($item->item_nota) }}">{{ number_format($item->total_nota, 0, ',', '.') }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tr>
                    @endforeach
                        <tr>
                            <td colspan="8" style="text-align: right;"><b>Total Piutang :</b></td>
                            <td style="text-align: right;">Rp.{{ number_format($total_piutang) }}</td>
                        </tr>
                </tbody>
            </table>
</div>


<div class="mt-4">
    <p><b>Oleh : </b></p>
    <table class="table table-bordered table-sm border border-dark align-middle">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Total Piutang</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalPiutang = 0;
                    @endphp
                    @foreach ($totalsby as $total)
                        @php
                            $totalPiutang += $total->total;
                        @endphp
                        <tr>
                            <td>{{ $total->oleh }}</td>
                            <td style="text-align: right;">{{ number_format($total->total) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td style="text-align: right;"><b>Total Pemberi Piutang :</b></td>
                        <td style="text-align: right;">Rp.{{ number_format($totalPiutang) }}</td>
                    </tr>
                </tbody>
            </table>
</div>


<script type="text/javascript">
    window.print();
</script>

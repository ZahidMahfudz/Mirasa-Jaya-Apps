<x-layout-manager>
    <x-slot:title>Rekapitulasi Pemasaran</x-slot>
    <x-slot:tabs>Manager-Rekap Pemasaran</x-slot>

    <div class="card mt-3">
        <div class="card-header">
            <div>
                <strong>Rekapitulasi Penjualan periode {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</strong>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="rekapTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="weekly-tab" data-bs-toggle="tab" data-bs-target="#weekly" type="button" role="tab" aria-controls="weekly" aria-selected="true">Rekapitulasi Mingguan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="cash-tab" data-bs-toggle="tab" data-bs-target="#cash" type="button" role="tab" aria-controls="cash" aria-selected="false">Nota Cash</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="non-cash-tab" data-bs-toggle="tab" data-bs-target="#non-cash" type="button" role="tab" aria-controls="non-cash" aria-selected="false">Nota Non Cash</button>
                </li>
            </ul>
            <div class="tab-content mt-3" id="rekapTabsContent">
                <div class="tab-pane fade show active" id="weekly" role="tabpanel" aria-labelledby="weekly-tab">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light text-center align-middle">
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
                </div>
                <div class="tab-pane fade" id="cash" role="tabpanel" aria-labelledby="cash-tab">
                    <div>
                        <h4>Nota Cash</h4>
                        <p>Periode {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</p>
                    </div>
                    <div>
                        <table class="table table-bordered table-striped table-sm border border-dark align-middle mt-3">
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
                    </div>
                </div>
                <div class="tab-pane fade" id="non-cash" role="tabpanel" aria-labelledby="non-cash-tab">
                    <div>
                        <h4>Nota Non Cash</h4>
                        <p>Periode {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</p>
                    </div>
                    <div>
                        <table class="table table-bordered table-striped table-sm border border-dark align-middle mt-3">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout-manager>

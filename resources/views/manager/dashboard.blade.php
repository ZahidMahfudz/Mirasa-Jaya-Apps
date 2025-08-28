<x-layout-manager>
    <x-slot:title>Dashboard</x-slot>
    <x-slot:tabs>Manager-Dashboard</x-slot>
    <div class="mb-4" style="margin-bottom: 40px;">
        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="false">Neraca Saldo</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Laporan Rugi Laba</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Pengeluaran</button>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="mt-3 mb-4">
                    <div style="text-align: center;">
                        <h5>CV.Mirasa Jaya</h5>
                        <h5>Neraca</h5>
                        <h5>Periode : 1 Januari s.d {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</h5>
                    </div>
                    <div style="margin-bottom: 10px;">
                        <table class="table table-bordered table-sm border border-dark align-middle">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align:center; vertical-align:middle; width:50%;">Nama Akun</th>
                                    <th colspan="2" style="text-align: center;">Saldo</th>
                                </tr>
                                <tr>
                                    <th style="text-align: center; width:25%;">Debit</th>
                                    <th style="text-align: center; width:25%;">Kredit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalDebitNeraca = 0;
                                    $totalKreditNeraca = 0;
                                @endphp
                                <tr>
                                    <td colspan="3"><strong>Item Liquid</strong></td>
                                </tr>
                                <tr>
                                    <td>Kas</td>
                                    <td style="text-align: right;">{{ number_format($kas, 0, ',', '.') }}</td>
                                    <td></td>
                                    @php
                                        $totalDebitNeraca += $kas;
                                    @endphp
                                </tr>
                                <tr>
                                    <td>Piutang Usaha</td>
                                    <td style="text-align: right;">{{ number_format($piutang, 0, ',', '.') }}</td>
                                    <td></td>
                                    @php
                                        $totalDebitNeraca += $piutang;
                                    @endphp
                                </tr>
                                <tr>
                                    <td>Stok Roti Jadi</td>
                                    <td style="text-align: right;">{{ number_format($stokrotijadi, 0, ',', '.') }}</td>
                                    <td></td>
                                    @php
                                        $totalDebitNeraca += $stokrotijadi;
                                    @endphp
                                </tr>
                                <tr>
                                    <td>Stok Bahan Baku dan Kardus</td>
                                    <td style="text-align: right;">{{ number_format($bahanbaku, 0, ',', '.') }}</td>
                                    <td></td>
                                    @php
                                        $totalDebitNeraca += $bahanbaku;
                                    @endphp
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Beban Usaha</strong></td>
                                </tr>
                                @foreach ($akun as $item)
                                    <tr>
                                        <td>{{ $item->nama }}</td>
                                        <td style="text-align: right;">{{ number_format($item->debit, 0, ',', '.') }}</td>
                                        <td style="text-align: right;">{{ $item->kredit }}</td>
                                    </tr>
                                    @php
                                        $totalDebitNeraca += $item->debit;
                                    @endphp
                                @endforeach
                                <tr>
                                    <td colspan="3"><strong>Modal</strong></td>
                                </tr>
                                <tr>
                                    <td>Modal Disetor</td>
                                    <td></td>
                                    <td style="text-align: right;">{{ number_format($modalDisetor, 0, ',', '.') }}</td>
                                    @php
                                        $totalKreditNeraca += $modalDisetor;
                                    @endphp
                                </tr>
                                <tr>
                                    <td>Pinjaman Bank Permata</td>
                                    <td></td>
                                    <td style="text-align: right;">{{ number_format($modalBankPermata, 0, ',', '.') }}</td>
                                    @php
                                        $totalKreditNeraca += $modalBankPermata;
                                    @endphp
                                </tr>
                                <tr>
                                    <td>Hutang Bahan Baku</td>
                                    <td></td>
                                    <td style="text-align: right;">{{ number_format($hutangbb, 0, ',', '.') }}</td>
                                    @php
                                        $totalKreditNeraca += $hutangbb;
                                    @endphp
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Pendapatan</strong></td>
                                </tr>
                                <tr>
                                    <td>Pendapatan</td>
                                    <td></td>
                                    <td style="text-align: right;">{{ number_format($pendapatan = $totalDebitNeraca-$totalKreditNeraca, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="text-align: right;"><strong>{{ number_format($totalDebitNeraca, 0, ',', '.') }}</strong></td>
                                    <td style="text-align: right;"><strong>{{ number_format($totalKreditNeraca + $pendapatan) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <div class="mt-3 mb-4">
                    <div style="text-align: center;">
                        <h5>CV.Mirasa Jaya</h5>
                        <h5>Laporan Rugi Laba</h5>
                        <h5>Periode : 1 Januari s.d {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</h5>
                    </div>
                    <div>
                        <table class="table table-bordered table-sm border border-dark align-middle">
                            <tbody>
                                @php
                                    $totalDebitRugiLaba = 0;
                                @endphp
                                <tr>
                                    <td colspan="3"><strong>Pendapatan</strong></td>
                                </tr>
                                <tr>
                                    <td>Pendapatan</td>
                                    <td></td>
                                    <td style="text-align: right;">{{ number_format($pendapatan, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Beban Usaha</strong></td>
                                </tr>
                                @foreach ($akun as $item)
                                    <tr>
                                        <td>{{ $item->nama }}</td>
                                        <td style="text-align: right;">{{ number_format($item->debit, 0, ',', '.') }}</td>
                                        <td style="text-align: right;">{{ $item->kredit }}</td>
                                    </tr>
                                    @php
                                        $totalDebitRugiLaba += $item->debit;
                                    @endphp
                                @endforeach
                                <tr>
                                    <td>Jumlah Beban Usaha</td>
                                    <td></td>
                                    <td style="text-align: right;">{{ number_format($totalDebitRugiLaba*(-1), 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><strong>Laba Bersih</strong></td>
                                    <td style="text-align: right;"><strong>{{ number_format(($totalDebitRugiLaba*(-1)) + $pendapatan, 0, ',', '.') }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <div class="mt-3">
                    <!-- Tambahkan pembungkus untuk kedua tabel -->
                    <div class="tabel-container">
                        <div class="table-left">
                            <table>
                                <thead>
                                    <tr>
                                        @if($pengeluaranDiluarProduksi->isNotEmpty() && $pengeluaranDiluarProduksi->first()->items->isNotEmpty())
                                            <th colspan="{{ count($pengeluaranDiluarProduksi->first()->items->first()->toArray()) + 1 }}">
                                                <p style="margin-bottom: 0%;">Pengeluaran Diluar Proses Produksi</p>
                                                <p style="margin-bottom: 0%;">Periode {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
                                            </th>
                                        @else
                                            <th colspan="2">
                                                Tidak Ada Pengeluaran Periode {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                                            </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total = 0;
                                    @endphp

                                    @foreach($pengeluaranDiluarProduksi  as $item)
                                        @if($item->display_type == 'column' && $item->items)
                                            @foreach($item->items as $detail)
                                            <tr>
                                                @foreach($detail->toArray() as $key => $value)
                                                    @if($key !== 'jumlah')
                                                        <td>{{ $value }}</td>
                                                    @endif
                                                @endforeach
                                                <td>Rp{{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                                            </tr>
                                            @endforeach
                                        @elseif($item->display_type == 'value')
                                            <tr>
                                                <td>{{ $item->nama }}</td>
                                                <td>Rp{{ number_format($item->total, 0, ',', '.') }}</td>
                                            </tr>
                                        @endif
                                        @php
                                            $total += $item->total;
                                        @endphp
                                    @endforeach

                                    <tr>
                                        <td colspan="1"><strong>JUMLAH</strong></td>
                                        <td><strong>Rp{{ number_format($total, 0, ',', '.') }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="table-right">
                            <table>
                                <thead>
                                    <tr>
                                        @if($pengeluaranDidalamProduksi->isNotEmpty() && $pengeluaranDidalamProduksi->first()->items->isNotEmpty())
                                            <th colspan="2">
                                                <p style="margin-bottom: 0%;">Pengeluaran Proses Produksi</p>
                                                <p style="margin-bottom: 0%;">Periode {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
                                            </th>
                                        @else
                                            <th colspan="2">
                                                Tidak Ada Pengeluaran Periode {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                                            </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total = 0;
                                    @endphp

                                    @foreach($pengeluaranDidalamProduksi  as $item)
                                        @if($item->display_type == 'column' && $item->items)
                                            @foreach($item->items as $detail)
                                            <tr>
                                                @foreach($detail->toArray() as $key => $value)
                                                    @if($key !== 'jumlah')
                                                        <td>{{ $value }}</td>
                                                    @endif
                                                @endforeach
                                                <td>Rp{{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                                            </tr>
                                            @endforeach
                                        @elseif($item->display_type == 'value')
                                            <tr>
                                                <td>{{ $item->nama }}</td>
                                                <td>Rp{{ number_format($item->total, 0, ',', '.') }}</td>
                                            </tr>
                                        @endif
                                        @php
                                            $total += $item->total;
                                        @endphp
                                    @endforeach

                                    <tr>
                                        <td colspan="1"><strong>JUMLAH</strong></td>
                                        <td><strong>Rp{{ number_format($total, 0, ',', '.') }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- CSS untuk mengatur tata letak tabel -->
                    <style>
                        .tabel-container {
                            display: flex;
                            justify-content: space-between;
                            gap: 10px;
                            margin-top: 20px;
                        }

                        .table-left, .table-right {
                            width: 48%; /* Mengatur lebar masing-masing tabel */
                        }

                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }

                        th, td {
                            border: 1px solid #000;
                            padding: 8px;
                            text-align: left;
                        }

                        th {
                            background-color: #f2f2f2;
                        }
                    </style>

                </div>
            </div>
          </div>
    </div>

</x-layout-manager>

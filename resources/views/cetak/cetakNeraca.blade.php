<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap JavaScript (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    
    <title>Cetak Neraca</title>
</head>

<style>
    /* Kontainer untuk menempatkan dua tabel bersampingan */
    .table-container {
      display: flex;
      justify-content: space-between;
      gap: 10px; /* Spasi antara dua tabel */
    }

    @media print {
    .page-break {
      page-break-before: always;
    }

    /* Mengatur agar tabel ditampilkan sebelah kanan dan kiri saat dicetak */
    .table-left, .table-right {
      float: left;
      width: 49%;
      margin-right: 1%;
    }

    .table-right {
      float: right;
    }
  }
  
    /* Styling khusus untuk tabel neraca */
    .neraca-table {
      width: 48%;
    }
  
    .neraca-table table {
      width: 100%;
      border-collapse: collapse;
    }
  
    .neraca-table th, .neraca-table td {
      border: 1px solid black;
      padding: 5px;
      text-align: right;
    }
  
    .neraca-table th {
      background-color: #f2f2f2;
    }
  
    /* Styling khusus untuk tabel laporan rugi laba */
    .rugi-laba-table {
      width: 48%;
    }
  
    .rugi-laba-table table {
      width: 100%;
      border-collapse: collapse;
    }
  
    .rugi-laba-table th, .rugi-laba-table td {
      border: 1px solid black;
      padding: 5px;
      text-align: right;
    }
  
    .rugi-laba-table th {
      background-color: #f2f2f2;
    }
  
    /* Mengatur teks header agar rata tengah */
    h5 {
      text-align: center;
    }
  </style>
  
  <div class="table-container">
    <!-- Tabel Neraca (Sebelah Kiri) -->
    <div class="neraca-table">
      <div style="text-align: center;">
          <h5>CV. Mirasa Jaya</h5>
          <h5>Neraca</h5>
          <h5>Periode: 1 Januari s.d {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</h5>
      </div>
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
                <td style="text-align: right;">{{ number_format($modal=300000000, 0, ',', '.') }}</td>
                @php
                    $totalKreditNeraca += $modal;
                @endphp
            </tr>
            <tr>
                <td>Pinjaman Bank Permata</td>
                <td></td>
                <td style="text-align: right;">{{ number_format($bank=500000000, 0, ',', '.') }}</td>
                @php
                    $totalKreditNeraca += $bank;
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
  
    <!-- Tabel Laporan Rugi Laba (Sebelah Kanan) -->
    <div class="rugi-laba-table">
      <div style="text-align: center;">
          <h5>CV. Mirasa Jaya</h5>
          <h5>Laporan Rugi Laba</h5>
          <h5>Periode: 1 Januari s.d {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</h5>
      </div>
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

  <div class="page-break"></div>

  <h3>Pengeluaran</h3>

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

<script type="text/javascript">
    window.print();
</script>
  
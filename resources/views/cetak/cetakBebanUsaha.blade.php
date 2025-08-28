<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap JavaScript (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    
    <title>Cetak Beban Usaha</title>

    <style>
        @media print {
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>

<body>
        <!-- Halaman 1 -->
        <section id="print-section-1" class="mb-5">
            <h4>Pembelian Bahan Baku</h4>
            <p >Periode : {{ \Carbon\Carbon::parse($startOfWeek)->translatedFormat('l, d F Y') }} - {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</p>

            <table class="table table-bordered table-sm border border-dark">
                <thead class="text-center">
                    <th>Tanggal</th>
                    <th>Pengeluaran</th>
                </thead>
                <tbody>
                    @php
                        $total_pembelianbb = $pembelianbb->sum('total_pengeluaran');
                    @endphp
                    @foreach ($pembelianbb as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item['tanggal_pengeluaran'])->format('d-m-Y') }}</td>
                            <td class="text-end">{{ number_format($item['total_pengeluaran']) }}</td>
                         </tr>
                     @endforeach
                    <tr>
                         <td class="text-end"><strong>Total Pembelian Bahan Baku Periode : {{ \Carbon\Carbon::parse($startOfWeek)->translatedFormat('l, d F Y') }} - {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</strong></td>
                        <td class="text-end"><strong>{{ number_format($total_pembelianbb) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </section>

        <div class="page-break"></div>

        <!-- Halaman 2 -->
        <section id="print-section-2">
            <h4>Akomodasi Pemasaran</h4>
            <p >Periode : {{ \Carbon\Carbon::parse($startOfWeek)->translatedFormat('l, d F Y') }} - {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</p>

            <table class="table table-bordered table-sm border border-dark align-middle">
                        <thead class="text-center">
                            <th>Tanggal</th>
                            <th>Pengeluaran</th>
                        </thead>
                        <tbody>
                            @php
                                $total_akmodoasiPemasaran = $akmodoasiPemasaran->sum('total_pengeluaran');
                            @endphp
                            @foreach ($akmodoasiPemasaran as $item)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item['tanggal_pengeluaran'])->format('d-m-Y') }}</td>
                                    <td class="text-end">{{ number_format($item['total_pengeluaran']) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="text-end"><strong>Total Akomodasi Pemasaran Periode : {{ \Carbon\Carbon::parse($startOfWeek)->translatedFormat('l, d F Y') }} - {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</strong></td>
                                <td class="text-end"><strong>{{ number_format($total_akmodoasiPemasaran) }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
        </section>

        <div class="page-break"></div>

        <!-- Halaman 2 -->
        <section id="print-section-3">
            <h4>Akomodasi Produksi</h4>
            <p >Periode : {{ \Carbon\Carbon::parse($startOfWeek)->translatedFormat('l, d F Y') }} - {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</p>

            <table class="table table-bordered table-sm border border-dark align-middle">
                        <thead class="text-center">
                            <th>Tanggal</th>
                            <th>Pengeluaran</th>
                        </thead>
                        <tbody>
                            @php
                                $total_akomodasiProduksi = $akomodasiProduksi->sum('total_pengeluaran');
                            @endphp
                            @foreach ($akomodasiProduksi as $item)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item['tanggal_pengeluaran'])->format('d-m-Y') }}</td>
                                    <td class="text-end">{{ number_format($item['total_pengeluaran']) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="text-end"><strong>Total Akomodasi Produksi Periode : {{ \Carbon\Carbon::parse($startOfWeek)->translatedFormat('l, d F Y') }} - {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</strong></td>
                                <td class="text-end"><strong>{{ number_format($total_akomodasiProduksi) }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
        </section>

        <div class="page-break"></div>

        <!-- Halaman 2 -->
        <section id="print-section-4">
            <h4>Pembelian Perlengkapan</h4>
            <p >Periode : {{ \Carbon\Carbon::parse($startOfWeek)->translatedFormat('l, d F Y') }} - {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</p>

            <table class="table table-bordered table-sm border border-dark align-middle">
                        <thead class="text-center">
                            <th>Tanggal</th>
                            <th>Pengeluaran</th>
                        </thead>
                        <tbody>
                            @php
                                $total_perlengkapan = $perlengkapan->sum('total_pengeluaran');
                            @endphp
                            @foreach ($perlengkapan as $item)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item['tanggal_pengeluaran'])->format('d-m-Y') }}</td>
                                    <td class="text-end">{{ number_format($item['total_pengeluaran']) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="text-end"><strong>Total Pembelian perlengkapan Periode :  {{ \Carbon\Carbon::parse($startOfWeek)->translatedFormat('l, d F Y') }} - {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</strong></td>
                                <td class="text-end"><strong>{{ number_format($total_perlengkapan) }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
        </section>

        <div class="page-break"></div>

        <!-- Halaman 2 -->
        <section id="print-section-5">
            <h4>Biaya Makan</h4>
            <p >Periode : {{ \Carbon\Carbon::parse($startOfWeek)->translatedFormat('l, d F Y') }} - {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</p>

            <table class="table table-bordered table-sm border border-dark align-middle">
                        <thead class="text-center">
                            <th>Tanggal</th>
                            <th>Pengeluaran</th>
                        </thead>
                        <tbody>
                            @php
                                $total_makan = $makan->sum('total_pengeluaran');
                            @endphp
                            @foreach ($makan as $item)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item['tanggal_pengeluaran'])->format('d-m-Y') }}</td>
                                    <td class="text-end">{{ number_format($item['total_pengeluaran']) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="text-end"><strong>Total Pembelian Makan Periode :  {{ \Carbon\Carbon::parse($startOfWeek)->translatedFormat('l, d F Y') }} - {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</strong></td>
                                <td class="text-end"><strong>{{ number_format($total_makan) }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
        </section>

        <div class="page-break"></div>

        <!-- Halaman 2 -->
        <section id="print-section-6">
            <h4>Gaji Karyawan</h4>
            <p >Periode : {{ \Carbon\Carbon::parse($startOfWeek)->translatedFormat('l, d F Y') }} - {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</p>

            <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                        <thead class="text-center">
                            <th>Tanggal</th>
                            <th>Pengeluaran</th>
                        </thead>
                        <tbody>
                            @php
                                $total_gajiKaryawan = $gajiKaryawan->sum('total_pengeluaran');
                            @endphp
                            @foreach ($gajiKaryawan as $item)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($item['tanggal_pengeluaran'])->format('d-m-Y') }}</td>
                                    <td class="text-end">{{ number_format($item['total_pengeluaran']) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="text-end"><strong>Total gajiKaryawan Periode :  {{ \Carbon\Carbon::parse($startOfWeek)->translatedFormat('l, d F Y') }} - {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</strong></td>
                                <td class="text-end"><strong>{{ number_format($total_gajiKaryawan) }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
        </section>

        <div class="page-break"></div>

        <!-- Halaman 2 -->
        <section id="print-section-7">
            <h4>Perbaikan Alat</h4>
            <p >Pengeluaran Perbaikan Alat s/d {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</p>

            <table class="table table-bordered table-sm border border-dark align-middle">
                        <thead class="text-center">
                            <th style="width: 7%;">Tanggal</th>
                            <th>hal</th>
                            <th>Pengeluaran</th>
                        </thead>
                        <tbody>
                            @if ($pemba == null)
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada pengeluaran untuk Perbaikan alat</td>
                                </tr>
                            @else
                                @php
                                    $total_perba = $perba->sum('total_pengeluaran');
                                @endphp
                                @foreach ($perba as $item)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pengeluaran)->format('d-m-Y') }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td class="text-end">{{ number_format($item->total_pengeluaran) }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="text-end" colspan="2"><strong>Total Perbaikan Alat s/d {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</strong></td>
                                    <td class="text-end"><strong>{{ number_format($total_perba) }}</strong></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
        </section>

        <div class="page-break"></div>

        <!-- Halaman 2 -->
        <section id="print-section-8">
            <h4>Pembelian Alat</h4>
            <p >Pengeluaran Pembelian Alat s/d {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</p>

            <table class="table table-bordered table-sm border border-dark align-middle">
                        <thead class="text-center">
                            <th style="width: 7%;">Tanggal</th>
                            <th>hal</th>
                            <th>Pengeluaran</th>
                        </thead>
                        <tbody>
                            @if ($pemba == null)
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada pengeluaran untuk pembelian alat</td>
                                </tr>
                            @else
                            @php
                                $total_pemba = $pemba->sum('total_pengeluaran');
                            @endphp
                                @foreach ($pemba as $item)
                                    <tr>
                                        <td>{{ $item->tanggal_pengeluaran }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>{{ $item->total_pengeluaran }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="text-end"colspan="2"><strong>Total Pembelian Alat s/d {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</strong></td>
                                    <td class="text-end"><strong>{{ number_format($total_pemba) }}</strong></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
        </section>

        <div class="page-break"></div>

        <!-- Halaman 2 -->
        <section id="print-section-9">
            <h4>Gaji Direksi</h4>
            <p >Pengeluaran Gaji Direksi s/d {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</p>

            <table class="table table-bordered table-sm border border-dark align-middle">
                        <thead class="text-center">
                            <th style="width: 7%;">Tanggal</th>
                            <th>hal</th>
                            <th>Pengeluaran</th>
                        </thead>
                        <tbody>
                            @if ($gajiDireksi == null)
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada pengeluaran untuk gaji direksi</td>
                                </tr>
                            @else
                            @php
                                $total_gajiDireksi = $gajiDireksi->sum('total_pengeluaran');
                            @endphp
                                @foreach ($gajiDireksi as $item)
                                    <tr>
                                        <td>{{ $item->tanggal_pengeluaran }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>{{ $item->total_pengeluaran }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="text-end"colspan="2"><strong>Total Gaji Direksi s/d {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</strong></td>
                                    <td class="text-end"><strong>{{ number_format($total_gajiDireksi) }}</strong></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
        </section>

        <div class="page-break"></div>

        <!-- Halaman 2 -->
        <section id="print-section-10">
            <h4>Listrik</h4>
            <p >Pengeluaran Listrik s/d {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</p>

            <table class="table table-bordered table-sm border border-dark align-middle">
                        <thead class="text-center">
                            <th style="width: 7%;">Tanggal</th>
                            <th>hal</th>
                            <th>Pengeluaran</th>
                        </thead>
                        <tbody>
                            @if ($listrik == null)
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada pengeluaran untuk listrik</td>
                                </tr>
                            @else
                            @php
                                $total_listrik = $listrik->sum('total_pengeluaran');
                            @endphp
                                @foreach ($listrik as $item)
                                    <tr>
                                        <td>{{ $item->tanggal_pengeluaran }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>{{ $item->total_pengeluaran }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="text-end"colspan="2"><strong>Total Listrik s/d {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</strong></td>
                                    <td class="text-end"><strong>{{ number_format($total_listrik) }}</strong></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
        </section>

        <div class="page-break"></div>

        <!-- Halaman 2 -->
        <section id="print-section-11">
            <h4>Pajak</h4>
            <p >Pengeluaran Pajak s/d {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</p>

            <table class="table table-bordered table-sm border border-dark align-middle">
                        <thead class="text-center">
                            <th style="width: 7%;">Tanggal</th>
                            <th>hal</th>
                            <th>Pengeluaran</th>
                        </thead>
                        <tbody>
                            @if ($pajak == null)
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada pengeluaran untuk pajak</td>
                                </tr>
                            @else
                            @php
                                $total_pajak = $pajak->sum('total_pengeluaran');
                            @endphp
                                @foreach ($pajak as $item)
                                    <tr>
                                        <td>{{ $item->tanggal_pengeluaran }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>{{ $item->total_pengeluaran }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="text-end" colspan="2"><strong>Total Pajak s/d {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</strong></td>
                                    <td class="text-end"><strong>{{ number_format($total_pajak) }}</strong></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
        </section>

        <div class="page-break"></div>

        <!-- Halaman 2 -->
        <section id="print-section-12">
            <h4>Sosial</h4>
            <p >Pengeluaran Sosial s/d {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</p>

            <table class="table table-bordered table-sm border border-dark align-middle">
                        <thead class="text-center">
                            <th style="width: 7%;">Tanggal</th>
                            <th>hal</th>
                            <th>Pengeluaran</th>
                        </thead>
                        <tbody>
                            @if ($sosial == null)
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada pengeluaran untuk sosial</td>
                                </tr>
                            @else
                            @php
                                $total_sosial = $sosial->sum('total_pengeluaran');
                            @endphp
                                @foreach ($sosial as $item)
                                    <tr>
                                        <td>{{ $item->tanggal_pengeluaran }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>{{ $item->total_pengeluaran }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="text-end" colspan="2"><strong>Total Sosial s/d {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</strong></td>
                                    <td class="text-end"><strong>{{ number_format($total_sosial) }}</strong></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
        </section>

        <div class="page-break"></div>

        <!-- Halaman 2 -->
        <section id="print-section-13">
            <h4>Sewa Tempat</h4>
            <p >Pengeluaran Sewa Tempat s/d {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</p>

            <table class="table table-bordered table-sm border border-dark align-middle">
                        <thead class="text-center">
                            <th style="width: 7%;">Tanggal</th>
                            <th>hal</th>
                            <th>Pengeluaran</th>
                        </thead>
                        <tbody>
                            @if ($sewaTempat == null)
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada pengeluaran untuk sewa tempat</td>
                                </tr>
                            @else
                            @php
                                $total_sewaTempat = $sewaTempat->sum('total_pengeluaran');
                            @endphp
                                @foreach ($sewaTempat as $item)
                                    <tr>
                                        <td>{{ $item->tanggal_pengeluaran }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>{{ $item->total_pengeluaran }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="text-end" colspan="2"><strong>Total Sewa Tempat s/d {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</strong></td>
                                    <td class="text-end"><strong>{{ number_format($total_sewaTempat) }}</strong></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
        </section>

        <div class="page-break"></div>

        <!-- Halaman 2 -->
        <section id="print-section-14">
            <h4>Project</h4>
            <p >Pengeluaran Project s/d {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</p>

            <table class="table table-bordered table-sm border border-dark align-middle">
                        <thead class="text-center">
                            <th style="width: 7%;">Tanggal</th>
                            <th>hal</th>
                            <th>Pengeluaran</th>
                        </thead>
                        <tbody>
                            @if ($project == null)
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada pengeluaran untuk project</td>
                                </tr>
                            @else
                            @php
                                $total_project = $project->sum('total_pengeluaran');
                            @endphp
                                @foreach ($project as $item)
                                    <tr>
                                        <td>{{ $item->tanggal_pengeluaran }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>{{ $item->total_pengeluaran }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="text-end" colspan="2"><strong>Total Project s/d {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</strong></td>
                                    <td class="text-end"><strong>{{ number_format($total_project) }}</strong></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
        </section>

        <div class="page-break"></div>

        <!-- Halaman 2 -->
        <section id="print-section-15">
            <h4>THR</h4>
            <p >Pengeluaran THR s/d {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</p>

            <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                        <thead class="text-center">
                            <th style="width: 7%;">Tanggal</th>
                            <th>hal</th>
                            <th>Pengeluaran</th>
                        </thead>
                        <tbody>
                            @if ($thr == null)
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada pengeluaran untuk THR</td>
                                </tr>
                            @else
                            @php
                                $total_thr = $thr->sum('total_pengeluaran');
                            @endphp
                                @foreach ($thr as $item)
                                    <tr>
                                        <td>{{ $item->tanggal_pengeluaran }}</td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>{{ $item->total_pengeluaran }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="text-end"colspan="2"><strong>Total THR s/d {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</strong></td>
                                    <td class="text-end"><strong>{{ number_format($total_thr) }}</strong></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
        </section>
</body>

<script type="text/javascript">
    window.print();
</script>
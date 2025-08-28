<x-layout-manager>
<x-slot:title>Beban Usaha</x-slot>
  <x-slot:tabs>Manager-Beban Usaha</x-slot>

<h3>Periode : {{ \Carbon\Carbon::parse($startOfWeek)->translatedFormat('l, d F Y') }} - {{ \Carbon\Carbon::parse($endOfWeek)->translatedFormat('l, d F Y') }}</h3>

<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pembelianbb-tab" data-bs-toggle="tab" data-bs-target="#pembelianbb"
            type="button" role="tab" aria-controls="pembelianbb" aria-selected="false">Pembelian BB</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="akomodasiPemasaran-tab" data-bs-toggle="tab" data-bs-target="#akomodasiPemasaran"
            type="button" role="tab" aria-controls="akomodasiPemasaran" aria-selected="false">Akomodasi Pemasaran</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="akomodasiProduksi-tab" data-bs-toggle="tab" data-bs-target="#akomodasiProduksi"
            type="button" role="tab" aria-controls="akomodasiProduksi" aria-selected="false">Akomodasi Produksi</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="perlengkapan-tab" data-bs-toggle="tab" data-bs-target="#perlengkapan"
            type="button" role="tab" aria-controls="perlengkapan" aria-selected="false">Perlengkapan</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="makan-tab" data-bs-toggle="tab" data-bs-target="#makan"
            type="button" role="tab" aria-controls="makan" aria-selected="false">Makan</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="gajiKaryawan-tab" data-bs-toggle="tab" data-bs-target="#gajiKaryawan"
            type="button" role="tab" aria-controls="gajiKaryawan" aria-selected="false">Gaji Karyawan</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="perba-tab" data-bs-toggle="tab" data-bs-target="#perba"
            type="button" role="tab" aria-controls="perba" aria-selected="false">Perbaikan Alat</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pemba-tab" data-bs-toggle="tab" data-bs-target="#pemba"
            type="button" role="tab" aria-controls="pemba" aria-selected="false">Pembelian Alat</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="gajiDireksi-tab" data-bs-toggle="tab" data-bs-target="#gajiDireksi"
            type="button" role="tab" aria-controls="gajiDireksi" aria-selected="false">Gaji Direksi</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="listrik-tab" data-bs-toggle="tab" data-bs-target="#listrik"
            type="button" role="tab" aria-controls="listrik" aria-selected="false">Listrik</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pajak-tab" data-bs-toggle="tab" data-bs-target="#pajak"
            type="button" role="tab" aria-controls="pajak" aria-selected="false">Pajak</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="sosial-tab" data-bs-toggle="tab" data-bs-target="#sosial"
            type="button" role="tab" aria-controls="sosial" aria-selected="false">Sosial</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="sewaTempat-tab" data-bs-toggle="tab" data-bs-target="#sewaTempat"
            type="button" role="tab" aria-controls="sewaTempat" aria-selected="false">Sewa Tempat</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="project-tab" data-bs-toggle="tab" data-bs-target="#project"
            type="button" role="tab" aria-controls="project" aria-selected="false">Project</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="thr-tab" data-bs-toggle="tab" data-bs-target="#thr"
            type="button" role="tab" aria-controls="thr" aria-selected="false">THR</button>
    </li>
</ul>
    <div class="tab-content">
                <div class="tab-pane fade show active" id="pembelianbb">
                    <table class="table table-bordered table-striped table-sm border border-dark align-middle">
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
                </div>
                <div class="tab-pane fade" id="akomodasiPemasaran">
                    <table class="table table-bordered table-striped table-sm border border-dark align-middle">
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
                </div>
                <div class="tab-pane fade" id="akomodasiProduksi">
                    <table class="table table-bordered table-striped table-sm border border-dark align-middle">
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
                </div>
                <div class="tab-pane fade" id="perlengkapan">
                    <table class="table table-bordered table-striped table-sm border border-dark align-middle">
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
                </div>
                <div class="tab-pane fade" id="makan">
                    <table class="table table-bordered table-striped table-sm border border-dark align-middle">
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
                </div>
                <div class="tab-pane fade" id="gajiKaryawan">
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
                </div>
                <div class="tab-pane fade" id="perba">
                    <table class="table table-bordered table-striped table-sm border border-dark align-middle">
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
                </div>
                <div class="tab-pane fade" id="pemba">
                    <table class="table table-bordered table-striped table-sm border border-dark align-middle">
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
                </div>
                <div class="tab-pane fade" id="gajiDireksi">
                    <table class="table table-bordered table-striped table-sm border border-dark align-middle">
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
                </div>
                <div class="tab-pane fade" id="listrik">
                    <table class="table table-bordered table-striped table-sm border border-dark align-middle">
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
                </div>
                <div class="tab-pane fade" id="pajak">
                    <table class="table table-bordered table-striped table-sm border border-dark align-middle">
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
                </div>
                <div class="tab-pane fade" id="sosial">
                    <table class="table table-bordered table-striped table-sm border border-dark align-middle">
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
                </div>
                <div class="tab-pane fade" id="sewaTempat">
                    <table class="table table-bordered table-striped table-sm border border-dark align-middle">
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
                </div>
                <div class="tab-pane fade" id="project">
                    <table class="table table-bordered table-striped table-sm border border-dark align-middle">
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
                </div>
                <div class="tab-pane fade" id="thr">
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
                </div>
            </div>
</x-layout-manager>
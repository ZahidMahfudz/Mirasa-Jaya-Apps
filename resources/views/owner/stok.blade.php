<x-layout-owner>
    <x-slot:title>Stok Bahan Baku, Bahan Penolong dan WIP</x-slot>
    <x-slot:tabs>Owner-Rekapitulasi Stok</x-slot>

    <div>
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                    <div class="mt-3">
                        <form action="filterstokbb" method="post">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <p>Tanggal</p>
                                </div>
                                <div class="col">
                                    {{-- <label for="startDate" class="form-label">Mulai:</label> --}}
                                    <input type="date" class="form-control" id="startDate" name="startDate"
                                        value="{{ $tanggal ?? '' }}">
                                </div>
                                <div class="col">
                                    {{-- <label for="submit" class="form-label"></label> --}}
                                    <button type="submit" class="btn btn-primary" name="submit" id="submit">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                    <div class="mt-1">
                        <a href="" onclick=" this.href='cetak-stok-filter/'+ document.getElementById('startDate').value " class="btn btn-secondary" target="_blank" >Cetak</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="bahanbaku-tab" data-bs-toggle="tab" data-bs-target="#bahanbaku"
                            type="button" role="tab" aria-controls="bahanbaku" aria-selected="false">Bahan Baku</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="bahanpenolong-tab" data-bs-toggle="tab" data-bs-target="#bahanpenolong"
                            type="button" role="tab" aria-controls="bahanpenolong" aria-selected="false">Bahan Penolong</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="wip-tab" data-bs-toggle="tab" data-bs-target="#wip"
                            type="button" role="tab" aria-controls="wip" aria-selected="false">Work In Progress</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="bahanbaku" role="tabpanel" aria-labelledby="bahanbaku-tab">
                        <div class="mt-2">
                            <div>
                                <table class="table table-bordered table-striped table-sm border border-dark align-middle">
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
                                                <td style="text-align: right">{{ $gudang }}</td>
                                                <td style="text-align: right">{{ $sisaResep }}</td>
                                                <td style="text-align: right">{{ $totalBahanBaku }}</td>
                                                <td style="text-align: right">{{ $wip }}</td>
                                                <td style="text-align: right">{{ $totalStokBahanBaku }}</td>
                                                <td style="text-align: right">{{ number_format($hargaSatuan) }}</td>
                                                <td style="text-align: right">{{ number_format($totalHarga) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="8" style="text-align: right;"><strong>Total</strong></td>
                                            <td colspan="2" style="text-align: right"><b>{{ number_format($sumtotalbahanbaku) }}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="bahanpenolong" role="tabpanel" aria-labelledby="bahanpenolong-tab">
                        <div class="mt-2">
                            <div>
                                <table class="table table-bordered table-striped table-sm border border-dark align-middle">
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
                                                @if ($bahanpenolong && $jumlah)
                                                    <td style="text-align: right">{{ $jumlah->jumlah }}</td>
                                                    <td style="text-align: right">{{ number_format($bahanpenolong->harga_persatuan) }}</td>
                                                    @php
                                                        $totalbp = $jumlah->jumlah * $bahanpenolong->harga_persatuan;
                                                        $sumtotalbahanpenolong += $totalbp
                                                    @endphp
                                                    <td style="text-align: right">{{ number_format($totalbp) }}</td>
                                                @else
                                                    <td colspan="5">Data bahan Penolong Tidak Ditemukan</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="4" style="text-align: right;"><strong>Total</strong></td>
                                            <td colspan="2" style="text-align: right;"><b>{{ number_format($sumtotalbahanpenolong) }}</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="wip" role="tabpanel" aria-labelledby="wip-tab">
                        <div class="mt-2">
                            <div>
                                <table class="table table-bordered table-striped table-sm border border-dark align-middle">
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
                                                        <td rowspan="{{ $rekapResep->resep->bahan_resep->count() }}" style="text-align: center;">{{ $rekapResep->jumlah_resep }}</td>
                                                    @endif
                                                    <td>{{ $bahanResep->nama_bahan }}</td>
                                                    <td style="text-align: right;">{{ $bahanResep->jumlah_bahan_gr * $rekapResep->jumlah_resep }}</td>
                                                    <td style="text-align: right;">{{ $bahanResep->jumlah_bahan_kg * $rekapResep->jumlah_resep }}</td>
                                                    <td style="text-align: right;">{{ $bahanResep->jumlah_bahan_zak * $rekapResep->jumlah_resep }}</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <strong>Total Stok Bahan Baku dan Kardus : Rp.{{ number_format($sumtotalbahanbaku + $sumtotalbahanpenolong) }}</strong>
            </div>
        </div>
    </div>
</x-layout-owner>

{{-- @extends('owner.layout')
@section('main_content')
    <h1>Stok Bahan Baku, Bahan Penolong, dan WIP</h1>

    
@endsection --}}

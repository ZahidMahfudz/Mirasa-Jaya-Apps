<x-layout-manager>
    <x-slot:title>Stok Bahan Baku, penolong, dan WIP</x-slot>
    <x-slot:tabs>Manager-stok</x-slot>

    <div class="mt-2">
        <a href="generatestokbahanbaku" class="btn btn-outline-primary">Generate Stok Bahan Baku dan Penolong </a>
    </div>

    <div class="mt-3">
        <div class="card">
            <div class="card-header">
                <div class="alert alert-warning mt-2" role="alert">
                    <p style="margin-bottom: 0;"><b>PENTING!</b></p>
                    <ul style="margin-top: 0; margin-bottom: 0;">
                        <li><b>Pastikan data sudah benar untuk semua bahan dan wip</b></li>
                        <li><b>Data sebelumnya tidak dapat diedit setelah generate </b></li>
                    </ul>
                </div>
                {{-- <div>
                    <form action="filterstokbb" method="GET">
                        <div class="row">
                            <div class="col">
                                <input type="date" class="form-control" id="startDate" name="startDate"
                                    value="{{ $tanggal ?? '' }}">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary" name="submit" id="submit">Filter</button>
                            </div>
                        </div>
                    </form>
                </div> --}}
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Tanggal : {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y')}}</strong>
                </div>
                
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
                                            <th rowspan="2" style="text-align: center; vertical-align: middle; width:5%">Aksi</th>
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
                                                <td style="text-align: right;">{{ $gudang }}</td>
                                                <td style="text-align: right;">{{ $sisaResep }}</td>
                                                <td style="text-align: right;">{{ $totalBahanBaku }}</td>
                                                <td style="text-align: right;">{{ $wip }}</td>
                                                <td style="text-align: right;">{{ $totalStokBahanBaku }}</td>
                                                <td style="text-align: right;">{{ number_format($hargaSatuan) }}</td>
                                                <td style="text-align: right;">{{ number_format($totalHarga) }}</td>
                                                <td style="text-align: center;">
                                                    <!-- Tombol atau tautan untuk memicu modal -->
                                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal{{ $bahanbaku->id}}">Edit</button>
                                                </td>

                                                <div class="modal fade" id="editModal{{ $bahanbaku->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Stok bahan baku</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Form untuk mengedit in dan out -->
                                                                <form action="{{ route('editstokbb', ['id' => $bahanbaku->id]) }}" method="POST">
                                                                    @csrf
                                                                    <div>
                                                                        <label for="tanggal" class="form-label">Tanggal :</label>
                                                                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $bahanbaku->tanggal }}" disabled>
                                                                    </div>
                                                                    <div class="mt-2">
                                                                        <label for="nama_bahan" class="form-label">Nama bahan :</label>
                                                                        <input type="text" name="nama_bahan" id="nama_bahan" class="form-control" value="{{ $bahanbaku->nama_bahan }}" disabled>
                                                                    </div>
                                                                    <div class="mt-2">
                                                                        <label for="gudang" class="form-label">Gudang:</label>
                                                                        <input type="number" name="gudang" step="0.01" id="gudang" class="form-control @error('gudang') is-invalid @enderror" value="{{ old('gudang', $bahanbaku->gudang ) }}">
                                                                        @error('in')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="mt-2">
                                                                        <label for="sisa_resep" class="form-label">Sisa resep :</label>
                                                                        <input type="number" name="sisa_resep" step="0.01" id="sisa_resep" class="form-control @error('sisa_resep') is-invalid @enderror" value="{{ old('sisa_resep', $bahanbaku->sisa_resep ) }}">
                                                                        @error('out')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="8" style="text-align: right;"><strong>Total</strong></td>
                                            <td style="text-align: right;"><b>Rp.{{ number_format($sumtotalbahanbaku) }}</b></td>
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
                                            <th style="text-align: center; width:5%;">Aksi</th>
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
                                                    <td style="text-align: right;">{{ $jumlah->jumlah }}</td>
                                                    <td style="text-align: right;">{{ number_format($bahanpenolong->harga_persatuan) }}</td>
                                                    @php
                                                        $totalbp = $jumlah->jumlah * $bahanpenolong->harga_persatuan;
                                                        $sumtotalbahanpenolong += $totalbp
                                                    @endphp
                                                    <td style="text-align: right;">{{ number_format($totalbp) }}</td>
                                                    <td style="text-align: center;">
                                                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editbp{{ $bahanpenolong->id }}">Edit</button>
                                                    </td>
                                                    
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="editbp{{ $bahanpenolong->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Edit Stok Bahan Penolong</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Form untuk mengedit in dan out -->
                                                                    <form action="{{ route('editstokbp', ['id' => $jumlah->id]) }}" method="POST">
                                                                        @csrf
                                                                        <div>
                                                                            <label for="tanggal" class="form-label">Tanggal :</label>
                                                                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $jumlah->tanggal }}" disabled>
                                                                        </div>
                                                                        <div class="mt-2">
                                                                            <label for="nama_bahan" class="form-label">Nama bahan :</label>
                                                                            <input type="text" name="nama_bahan" id="nama_bahan" class="form-control" value="{{ $jumlah->nama_bahan }}" disabled>
                                                                        </div>
                                                                        <div class="mt-2">
                                                                            <label for="jumlah" class="form-label">Jumlah:</label>
                                                                            <input type="number" name="jumlah" step="0.01" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah', $jumlah->jumlah) }}">
                                                                            @error('jumlah')
                                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>                                                    
                                                @else
                                                    <td colspan="5">Data bahan Penolong Tidak Ditemukan</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="4" style="text-align: right;"><strong>Total</strong></td>
                                            <td style="text-align: right;"><b>Rp.{{ number_format($sumtotalbahanpenolong) }}</b></td>
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
                                            <th style="text-align: center; width:5%;">Jumlah Resep</th>
                                            <th style="text-align: center; width:5%;">Aksi</th>
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
                                                        <td rowspan="{{ $rekapResep->resep->bahan_resep->count() }}" style="text-align: center;">
                                                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editwip{{ $rekapResep->id}}">Edit</button>
                                                        </td>
                                                    @endif
                                                    <td>{{ $bahanResep->nama_bahan }}</td>
                                                    <td style="text-align: right;">{{ $bahanResep->jumlah_bahan_gr * $rekapResep->jumlah_resep }}</td>
                                                    <td style="text-align: right;">{{ $bahanResep->jumlah_bahan_kg * $rekapResep->jumlah_resep }}</td>
                                                    <td style="text-align: right;">{{ $bahanResep->jumlah_bahan_zak * $rekapResep->jumlah_resep }}</td>
                                                </tr>

                                                <div class="modal fade" id="editwip{{ $rekapResep->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editwipLabel{{ $rekapResep->id }}" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editwipLabel{{ $rekapResep->id }}">Edit Jumlah Resep</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Form untuk mengedit in dan out -->
                                                                <form action="{{ route('editwip', ['id' => $rekapResep->id]) }}" method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div>
                                                                        <label for="tanggal" class="form-label">Tanggal :</label>
                                                                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $rekapResep->tanggal }}" disabled>
                                                                    </div>
                                                                    <div class="mt-2">
                                                                        <label for="nama_produk" class="form-label">Nama Resep :</label>
                                                                        <input type="text" name="nama_produk" id="nama_produk" class="form-control" value="{{ $rekapResep->resep->nama_resep }}" disabled>
                                                                    </div>
                                                                    <div class="mt-2">
                                                                        <label for="jumlah_resep" class="form-label">Jumlah Resep:</label>
                                                                        <input type="number" name="jumlah_resep" id="jumlah_resep" class="form-control @error('jumlah_resep') is-invalid @enderror" value="{{ old('jumlah_resep', $rekapResep->jumlah_resep ) }}">
                                                                        @error('jumlah_resep')
                                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                        <tr>
                            <th style="width: 80%;">Total</th>
                            <th style="text-align: right;">Rp.{{ number_format($sumtotalbahanbaku + $sumtotalbahanpenolong) }}</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout-manager>


{{-- <head>
    <title>Mirasa Jaya - Stok</title>
</head>
@extends('manager.layout')
@section('main_content')
    <h1>Stok Bahan Baku dan Penolong</h1>

    
@endsection --}}

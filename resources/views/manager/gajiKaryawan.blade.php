<x-layout-manager>
    <x-slot:title>Gaji Karyawan</x-slot>
    <x-slot:tabs>Manager-Gaji Karyawan</x-slot>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Gaji Karyawan Tanggal : {{ \Carbon\Carbon::parse($tanggalTerakhir)->translatedFormat('l, d F Y') }}</h5>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="karyawan-biasa-tab" data-bs-toggle="tab" data-bs-target="#karyawan-biasa" type="button" role="tab" aria-controls="karyawan-biasa" aria-selected="true">Karyawan Biasa</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="karyawan-borongan-tab" data-bs-toggle="tab" data-bs-target="#karyawan-borongan" type="button" role="tab" aria-controls="karyawan-borongan" aria-selected="false">Karyawan Borongan Spet</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="karyawan-biasa" role="tabpanel" aria-labelledby="karyawan-biasa-tab">
                    <div class="mt-4">
                        <table class="table table-bordered table-striped table-sm border border-dark align-middle ">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle; width:10%;" rowspan="2">Nama Karyawan</th>
                                    <th style="text-align: center; vertical-align: middle; width:10%;" rowspan="2">Bagian</th>
                                    <th style="text-align: center; vertical-align: middle; width:10%;" rowspan="2">Posisi</th>
                                    <th style="text-align: center; vertical-align: middle; width:5%;" colspan="4">Rincian Gaji</th>
                                    <th style="text-align: center; vertical-align: middle; width:5%;" rowspan="2">Total Gaji</th>
                                </tr>
                                <tr>
                                    <th style="width: 1%; text-align:center;">Keterangan</th>
                                    <th style="width: 1%; text-align:center;">Jumlah</th>
                                    <th style="width: 3%; text-align:center;">Besaran</th>
                                    <th style="width: 3%; text-align:center;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_pengeluaran = 0;
                                @endphp
                                @foreach ($gajian_karyawan as $item)
                                    @php
                                        $total_gaji_pokok = $item->jumlah_masuk * $item->dataKaryawan->gaji_pokok;
                                        $total_makan = $item->jumlah_masuk * $item->dataKaryawan->makan;
                                        $total_tunjangan = $item->jumlah_bonus * $item->dataKaryawan->tunjangan;
                                        $total_gaji = $total_gaji_pokok + $total_makan + $total_tunjangan;
                                        $total_pengeluaran += $total_gaji;
                                    @endphp
                                    <tr>
                                        <td rowspan="3">{{ $item->dataKaryawan->nama_karyawan }}</td>
                                        <td rowspan="3">{{ $item->dataKaryawan->bagian }}</td>
                                        <td rowspan="3">{{ $item->dataKaryawan->posisi }}</td>
                                        <td style="text-align: left;">Gaji Pokok</td>
                                        <td style="text-align: center;">{{ $item->jumlah_masuk }}</td>
                                        <td style="text-align: right;">{{ number_format($item->dataKaryawan->gaji_pokok, 0, ',', '.') }}</td>
                                        <td style="text-align: right;">{{ number_format($total_gaji_pokok, 0, ',', '.') }}</td>
                                        <td rowspan="3" style="text-align: right;"><strong>{{ number_format($total_gaji, 0, ',', '.') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;">Makan</td>
                                        <td style="text-align: center;">{{ $item->jumlah_masuk }}</td>
                                        <td style="text-align: right;">{{ number_format($item->dataKaryawan->makan, 0, ',', '.') }}</td>
                                        <td style="text-align: right;">{{ number_format($total_makan, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;">Bonus</td>
                                        <td style="text-align: center;">{{ $item->jumlah_bonus }}</td>
                                        <td style="text-align: right;">{{ number_format($item->dataKaryawan->tunjangan, 0, ',', '.') }}</td>
                                        <td style="text-align: right;">{{ number_format($total_tunjangan, 0, ',', '.') }}</td>
                                    </tr>
                                    @php
                                        $nominals = [100000, 50000, 20000, 10000, 5000, 2000, 1000];
                                        $nominal_counts = array_fill_keys($nominals, 0);
        
                                        foreach ($gajian_karyawan as $item) {
                                            $total_gaji = ($item->jumlah_masuk * $item->dataKaryawan->gaji_pokok) +
                                                          ($item->jumlah_masuk * $item->dataKaryawan->makan) +
                                                          ($item->jumlah_bonus * $item->dataKaryawan->tunjangan);
        
                                            foreach ($nominals as $nominal) {
                                                $nominal_counts[$nominal] += intdiv($total_gaji, $nominal);
                                                $total_gaji %= $nominal;
                                            }
                                        }
                                    @endphp
                                @endforeach
                                <tr>
                                    <td colspan="7" style="text-align: right;"><strong>Total Pengeluaran Gaji Karyawan {{ $tanggalTerakhir }}</strong></td>
                                    <td style="text-align: right;"><strong>{{ number_format($total_pengeluaran, 0, ',', '.') }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <p>Jumlah nominal tiap pecahan</p>
                        <table class="table table-bordered table-striped table-sm border border-dark align-middle" style="width: 5%;">
                            <thead>
                                <th style="width: 2%;">Nominal</th>
                                <th style="width: 2%;">jumlah</th>
                            </thead>
                            <tbody>
                                @foreach ($nominals as $nominal)
                                        <tr>
                                            <td>{{ number_format($nominal, 0, ',', '.') }}</td>
                                            <td>{{ $nominal_counts[$nominal] }}</td>
                                        </tr>
                                @endforeach
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="karyawan-borongan" role="tabpanel" aria-labelledby="karyawan-borongan-tab">
                    <div>
                        <table class="table table-bordered table-striped table-sm border border-dark align-middle mt-3">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle; width:10%;" rowspan="2">Nama Karyawan</th>
                                    <th style="text-align: center; vertical-align: middle; width:10%;" rowspan="2">Bagian</th>
                                    <th style="text-align: center; vertical-align: middle; width:5%;" colspan="4">Rincian Gaji</th>
                                    <th style="text-align: center; vertical-align: middle; width:5%;" rowspan="2">Total Gaji</th>
                                    <th style="text-align: center; vertical-align: middle; width:3%;" rowspan="2">Aksi</th>
                                </tr>
                                <tr>
                                    <th style="width: 1%; text-align:center;">Keterangan</th>
                                    <th style="width: 1%; text-align:center;">Jumlah</th>
                                    <th style="width: 3%; text-align:center;">Besaran</th>
                                    <th style="width: 3%; text-align:center;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_pengeluaran = 0;
                                @endphp
                                @foreach ($gajian_karyawan_borongan as $item)
                                    @php
                                        $total_jumlah_s = $item->jumlah_s * $item->dataKaryawanBorongan->harga_s;
                                        $total_jumlah_o = $item->jumlah_o * $item->dataKaryawanBorongan->harga_o;
                                        $total_makan = $item->jumlah_masuk * $item->dataKaryawanBorongan->makan;
                                        $total_tunjangan = $item->jumlah_bonus * $item->dataKaryawanBorongan->tunjangan;
                                        $total_gaji = $total_jumlah_s + $total_jumlah_o + $total_makan + $total_tunjangan;
                                        $total_pengeluaran += $total_gaji;
                                    @endphp
                                    <tr>
                                        <td rowspan="4">{{ $item->dataKaryawanBorongan->nama_karyawan }}</td>
                                        <td rowspan="4">{{ $item->dataKaryawanBorongan->bagian }}</td>
                                        <td style="text-align: left;">Jumlah S</td>
                                        <td style="text-align: center;">{{ $item->jumlah_s }}</td>
                                        <td style="text-align: right;">{{ number_format($item->dataKaryawanBorongan->harga_s, 0, ',', '.') }}</td>
                                        <td style="text-align: right;">{{ number_format($total_jumlah_s, 0, ',', '.') }}</td>
                                        <td rowspan="4" style="text-align: right;"><strong>{{ number_format($total_gaji, 0, ',', '.') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;">Jumlah O</td>
                                        <td style="text-align: center;">{{ $item->jumlah_o }}</td>
                                        <td style="text-align: right;">{{ number_format($item->dataKaryawanBorongan->harga_o, 0, ',', '.') }}</td>
                                        <td style="text-align: right;">{{ number_format($total_jumlah_o, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;">Makan</td>
                                        <td style="text-align: center;">{{ $item->jumlah_masuk }}</td>
                                        <td style="text-align: right;">{{ number_format($item->dataKaryawanBorongan->makan, 0, ',', '.') }}</td>
                                        <td style="text-align: right;">{{ number_format($total_makan, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: left;">Bonus</td>
                                        <td style="text-align: center;">{{ $item->jumlah_bonus }}</td>
                                        <td style="text-align: right;">{{ number_format($item->dataKaryawanBorongan->tunjangan, 0, ',', '.') }}</td>
                                        <td style="text-align: right;">{{ number_format($total_tunjangan, 0, ',', '.') }}</td>
                                    </tr>
                                    @php
                                        $nominals_borongan = [100000, 50000, 20000, 10000, 5000, 2000, 1000];
                                        $nominal_counts_borongan = array_fill_keys($nominals_borongan, 0);

                                        foreach ($gajian_karyawan_borongan as $item) {
                                            $total_gaji_borongan = ($item->jumlah_s * $item->dataKaryawanBorongan->harga_s) +
                                                                ($item->jumlah_o * $item->dataKaryawanBorongan->harga_o) +
                                                                ($item->jumlah_masuk * $item->dataKaryawanBorongan->makan) +
                                                                ($item->jumlah_bonus * $item->dataKaryawanBorongan->tunjangan);

                                            foreach ($nominals_borongan as $nominal_borongan) {
                                                $nominal_counts_borongan[$nominal_borongan] += intdiv($total_gaji_borongan, $nominal_borongan);
                                                $total_gaji_borongan %= $nominal_borongan;
                                            }
                                        }
                                    @endphp
                                @endforeach
                                <tr>
                                    <td colspan="6" style="text-align: right;"><strong>Total Pengeluaran Gaji Karyawan {{ $tanggalTerakhir }}</strong></td>
                                    <td style="text-align: right;"><strong>{{ number_format($total_pengeluaran, 0, ',', '.') }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <p>Jumlah nominal tiap pecahan</p>
                        <table class="table table-bordered table-striped table-sm border border-dark align-middle" style="width: 5%;">
                            <thead>
                                <th style="width: 2%;">Nominal</th>
                                <th style="width: 2%;">jumlah</th>
                            </thead>
                            <tbody>
                                @foreach ($nominals_borongan as $nominal_borongan)
                                                        <tr>
                                                            <td>{{ number_format($nominal_borongan, 0, ',', '.') }}</td>
                                                            <td>{{ $nominal_counts_borongan[$nominal_borongan] }}</td>
                                                        </tr>
                                                    @endforeach
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-layout-manager>
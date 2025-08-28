<x-layout-manager>
    <x-slot:title>Resume Produksi</x-slot>
    <x-slot:tabs>Manager-Resume Produksi</x-slot>

    <div class="mt-2">
        <a href="tambahresumehariini" class="btn btn-outline-primary">Generate Resume dan SSS Hari Ini</a>
    </div>

    <div class="card mt-2">
        <div class="card-header">
            <div class="alert alert-warning mt-2" role="alert">
                <p style="margin-bottom: 0;"><b>PENTING!</b></p>
                <p style="margin-bottom: 0;"></p>
                <ul style="margin-top: 0; margin-bottom: 0;">
                    <li><b>Pastikan Generate Setiap hari</b></li>
                    <li><b>Pastikan data sisa yang dimasukan sudah pasti benar</b></li>
                    <li><b>Pastikan Drop Out sudah diselesaikan sebelum memasukan sisa produk</b></li>
                    <li><b>Untuk mempermudah penambahan kardus sebaiknya dilakukan setelah sisa diinputkan</b></li>
                </ul>
            </div>
            <h4>Detail Resume Produksi</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                <thead>
                    <tr>
                        <th rowspan="2" style="text-align: center; vertical-align: middle;">Nama Produk</th>
                        @foreach ($uniqueDates as $tanggal)
                            <th colspan="3" style="text-align: center; width: 12%;">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d/m/Y') }}</th>
                        @endforeach
                        <th rowspan="2" style="text-align: center; vertical-align: middle; width: 5em">Aksi</th>
                    </tr>
                    <tr>
                        @foreach ($uniqueDates as $tanggal)
                            <th style="text-align: center; width: 5em;">in</th>
                            <th style="text-align: center; width: 5em;">out</th>
                            <th style="text-align: center; width: 5em;">sisa</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($groupedData as $nama_produk => $data_per_produk)
                        <tr>
                            <td>{{ $nama_produk }}</td>
                            @php
                                $previous_sisas = [];
                                $index = 0;
                                $total_in = 0;
                                $total_out = 0;
                                $total_sisa = 0;
                            @endphp
                            @foreach ($uniqueDates as $tanggal)
                                @php
                                    $data_tanggal = $data_per_produk->where('tanggal', $tanggal)->first();
                                    if (!$data_tanggal) {
                                        continue;
                                    }
                                    $in = $data_tanggal->in;
                                    $out = $data_tanggal->out;
                                    $sisa = $data_tanggal->sisa;

                                    // Akumulasi jumlah in, out, dan sisa
                                    $total_in += $in;
                                    $total_out += $out;
                                    $total_sisa += $sisa;

                                @endphp
                                <td style="text-align: right;">{{ $in != 0 ? $in : '' }}</td>
                                <td style="text-align: right;">{{ $out != 0 ? $out : '' }}</td>
                                <td style="text-align: right;">{{ $sisa != 0 ? $sisa : '' }}</td>
                            @endforeach
                            <td style="text-align: center;">
                                <!-- Tombol atau tautan untuk memicu modal -->
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal{{ $data_per_produk->first()->id}}">Edit</button>
                            </td>
                        </tr>

                        <!-- Modal untuk mengedit nilai in dan out -->
                        <div class="modal fade" id="editModal{{ $data_per_produk->first()->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModal{{ str_replace(' ', '_', $nama_produk) }}Label">Edit Resume</h5>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Form untuk mengedit in dan out -->
                                        <form action="{{ route('editresume', ['id' => $data_per_produk->first()->id]) }}" method="POST">
                                            @csrf
                                            <div>
                                                <label for="tanggal" class="form-label">Tanggal :</label>
                                                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $data_per_produk->first()->tanggal }}" disabled>
                                            </div>
                                            <div class="mt-2">
                                                <label for="nama_produk" class="form-label">Nama Produk :</label>
                                                <input type="text" name="nama_produk" id="nama_produk" class="form-control" value="{{ $nama_produk }}" disabled>
                                            </div>
                                            <div class="mt-2">
                                                <label for="sisa" class="form-label">Sisa:</label>
                                                <input type="number" name="sisa" id="sisa" class="form-control @error('sisa') is-invalid @enderror" value="{{ old('sisa', $data_per_produk->first()->sisa ) }}">
                                                @error('sisa')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <tr>
                        <td><b>Total</b></td>
                        @foreach ($uniqueDates as $tanggal)
                            @php
                                // Menghitung total in, out, dan sisa untuk setiap tanggal
                                $total_in_column = $groupedData->sum(function ($data_per_produk) use ($tanggal) {
                                    $data_tanggal = $data_per_produk->where('tanggal', $tanggal)->first();
                                    return $data_tanggal ? $data_tanggal->in : 0;
                                });
                                $total_out_column = $groupedData->sum(function ($data_per_produk) use ($tanggal) {
                                    $data_tanggal = $data_per_produk->where('tanggal', $tanggal)->first();
                                    return $data_tanggal ? $data_tanggal->out : 0;
                                });
                                $total_sisa_column = $groupedData->sum(function ($data_per_produk) use ($tanggal) {
                                    $data_tanggal = $data_per_produk->where('tanggal', $tanggal)->first();
                                    return $data_tanggal ? $data_tanggal->sisa : 0;
                                });
                            @endphp
                            <td style="text-align: right;"><b>{{ $total_in_column }}</b></td>
                            <td style="text-align: right;"><b>{{ $total_out_column }}</b></td>
                            <td style="text-align: right;"><b>{{ $total_sisa_column }}</b></td>
                        @endforeach
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</x-layout-manager>



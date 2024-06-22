@extends('manager.layout')
@section('main_content')
    <h1>Stok Kardus</h1>

    <div class="mt-1">
        <a href="generatestokkardus" class="btn btn-outline-primary">Tambah Stok Hari Ini</a>
    </div>

    <div class="mt-2">
        <div class="card">
            <div class="card-header">
                <div class="alert alert-warning mt-2" role="alert">
                    <p style="margin-bottom: 0;"><b>PENTING!</b></p>
                    <p style="margin-bottom: 0;"></p>
                    <ul style="margin-top: 0; margin-bottom: 0;">
                        <li><b>Pastikan data sudah benar untuk semua kardus sebelum menambah stok hari ini</b></li>
                        <li><b>Untuk mempermudah penambahan kardus sebaiknya dilakukan setelah pakai diinputkan</b></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div>
                    <p>Periode : {{ $startDate }} s.d. {{ $endDate }}</p>
                </div>
                <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                    <thead>
                        <tr>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Nama Kardus</th>
                            @foreach ($uniqueDates as $tanggal)
                                <th colspan="2" style="text-align: center;">{{ $tanggal }}</th>
                            @endforeach
                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Aksi</th>
                        </tr>
                        <tr>
                            @foreach ($uniqueDates as $tanggal)
                                <th style="text-align: center;">Pakai</th>
                                <th style="text-align: center;">Sisa</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupedData as $nama_kardus => $data_per_kardus)
                            <tr>
                                <td>{{ $nama_kardus }}</td>

                                @php
                                    $total_pakai = 0;
                                    $total_sisa = 0;
                                @endphp

                                @foreach ($uniqueDates as $tanggal)
                                    @php
                                        $data_tgl_kardus = $data_per_kardus->where('tanggal', $tanggal)->first();
                                        $pakai = $data_tgl_kardus ? $data_tgl_kardus->pakai : 0;
                                        $sisa = $data_tgl_kardus ? $data_tgl_kardus->sisa : 0;

                                        $total_pakai += $pakai;
                                        $total_sisa += $sisa;
                                    @endphp
                                    <td>{{ $pakai != 0 ? $pakai : '' }}</td>
                                    <td>{{ $sisa != 0 ? $sisa : '' }}</td>
                                @endforeach

                                <td style="text-align: center;">
                                    <!-- Tombol atau tautan untuk memicu modal -->
                                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal{{ $data_per_kardus->first()->id }}" >Edit</button>
                                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#tambahKardus{{ $data_per_kardus->first()->id }}" >Tambah</button>
                                </td>
                            </tr>

                            <div class="modal fade" id="editModal{{ $data_per_kardus->first()->id }}"
                                data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"
                                                id="editModal{{ str_replace(' ', '_', $nama_kardus) }}Label">Edit Stok Kardus
                                            </h5>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Form untuk mengedit in dan out -->
                                            <form
                                                action="{{ route('editstokkardus', ['id' => $data_per_kardus->first()->id]) }}"
                                                method="POST">
                                                @csrf
                                                <div>
                                                    <label for="tanggal" class="form-label">Tanggal :</label>
                                                    <input type="date" name="tanggal" id="tanggal" class="form-control"
                                                        value="{{ $data_per_kardus->first()->tanggal }}" disabled>
                                                </div>
                                                <div class="mt-2">
                                                    <label for="nama_produk" class="form-label">Nama Produk :</label>
                                                    <input type="text" name="nama_produk" id="nama_produk"
                                                        class="form-control" value="{{ $nama_kardus }}" disabled>
                                                </div>
                                                <div class="mt-2">
                                                    <label for="in" class="form-label">Pakai:</label>
                                                    <input type="number" name="pakai" id="pakai"
                                                        class="form-control @error('pakai') is-invalid @enderror"
                                                        value="{{ old('in', $data_per_kardus->first()->pakai) }}">
                                                    @error('pakai')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary mt-2">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="tambahKardus{{ $data_per_kardus->first()->id }}"
                                data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"
                                                id="editModal{{ str_replace(' ', '_', $nama_kardus) }}Label">Tambah Kardus-
                                            </h5>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Form untuk mengedit in dan out -->
                                            <form
                                                action="{{ route('tambahKardus', ['id' => $data_per_kardus->first()->id]) }}"
                                                method="POST">
                                                @csrf
                                                <div>
                                                    <label for="tanggal" class="form-label">Tanggal :</label>
                                                    <input type="date" name="tanggal" id="tanggal" class="form-control"
                                                        value="{{ $data_per_kardus->first()->tanggal }}" disabled>
                                                </div>
                                                <div class="mt-2">
                                                    <label for="nama_produk" class="form-label">Nama Produk :</label>
                                                    <input type="text" name="nama_produk" id="nama_produk"
                                                        class="form-control" value="{{ $nama_kardus }}" disabled>
                                                </div>
                                                <div class="mt-2">
                                                    <label for="in" class="form-label">Tambah :</label>
                                                    <input type="number" name="tambah" id="tambah"
                                                        class="form-control @error('tambah') is-invalid @enderror">
                                                    @error('pakai')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
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
                                    $total_pakai_column = $groupedData->sum(function ($data_per_kardus) use ($tanggal) {
                                        $data_tanggal = $data_per_kardus->where('tanggal', $tanggal)->first();
                                        return $data_tanggal ? $data_tanggal->pakai : 0;
                                    });
                                    $total_sisa_column = $groupedData->sum(function ($data_per_kardus) use ($tanggal) {
                                        $data_tanggal = $data_per_kardus->where('tanggal', $tanggal)->first();
                                        return $data_tanggal ? $data_tanggal->sisa : 0;
                                    });
                                @endphp
                                <td><b>{{ $total_pakai_column }}</b></td>
                                <td><b>{{ $total_sisa_column }}</b></td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

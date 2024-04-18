<head>
    <title>Mirasa Jaya - Resume Produksi</title>
</head>

@extends('manager.layout')
@section('main_content')
    <h1>Resume Produksi</h1>

    <div class="mt-2">
        <a href="tambahresumehariini" class="btn btn-outline-primary">Tambah Resume Hari Ini</a>
    </div>

    <div class="card mt-2">
        <div class="card-header">
            <div class="alert alert-warning mt-2" role="alert">
                <p style="margin-bottom: 0;"><b>PENTING!</b></p>
                <p style="margin-bottom: 0;"><b>Pastikan data sudah benar untuk semua produk sebelum menambah resume hari ini</b></p>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                <thead>
                    <tr>
                        <th rowspan="2">Nama Produk</th>
                        @foreach ($uniqueDates as $tanggal)
                            <th colspan="3">{{ $tanggal }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach ($uniqueDates as $tanggal)
                            <th>in</th>
                            <th>out</th>
                            <th>sisa</th>
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
                                    $in = $data_tanggal ? $data_tanggal->in : 0;
                                    $out = $data_tanggal ? $data_tanggal->out : 0;
                                    $sisa = $data_tanggal ? $data_tanggal->sisa : 0;

                                    // Akumulasi jumlah in, out, dan sisa
                                    $total_in += $in;
                                    $total_out += $out;
                                    $total_sisa += $sisa;

                                    if ($index > 0 && $in == 0 && $out == 0) {
                                        $sisa = $previous_sisas[$index - 1];
                                    }

                                    // Simpan nilai sisa untuk tanggal saat ini
                                    $previous_sisas[$index] = $sisa;
                                    $index++;
                                @endphp
                                <td>{{ $in != 0 ? $in : '' }}</td>
                                <td>{{ $out != 0 ? $out : '' }}</td>
                                <td>{{ $sisa != 0 ? $sisa : '' }}</td>
                            @endforeach
                            <td>
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
                                                <label for="in" class="form-label">Total Piutang:</label>
                                                <input type="number" name="in" id="in" class="form-control @error('in') is-invalid @enderror" value="{{ old('in', $data_per_produk->first()->in ) }}">
                                                @error('in')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mt-2">
                                                <label for="out" class="form-label">Total Piutang:</label>
                                                <input type="number" name="out" id="out" class="form-control @error('out') is-invalid @enderror" value="{{ old('out', $data_per_produk->first()->out ) }}">
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
                            <td>{{ $total_in_column }}</td>
                            <td>{{ $total_out_column }}</td>
                            <td>{{ $total_sisa_column }}</td>
                        @endforeach
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
@endsection

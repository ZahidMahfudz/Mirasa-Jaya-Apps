<x-layout-admin>
    <x-slot:title>Data Karyawan Harian</x-slot>
    <x-slot:tabs>Admin-Data Karyawan Harian</x-slot>

    <div>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahAkun">Tambah Karyawan Harian</button>
    </div>

    <div>
        <table class="table table-bordered table-striped table-sm border border-dark align-middle mt-3">
            <thead>
                <tr>
                    <th style="text-align: center; width:3%">ID Karyawan</th>
                    <th style="text-align: center; width:15%">Nama</th>
                    <th style="text-align: center; width:7%">Bagian</th>
                    <th style="text-align: center; width:7%">Posisi</th>
                    <th style="text-align: center; width:7%">Gaji Pokok(Rp.)</th>
                    <th style="text-align: center; width:7%">Uang Makan(Rp.)</th>
                    <th style="text-align: center; width:7%">Tunjangan(Rp.)</th>
                    <th style="text-align: center; width:6%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data_karyawan as $item)
                    <tr>
                        <td style="text-align: center;">{{ $item->id_karyawan }}</td>
                        <td>{{ $item->nama_karyawan }}</td>
                        <td>{{ $item->bagian }}</td>
                        <td>{{ $item->posisi }}</td>
                        <td style="text-align: right;">{{ number_format($item->gaji_pokok, 0, ',', '.') }}</td>
                        <td style="text-align: right;">{{ number_format($item->makan, 0, ',', '.') }}</td>
                        <td style="text-align: right;">{{ number_format($item->tunjangan, 0, ',', '.') }}</td>
                        <td style="text-align: center;">
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editKaryawan-{{ $item->id_karyawan }}">Edit</button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteKaryawan-{{ $item->id_karyawan }}">Hapus</button>

                            <div class="modal fade" id="deleteKaryawan-{{ $item->id_karyawan }}" tabindex="-1" aria-labelledby="deleteKaryawanLabel-{{ $item->id_karyawan }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteKaryawanLabel-{{ $item->id_karyawan }}">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus karyawan dengan ID {{ $item->id_karyawan }} yang bernama {{ $item->nama_karyawan }}?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <a href="/deleteKaryawan/{{ $item->id_karyawan }}" class="btn btn-danger">Hapus</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <div class="modal fade" id="editKaryawan-{{ $item->id_karyawan }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Edit {{ $item->id_karyawan }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="/editKaryawan/{{ $item->id_karyawan }}" method="post">
                                            @csrf
                                            <div>
                                                <label for="nama_karyawan" class="form-label">Nama Karyawan :</label>
                                                <input type="text" name="nama_karyawan" class="form-control" value="{{ $item->nama_karyawan }}">
                                            </div>
                                            <div class="mt-2">
                                                <label for="Bagian" class="form-label">Bagian Karyawan:</label>
                                                <input type="text" name="Bagian" id="Bagian" class="form-control" value="{{ $item->bagian }}">
                                            </div>
                                            <div class="mt-2">
                                                <label for="posisi" class="form-label">Posisi Karyawan:</label>
                                                <input type="text" name="posisi" id="posisi" class="form-control" value="{{ $item->posisi }}">
                                            </div>
                                            <div class="mt-2">
                                                <label for="Gaji_Pokok" class="form-label">Gaji Pokok Karyawan:</label>
                                                <input type="number" name="Gaji_Pokok" id="Gaji_Pokok" class="form-control" value="{{ $item->gaji_pokok }}">
                                            </div>
                                            <div class="mt-2">
                                                <label for="makan" class="form-label">Uang Makan Karyawan:</label>
                                                <input type="number" name="makan" id="makan" class="form-control" value="{{ $item->makan }}">
                                            </div>
                                            <div class="mt-2">
                                                <label for="Bonus" class="form-label">Tunjangan Karyawan:</label>
                                                <input type="number" name="Bonus" id="Bonus" class="form-control" value="{{ $item->tunjangan }}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
        <div class="modal fade" id="tambahAkun" tabindex="-1" aria-labelledby="tambahAkunLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahAkunLabel">Tambah Karyawan Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/addKaryawan" method="POST">
                            @csrf
                            <div>
                                <label for="nama_karyawan" class="form-label">Nama Karyawan:</label>
                                <input type="text" name="nama_karyawan" id="nama_karyawan" class="form-control" required>
                            </div>
                            <div class="mt-2">
                                <label for="Bagian" class="form-label">Bagian Karyawan:</label>
                                <input type="text" name="Bagian" id="Bagian" class="form-control" required>
                            </div>
                            <div class="mt-2">
                                <label for="posisi" class="form-label">Posisi Karyawan:</label>
                                <input type="text" name="posisi" id="posisi" class="form-control" required>
                            </div>
                            <div class="mt-2">
                                <label for="Gaji_Pokok" class="form-label">Gaji Pokok Karyawan:</label>
                                <input type="number" name="Gaji_Pokok" id="Gaji_Pokok" class="form-control" required>
                            </div>
                            <div class="mt-2">
                                <label for="makan" class="form-label">Uang Makan Karyawan:</label>
                                <input type="number" name="makan" id="makan" class="form-control" required>
                            </div>
                            <div class="mt-2">
                                <label for="Bonus" class="form-label">Tunjangan Karyawan:</label>
                                <input type="number" name="Bonus" id="Bonus" class="form-control" required>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                    </div>
    </div>

</x-layout-admin>
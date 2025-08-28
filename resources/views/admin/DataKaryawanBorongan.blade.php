<x-layout-admin>
    <x-slot:title>Data Karyawan Borongan</x-slot>
    <x-slot:tabs>Admin-Data Karyawan Borongan</x-slot>

    <div>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahAkun">Tambah Karyawan Borongan</button>
    </div>

    <div>
        <table class="table table-bordered table-striped table-sm border border-dark align-middle mt-3">
            <thead>
                <tr>
                    <th style="text-align: center; width:3%; vertical-align:middle">ID Karyawan</th>
                    <th style="text-align: center; width:15%; vertical-align:middle">Nama</th>
                    <th style="text-align: center; width:7%; vertical-align:middle">Bagian</th>
                    <th style="text-align: center; width:7%; vertical-align:middle">Harga Spet S(Rp/Resep)</th>
                    <th style="text-align: center; width:7%; vertical-align:middle">Harga Spet O(Rp/Resep)</th>
                    <th style="text-align: center; width:7%; vertical-align:middle">Uang Makan(Rp.)</th>
                    <th style="text-align: center; width:7%; vertical-align:middle">Tunjangan(Rp.)</th>
                    <th style="text-align: center; width:6%; vertical-align:middle">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data_karyawan_borongan as $item)
                    <tr>
                        <td>{{ $item->id_karyawan_borongan }}</td>
                        <td>{{ $item->nama_karyawan }}</td>
                        <td>{{ $item->bagian }}</td>
                        <td style="text-align: right;">{{ number_format($item->harga_s, 0, ',', '.') }}</td>
                        <td style="text-align: right;">{{ number_format($item->harga_o, 0, ',', '.') }}</td>
                        <td style="text-align: right;">{{ number_format($item->makan, 0, ',', '.') }}</td>
                        <td style="text-align: right;">{{ number_format($item->tunjangan, 0, ',', '.') }}</td>
                        <td style="text-align: center;">
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editKaryawan-{{ $item->id_karyawan_borongan }}">Edit</button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteKaryawan-{{ $item->id_karyawan_borongan }}">Hapus</button>

                            <div class="modal fade" id="editKaryawan-{{ $item->id_karyawan_borongan }}" tabindex="-1" aria-labelledby="editKaryawanLabel-{{ $item->id_karyawan_borongan }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editKaryawanLabel-{{ $item->id_karyawan_borongan }}">Edit Karyawan Borongan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="/editKaryawanBorongan/{{ $item->id_karyawan_borongan }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3 text-start">
                                                    <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                                                    <input type="text" class="form-control" id="nama_karyawan" name="nama_karyawan" value="{{ $item->nama_karyawan }}" required>
                                                </div>
                                                <div class="mb-3 text-start">
                                                    <label for="bagian" class="form-label">Bagian</label>
                                                    <input type="text" class="form-control" id="bagian" name="bagian" value="{{ $item->bagian }}" required>
                                                </div>
                                                <div class="mb-3 text-start">
                                                    <label for="harga_s" class="form-label">Harga Spet S (Rp/Resep)</label>
                                                    <input type="number" class="form-control" id="harga_s" name="harga_s" value="{{ $item->harga_s }}" required>
                                                </div>
                                                <div class="mb-3 text-start">
                                                    <label for="harga_o" class="form-label">Harga Spet O (Rp/Resep)</label>
                                                    <input type="number" class="form-control" id="harga_o" name="harga_o" value="{{ $item->harga_o }}" required>
                                                </div>
                                                <div class="mb-3 text-start">
                                                    <label for="makan" class="form-label">Uang Makan (Rp.)</label>
                                                    <input type="number" class="form-control" id="makan" name="makan" value="{{ $item->makan }}" required>
                                                </div>
                                                <div class="mb-3 text-start">
                                                    <label for="tunjangan" class="form-label">Tunjangan (Rp.)</label>
                                                    <input type="number" class="form-control" id="tunjangan" name="tunjangan" value="{{ $item->tunjangan }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="deleteKaryawan-{{ $item->id_karyawan_borongan }}" tabindex="-1" aria-labelledby="deleteKaryawanLabel-{{ $item->id_karyawan_borongan }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteKaryawanLabel-{{ $item->id_karyawan_borongan }}">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus karyawan dengan ID {{ $item->id_karyawan_borongan }} yang bernama {{ $item->nama_karyawan }}?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <a href="/deleteKaryawanborongan/{{ $item->id_karyawan_borongan }}" class="btn btn-danger">Hapus</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="tambahAkun" tabindex="-1" aria-labelledby="tambahAkunLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahAkunLabel">Tambah Karyawan Borongan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/addKaryawanBorongan" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                            <input type="text" class="form-control" id="nama_karyawan" name="nama_karyawan" required>
                        </div>
                        <div class="mb-3">
                            <label for="bagian" class="form-label">Bagian</label>
                            <input type="text" class="form-control" id="bagian" name="bagian" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga_s" class="form-label">Harga Spet S (Rp/Resep)</label>
                            <input type="number" class="form-control" id="harga_s" name="harga_s" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga_o" class="form-label">Harga Spet O (Rp/Resep)</label>
                            <input type="number" class="form-control" id="harga_o" name="harga_o" required>
                        </div>
                        <div class="mb-3">
                            <label for="makan" class="form-label">Uang Makan (Rp.)</label>
                            <input type="number" class="form-control" id="makan" name="makan" required>
                        </div>
                        <div class="mb-3">
                            <label for="tunjangan" class="form-label">Tunjangan (Rp.)</label>
                            <input type="number" class="form-control" id="tunjangan" name="tunjangan" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout-admin>
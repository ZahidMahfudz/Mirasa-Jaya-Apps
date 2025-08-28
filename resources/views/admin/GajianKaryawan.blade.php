<x-layout-admin>
    <x-slot:title>Gaji Karyawan</x-slot>
    <x-slot:tabs>Admin-Gaji Karyawan</x-slot>

    <div>
        <a href="/GenerateGajian" class="btn btn-outline-primary">Generate Gaji Untuk Semua Karyawan</a>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahAkun">Buat Gaji Untuk Karyawan Tertentu</button>
        <a href="/cetakSlipGaji/{{ $tanggalTerakhir }}" class="btn btn-outline-primary" target="blank_">Cetak Slip Gaji {{ $tanggalTerakhir }}</a>
    </div>

    <div class="mb-5">
        <h3 class="mt-3">Daftar Gaji Karyawan Tanggal : {{ $tanggalTerakhir }}</h3>
        {{-- <div class="input-group mt-3">
            <input type="date" class="form-control" placeholder="Pilih Tanggal" aria-label="Pilih Tanggal" aria-describedby="button-filter">
            <button class="btn btn-outline-secondary" type="button" id="button-filter">Filter</button>
        </div> --}}
        <table class="table table-bordered table-striped table-sm border border-dark align-middle mt-3">
            <thead>
                <tr>
                    <th style="text-align: center; vertical-align: middle; width:10%;" rowspan="2">Nama Karyawan</th>
                    <th style="text-align: center; vertical-align: middle; width:10%;" rowspan="2">Bagian</th>
                    <th style="text-align: center; vertical-align: middle; width:10%;" rowspan="2">Posisi</th>
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
                        <td rowspan="3" style="text-align: center;">
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editGajian-{{ $item->id_gaji }}">Edit</button>
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusGaji-{{ $item->id_gaji }}">Hapus</button>

                            <!-- Modal Hapus Gaji -->
                            <div class="modal fade" id="hapusGaji-{{ $item->id_gaji }}" tabindex="-1" aria-labelledby="hapusGajiLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="hapusGajiLabel">Konfirmasi Hapus Gaji</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus gaji untuk karyawan <strong>{{ $item->dataKaryawan->nama_karyawan }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <a href="/hapusGaji/{{ $item->id_gaji }}" class="btn btn-danger">Hapus</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Modal Edit Gajian -->
                        <div class="modal fade" id="editGajian-{{ $item->id_gaji }}" tabindex="-1" aria-labelledby="editGajianLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="/editGajian/{{ $item->id_gaji }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editGajianLabel">Edit Gaji Karyawan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                                                <input type="text" class="form-control" id="nama_karyawan" value="{{ $item->dataKaryawan->nama_karyawan }}" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="bagian" class="form-label">Bagian</label>
                                                <input type="text" class="form-control" id="bagian" value="{{ $item->dataKaryawan->bagian }}" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="posisi" class="form-label">Posisi</label>
                                                <input type="text" class="form-control" id="posisi" value="{{ $item->dataKaryawan->posisi }}" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="jumlah_masuk" class="form-label">Jumlah Masuk</label>
                                                <input type="number" class="form-control" id="jumlah_masuk" name="jumlah_masuk" value="{{ $item->jumlah_masuk }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="jumlah_bonus" class="form-label">Jumlah Bonus</label>
                                                <input type="number" class="form-control" id="jumlah_bonus" name="jumlah_bonus" value="{{ $item->jumlah_bonus }}">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
                @endforeach
                <tr>
                    <td colspan="7" style="text-align: right;"><strong>Total Pengeluaran Gaji Karyawan {{ $tanggalTerakhir }}</strong></td>
                    <td style="text-align: right;"><strong>{{ number_format($total_pengeluaran, 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        <p>.</p>
    </div>

    <div class="modal fade" id="tambahAkun" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Gaji Karyawan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/tambahGajian" method="post">
                        @csrf
                        <div class="mt-2">
                            <label for="tanggal_hari_ini" class="form-label">Tanggal Hari Ini :</label>
                            <input type="date" name="tanggal_hari_ini" id="tanggal_hari_ini" class="form-control" value="{{ \Carbon\Carbon::now()->toDateString() }}" disabled>
                        </div>
                        <div class="row mt-2 mb-2">
                            <div class="col-md-4">
                                <label for="nama_karyawan" class="form-label">Nama Karyawan:</label>
                                <select name="nama_karyawan[]" id="nama_karyawan" class="form-control @error('nama_karyawan') is-invalid @enderror">
                                    <option value="">Pilih Karyawan</option>
                                    @foreach ($karyawan as $k)
                                        <option value="{{ $k->id_karyawan }}">{{ $k->nama_karyawan }}</option>
                                    @endforeach
                                </select>
                                @error('nama_karyawan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="jumlah_masuk" class="form-label">Jumlah Masuk:</label>
                                <input type="number" name="jumlah_masuk[]" class="form-control" placeholder="Jumlah Masuk">
                            </div>
                            <div class="col-md-3">
                                <label for="jumlah_bonus" class="form-label">Jumlah Bonus:</label>
                                <input type="number" name="jumlah_bonus[]" class="form-control" placeholder="Jumlah Bonus">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <p></p>
                            </div>
                        </div>
                        <div id="karyawan-container-tambah"></div>
                        <button type="button" class="btn btn-outline-secondary mt-2" onclick="tambahKaryawan()">Tambah Karyawan</button>

                        <script>
                            function tambahKaryawan() {
                                const container = document.getElementById('karyawan-container-tambah');
                                const newKaryawan = document.createElement('div');
                                newKaryawan.classList.add('row', 'mt-2');
                                newKaryawan.innerHTML = `
                                    <div class="col-md-4">
                                        <select name="nama_karyawan[]" class="form-control">
                                            <option value="">Pilih Karyawan</option>
                                            @foreach ($karyawan as $k)
                                                @if (!in_array($k->id_karyawan, array_merge(old('nama_karyawan', []), request()->input('nama_karyawan', []))))
                                                    <option value="{{ $k->id_karyawan }}">{{ $k->nama_karyawan }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="jumlah_masuk[]" class="form-control" placeholder="Jumlah Masuk">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="jumlah_bonus[]" class="form-control" placeholder="Jumlah Bonus">
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-outline-danger" onclick="removeKaryawan(this)">Hapus</button>
                                    </div>
                                `;
                                container.appendChild(newKaryawan);
                            }

                            function removeKaryawan(button) {
                                button.parentElement.parentElement.remove();
                            }
                        </script>
                        
                        <div class="modal-footer mt-5">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout-admin>
<x-layout-admin>
    <x-slot:title>Pengeluaran</x-slot:title>
    <x-slot:tabs>admin-Pengeluaran</x-slot:title>

    <div>
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahPengeluaranModal">
            Tambah Pengeluaran
        </button>

        <!-- Modal -->
        <div class="modal fade" id="tambahPengeluaranModal" tabindex="-1" aria-labelledby="tambahPengeluaranModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahPengeluaranModalLabel">Tambah Pengeluaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form content goes here -->
                        <form action="/tambahPengeluaran" method="POST">
                            @csrf
                            <div class="mt-3">
                                <div class="alert alert-warning" role="alert">
                                    <h4 class="alert-heading">Perhatian!</h4>
                                    <p>Apabila pengeluaran hanya total pengeluaran, maka qty dan harga satuan dikosongi</p>
                                    <p>Apabila pengeluaran ada qty dan harga satuan, maka total pengeluaran dikosongi</p>

                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="tanggalPengeluaran" class="form-label">Tanggal Pengeluaran</label>
                                <input type="date" class="form-control" id="tanggalPengeluaran" name="tanggalPengeluaran" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="jenisPengeluaran" class="form-label">Jenis Pengeluaran</label>
                                <select class="form-select" id="jenisPengeluaran" name="jenisPengeluaran" required>
                                    <option selected>Pilih Jenis Pengeluaran</option>
                                    <option value="bb">Pembelian Bahan Baku</option>
                                    <option value="akpro">Akomodasi Produksi</option>
                                    <option value="akpem">Akomodasi Pemasaran</option>
                                    <option value="perl">Perlengkapan Produksi</option>
                                    <option value="pera">Perawatan Alat</option>
                                    <option value="pemba">Pembelian Alat</option>
                                    <option value="gk">Gaji Karyawan</option>
                                    <option value="gd">Gaji Direksi</option>
                                    <option value="m">Makan Minum</option>
                                    <option value="lis">Listrik</option>
                                    <option value="pajak">Pajak</option>
                                    <option value="sos">Sosial</option>
                                    <option value="st">Sewa Tempat</option>
                                    <option value="project">Project</option>
                                    <option value="thr">THR</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="namaPengeluaran" class="form-label">Hal</label>
                                <input type="text" class="form-control" id="namaPengeluaran" name="namaPengeluaran" required>
                            </div>
                            <div class="mb-3">
                                <label for="qty" class="form-label">QTY :</label>
                                <input type="number"  step='0.01' class="form-control" id="qty" name="qty">
                            </div>
                            <div class="mb-3">
                                <label for="harga_satuan" class="form-label">Harga Satuan :</label>
                                <input type="number"  step='0.01' class="form-control" id="harga_satuan" name="harga_satuan">
                            </div>
                            <div class="mb-3">
                                <label for="total_pengeluaran" class="form-label">Total Pengeluaran :</label>
                                <input type="number"  step='0.01' class="form-control" id="total_pengeluaran" name="total_pengeluaran">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <h4>Pengeluaran Tanggal : {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</h4>
    </div>

    <div>
        <table class="table table-bordered table-striped table-sm border border-dark align-middle">
            <thead>
                <tr>
                    <th scope="col" style="width: 1%; text-align:center; vertical-align:middle;">No</th>
                    <th scope="col" style="width: 5%; text-align:center; vertical-align:middle;">Jenis Pengeluaran</th>
                    <th scope="col" style="width: 5%; text-align:center; vertical-align:middle;">Tanggal Pengeluaran</th>
                    <th scope="col" style="width: 40%; text-align:center; vertical-align:middle;">Hal</th>
                    <th scope="col" style="width: 7%; text-align:center; vertical-align:middle;">QTY</th>
                    <th scope="col" style="width: 7%; text-align:center; vertical-align:middle;">Harga Satuan</th>
                    <th scope="col" style="width: 10%; text-align:center; vertical-align:middle;">Total Pengeluaran</th>
                    <th scope="col" style="width: 8%; text-align:center; vertical-align:middle;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengeluaran as $item)
                <tr>
                    <td scope="row" style="text-align: center; vertical-align: middle;">{{ $loop->iteration }}</td>
                    <td style="text-align: center; vertical-align: middle;">{{ $item->jenis_pengeluaran }}</td>
                    <td style="text-align: center; vertical-align: middle;">{{ \Carbon\Carbon::parse($item->tanggal_pengeluaran)->format('d/m/Y') }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td style="text-align: center; vertical-align: middle;">{{ $item->qty }}</td>
                    <td style="text-align: right; vertical-align: middle;">{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td style="text-align: right; vertical-align: middle;">{{ number_format($item->total_pengeluaran, 0, ',', '.') }}</td>
                    <td style="text-align: center; vertical-align: middle;">
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editPengeluaranModal{{ $item->id_pengeluaran_beban_usaha }}">
                            Edit
                        </button>   

                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#hapusPengeluaran-{{ $item->id_pengeluaran_beban_usaha }}">
                            Hapus
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="hapusPengeluaran-{{ $item->id_pengeluaran_beban_usaha }}" tabindex="-1" aria-labelledby="hapusPengeluaranLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapusPengeluaranLabel">Konfirmasi Hapus Pengeluaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus pengeluaran untuk <strong>{{ $item->keterangan }}</strong> sejumlah {{ number_format($item->total_pengeluaran, 0, ',', '.') }}?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <a href="/hapusPengeluaran/{{ $item->id_pengeluaran_beban_usaha }}" class="btn btn-danger">Hapus</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </td>
                    <!-- Modal -->
                    <div class="modal fade" id="editPengeluaranModal{{ $item->id_pengeluaran_beban_usaha }}" tabindex="-1" aria-labelledby="editPengeluaranModalLabel{{ $item->id_pengeluaran_beban_usaha }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editPengeluaranModalLabel{{ $item->id_pengeluaran_beban_usaha }}">Edit Pengeluaran</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="/editPengeluaran/{{ $item->id_pengeluaran_beban_usaha }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="editTanggalPengeluaran{{ $item->id_pengeluaran_beban_usaha }}" class="form-label">Tanggal Pengeluaran</label>
                                            <input type="date" class="form-control" id="editTanggalPengeluaran{{ $item->id_pengeluaran_beban_usaha }}" name="tanggalPengeluaran" value="{{ $item->tanggal_pengeluaran }}" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editJenisPengeluaran{{ $item->id_pengeluaran_beban_usaha }}" class="form-label">Jenis Pengeluaran</label>
                                            <select class="form-select" id="editJenisPengeluaran{{ $item->id }}" name="jenisPengeluaran" required>
                                                <option value="bb" {{ $item->jenis_pengeluaran == 'bb' ? 'selected' : '' }}>Pembelian Bahan Baku</option>
                                                <option value="akpro" {{ $item->jenis_pengeluaran == 'akpro' ? 'selected' : '' }}>Akomodasi Produksi</option>
                                                <option value="akpem" {{ $item->jenis_pengeluaran == 'akpem' ? 'selected' : '' }}>Akomodasi Pemasaran</option>
                                                <option value="perl" {{ $item->jenis_pengeluaran == 'perl' ? 'selected' : '' }}>Perlengkapan Produksi</option>
                                                <option value="pera" {{ $item->jenis_pengeluaran == 'pera' ? 'selected' : '' }}>Perawatan Alat</option>
                                                <option value="pemba" {{ $item->jenis_pengeluaran == 'pemba' ? 'selected' : '' }}>Pembelian Alat</option>
                                                <option value="gk" {{ $item->jenis_pengeluaran == 'gk' ? 'selected' : '' }}>Gaji Karyawan</option>
                                                <option value="gd" {{ $item->jenis_pengeluaran == 'gd' ? 'selected' : '' }}>Gaji Direksi</option>
                                                <option value="m" {{ $item->jenis_pengeluaran == 'm' ? 'selected' : '' }}>Makan Minum</option>
                                                <option value="lis" {{ $item->jenis_pengeluaran == 'lis' ? 'selected' : '' }}>Listrik</option>
                                                <option value="pajak" {{ $item->jenis_pengeluaran == 'pajak' ? 'selected' : '' }}>Pajak</option>
                                                <option value="sos" {{ $item->jenis_pengeluaran == 'sos' ? 'selected' : '' }}>Sosial</option>
                                                <option value="st" {{ $item->jenis_pengeluaran == 'st' ? 'selected' : '' }}>Sewa Tempat</option>
                                                <option value="project" {{ $item->jenis_pengeluaran == 'project' ? 'selected' : '' }}>Project</option>
                                                <option value="thr" {{ $item->jenis_pengeluaran == 'thr' ? 'selected' : '' }}>THR</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editNamaPengeluaran{{ $item->id_pengeluaran_beban_usaha }}" class="form-label">Hal</label>
                                            <input type="text" class="form-control" id="editNamaPengeluaran{{ $item->id }}" name="namaPengeluaran" value="{{ $item->keterangan }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="editQty{{ $item->id_pengeluaran_beban_usaha }}" class="form-label">QTY :</label>
                                            <input type="number" step='0.01' class="form-control" id="editQty{{ $item->id }}" name="qty" value="{{ $item->qty }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="editHargaSatuan{{ $item->id_pengeluaran_beban_usahaid }}" class="form-label">Harga Satuan :</label>
                                            <input type="number" step='0.01' class="form-control" id="editHargaSatuan{{ $item->id }}" name="harga_satuan" value="{{ $item->harga_satuan }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="editTotalPengeluaran{{ $item->id_pengeluaran_beban_usaha }}" class="form-label">Total Pengeluaran :</label>
                                            <input type="number" step='0.01' class="form-control" id="editTotalPengeluaran{{ $item->id_pengeluaran_beban_usaha }}" name="total_pengeluaran" value="{{ $item->total_pengeluaran }}" 
                                            @if($item->qty && $item->harga_satuan) disabled @else required @endif>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </tr>
                @endforeach
                <tr>
                    <td colspan="6" class="text-end fw-bold">Total Pengeluaran</td>
                    <td class="fw-bold" style="text-align: right; vertical-align: middle;">{{ number_format($pengeluaran->sum('total_pengeluaran'), 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>

</x-layout-admin>
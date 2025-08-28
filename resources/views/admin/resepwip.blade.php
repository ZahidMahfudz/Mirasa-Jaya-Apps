<x-layout-admin>
    <x-slot:title>Resep WIP (Work In Progress)</x-slot>
    <x-slot:tabs>Manager-Resep WIP</x-slot>

    <div class="mt-2">
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addResepModal">Tambah Resep</button>
    </div>

    <!-- Add Resep Modal -->
    <div class="modal fade" id="addResepModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addResepModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addResepModalLabel">Tambah Resep</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('resepstore') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_resep" class="form-label">Nama Resep</label>

                            <input type="text" name="nama_resep" id="nama_resep" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="lini_produksi" class="form-label">Lini Produksi</label>
                            <input type="text" name="lini_produksi" id="lini_produksi" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="bahan" class="form-label">Bahan</label>
                            <div id="bahan-container">
                                <div class="input-group mb-2">
                                    <select name="nama_bahan[]" class="form-select" required>
                                        <option value="" disabled selected>Pilih Bahan</option>
                                        @foreach ($bb as $bahanbaku)
                                            <option value="{{ $bahanbaku->nama_bahan }}">{{ $bahanbaku->nama_bahan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="jumlah_bahan_gr[]" class="form-control" placeholder="(gr)" step="0.001" required>
                                    <input type="number" name="jumlah_bahan_kg[]" class="form-control" placeholder="(kg)" step="0.001"required>
                                    <input type="number" name="jumlah_bahan_zak[]" class="form-control" placeholder="(zak)" step="0.001" required>
                                    <button type="button" class="btn btn-danger remove-bahan">Hapus</button>
                                </div>
                            </div>
                            <button type="button" id="add-bahan" class="btn btn-secondary">Tambah Bahan</button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan Resep</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add-bahan').addEventListener('click', function() {
            var container = document.getElementById('bahan-container');
            var newBahan = document.createElement('div');
            newBahan.classList.add('input-group', 'mb-2');
            newBahan.innerHTML = `
            <select name="nama_bahan[]" class="form-select" required>
                <option value="" disabled selected>Pilih Bahan</option>
                @foreach ($bb as $bahanbaku)
                    <option value="{{ $bahanbaku->nama_bahan }}">{{ $bahanbaku->nama_bahan }}</option>
                @endforeach
            </select>
            <input type="number" name="jumlah_bahan_gr[]" class="form-control" placeholder="(gr)" step="0.001" required>
            <input type="number" name="jumlah_bahan_kg[]" class="form-control" placeholder="(kg)" step="0.001" required>
            <input type="number" name="jumlah_bahan_zak[]" class="form-control" placeholder="(zak)" step="0.001" required>
            <button type="button" class="btn btn-danger remove-bahan">Hapus</button>
        `;
            container.appendChild(newBahan);

            newBahan.querySelector('.remove-bahan').addEventListener('click', function() {
                container.removeChild(newBahan);
            });
        });

        document.querySelectorAll('.remove-bahan').forEach(function(button) {
            button.addEventListener('click', function() {
                var container = document.getElementById('bahan-container');
                container.removeChild(button.parentElement);
            });
        });
    </script>

    <table class="table table-bordered table-sm border border-dark align-middle mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Resep</th>
                <th>Lini Produksi</th>
                <th>Bahan</th>
                <th>Jumlah (gr)</th>
                <th>Jumlah (kg)</th>
                <th>Jumlah (zak)</th>
                <th style="width: 9%; text-align:center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resep as $index => $resepItem)
                @foreach ($resepItem->bahan_resep as $bahanIndex => $bahanResep)
                    <tr>
                        @if ($bahanIndex === 0)
                            <td rowspan="{{ $resepItem->bahan_resep->count() + 1 }}">{{ $index + 1 }}</td>
                            <td rowspan="{{ $resepItem->bahan_resep->count() + 1 }}">{{ $resepItem->nama_resep }}</td>
                            <td rowspan="{{ $resepItem->bahan_resep->count() + 1 }}">{{ $resepItem->lini_produksi }}</td>
                        @endif
                        <td>{{ $bahanResep->nama_bahan }}</td>
                        <td style="text-align: right;">{{ $bahanResep->jumlah_bahan_gr }}</td>
                        <td style="text-align: right;">{{ $bahanResep->jumlah_bahan_kg }}</td>
                        <td style="text-align: right;">{{ $bahanResep->jumlah_bahan_zak }}</td>
                        @if ($bahanIndex === 0)
                            <td rowspan="{{ $resepItem->bahan_resep->count() + 1 }}">
                                <button class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $resepItem->id }}">Edit</button>
                                <form action="{{ route('resepdestroy', $resepItem->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus resep {{ $resepItem->nama_resep }}?');">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
                <tr>
                    <td colspan="7">
                        <button class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addBahanModal{{ $resepItem->id }}">Tambah Bahan</button>
                    </td>
                </tr>
                <!-- Add Bahan Modal -->
                <div class="modal fade" id="addBahanModal{{ $resepItem->id }}" data-bs-backdrop="static"
                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addBahanModal{{ $resepItem->id }}Label">Tambah Bahan untuk {{ $resepItem->nama_resep }}</h5>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('bahan_resepstore') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="resep_id" value="{{ $resepItem->id }}">
                                    <div class="mb-3">
                                        <label for="nama_bahan" class="form-label">Nama Bahan</label>
                                        <select name="nama_bahan" class="form-select" required>
                                            <option value="" disabled selected>Pilih Bahan</option>
                                            @foreach ($bb as $bahanbaku)
                                                <option value="{{ $bahanbaku->nama_bahan }}">{{ $bahanbaku->nama_bahan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jumlah_bahan_gr" class="form-label">(gr)</label>
                                        <input type="number" name="jumlah_bahan_gr" id="jumlah_bahan_gr" class="form-control" step="0.001" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jumlah_bahan_kg" class="form-label">(kg)</label>
                                        <input type="number" name="jumlah_bahan_kg" id="jumlah_bahan_kg" class="form-control" step="0.001" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jumlah_bahan_zak" class="form-label">(zak)</label>
                                        <input type="number" name="jumlah_bahan_zak" id="jumlah_bahan_zak" class="form-control" step="0.001" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Simpan Tambahan Bahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Edit Modal -->
                <div class="modal fade" id="editModal{{ $resepItem->id }}" data-bs-backdrop="static"
                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModal{{ $resepItem->id }}Label">Edit Resep</h5>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('resepupdate', $resepItem->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nama_resep" class="form-label">Nama Resep</label>
                                        <input type="text" name="nama_resep" id="nama_resep" class="form-control"
                                            value="{{ $resepItem->nama_resep }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="lini_produksi" class="form-label">Lini Produksi</label>
                                        <input type="text" name="lini_produksi" id="lini_produksi"
                                            class="form-control" value="{{ $resepItem->lini_produksi }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="bahan_resep" class="form-label">Bahan</label>
                                        @foreach ($resepItem->bahan_resep as $bahanResep)
                                            <div class="input-group mb-2">
                                                <input type="text" name="nama_bahan[]" class="form-control"
                                                    value="{{ $bahanResep->nama_bahan }}"  disabled>
                                                <input type="number" name="jumlah_bahan_gr[]" class="form-control"
                                                    placeholder="Gr" value="{{ $bahanResep->jumlah_bahan_gr }}" step="0.001">
                                                <input type="number" name="jumlah_bahan_kg[]" class="form-control"
                                                    placeholder="Kg" value="{{ $bahanResep->jumlah_bahan_kg }}" step="0.001">
                                                <input type="number" name="jumlah_bahan_zak[]" class="form-control"
                                                    placeholder="Zak" value="{{ $bahanResep->jumlah_bahan_zak }}" step="0.001">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
</x-layout-admin>


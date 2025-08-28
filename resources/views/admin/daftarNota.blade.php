<x-layout-admin>
    <x-slot:title>Daftar Nota</x-slot>
    <x-slot:tabs>Daftar Nota</x-slot>

    <!-- Button to trigger modal -->
    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addNotaModal">
        Tambah Nota Harga Pabrik
    </button>

    <!-- Button to trigger modal for Nota Pemasaran -->
    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#addNotaPemasaranModal">
        Tambah Nota Pemasaran
    </button>

    <div class="mt-4">
        <ul class="nav nav-tabs" id="notaTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="notaLunas-tab" data-bs-toggle="tab" data-bs-target="#notaLunas" type="button" role="tab" aria-controls="notaLunas" aria-selected="true">Nota Belum Lunas</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="notaBelumLunas-tab" data-bs-toggle="tab" data-bs-target="#notaBelumLunas" type="button" role="tab" aria-controls="notaBelumLunas" aria-selected="false">Nota Lunas</button>
            </li>
        </ul>
        <div class="tab-content" id="notaTabsContent">
            <div class="tab-pane fade show active" id="notaLunas" role="tabpanel" aria-labelledby="notaLunas-tab">
                <div class="mt-3">
                    <h5>Daftar Nota Belum Lunas</h5>
                    <table class="table table-bordered table-striped table-sm border border-dark align-middle mt-3">
                        <thead class="text-center align-middle">
                            <tr>
                                <th rowspan="2">Jenis Nota</th>
                                <th rowspan="2">Tanggal Nota</th>
                                <th rowspan="2">Nama Pelanggan</th>
                                <th rowspan="2">Status</th>
                                <th colspan="4">Item</th>
                                <th rowspan="2">Total</th>
                                <th rowspan="2">keterangan</th>
                                <th rowspan="2">Aksi</th>
                            </tr>
                            <tr>
                                <th>Nama Produk</th>
                                <th>qty</th>
                                <th>harga Satuan</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notabelumlunas as $nota)
                                <tr>
                                    <td rowspan="{{ count($nota->item_nota) }}" class="text-center">
                                        @if ($nota->jenis_nota === 'nota_cash')
                                            Cash
                                        @elseif ($nota->jenis_nota === 'nota_noncash')
                                            Non-Cash
                                        @endif
                                    </td>
                                    <td rowspan="{{ count($nota->item_nota) }}" class="text-center">{{ \Carbon\Carbon::parse($nota->tanggal)->format('d/m/Y') }}</td>
                                    <td rowspan="{{ count($nota->item_nota) }}">{{ $nota->nama_toko }}</td>
                                    <td rowspan="{{ count($nota->item_nota) }}" class="text-center">
                                        @if ($nota->status === 'belum_lunas')
                                            <span class="badge bg-danger">Belum Lunas</span>
                                        @elseif ($nota->status === 'lunas')
                                            <span class="badge bg-success">Lunas</span>
                                        @endif
                                    </td>
                                    @foreach ($nota->item_nota as $index => $item)
                                        @if ($index > 0)
                                            <tr>
                                        @endif
                                        <td>{{ $item->nama_produk }}</td>
                                        <td class="text-end">{{ number_format($item->qty, 0, ',', '.') }}</td>
                                        <td class="text-end">{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                        <td class="text-end">{{ number_format($item->qty * $item->harga_satuan, 0, ',', '.') }}</td>
                                        @if ($index == 0)
                                            <td rowspan="{{ count($nota->item_nota) }}" class="text-end">{{ number_format($nota->total_nota, 0, ',', '.') }}</td>
                                            <td rowspan="{{ count($nota->item_nota) }}">{{ $nota->keterangan }}</td>
                                            <td rowspan="{{ count($nota->item_nota) }}" class="text-center">
                                                <a href="/editNota/{{ $nota->id_nota }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                                <a href="/hapusNota/{{ $nota->id_nota }}" class="btn btn-sm btn-outline-danger">Hapus</a>
                                            </td>
                                        @endif
                                        </tr>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="notaBelumLunas" role="tabpanel" aria-labelledby="notaBelumLunas-tab">
                <div class="mt-3">
                    <h5>Daftar Nota Lunas</h5>
                    <table class="table table-bordered table-striped table-sm border border-dark align-middle mt-3">
                        <thead class="text-center align-middle">
                            <tr>
                                <th rowspan="2">Jenis Nota</th>
                                <th rowspan="2">Tanggal Nota</th>
                                <th rowspan="2">Nama Pelanggan</th>
                                <th rowspan="2">Status</th>
                                <th colspan="4">Item</th>
                                <th rowspan="2">Total</th>
                                <th rowspan="2">keterangan</th>
                                <th rowspan="2">Aksi</th>
                            </tr>
                            <tr>
                                <th>Nama Produk</th>
                                <th>qty</th>
                                <th>harga Satuan</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notalunas as $item)
                            <tr>
                                <td rowspan="{{ count($item->item_nota) }}" class="text-center">
                                    @if ($item->jenis_nota === 'nota_cash')
                                        Cash
                                    @elseif ($item->jenis_nota === 'nota_noncash')
                                        Non-Cash
                                    @endif
                                </td>
                                <td rowspan="{{ count($item->item_nota) }}">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                <td rowspan="{{ count($item->item_nota) }}">{{ $item->nama_toko }}</td>
                                <td rowspan="{{ count($item->item_nota) }}" class="text-center">
                                    @if ($item->status === 'belum_lunas')
                                        <span class="badge bg-danger">Belum Lunas</span>
                                    @elseif ($item->status === 'lunas')
                                        <span class="badge bg-success">Lunas</span>
                                    @endif
                                </td>
                                @foreach ($item->item_nota as $index => $item_nota)
                                    @if ($index > 0)
                                        <tr>
                                    @endif
                                    <td>{{ $item_nota->nama_produk }}</td>
                                    <td class="text-end">{{ number_format($item_nota->qty, 0, ',', '.') }}</td>
                                    <td class="text-end">{{ number_format($item_nota->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="text-end">{{ number_format($item_nota->qty * $item_nota->harga_satuan, 0, ',', '.') }}</td>
                                    @if ($index == 0)
                                        <td rowspan="{{ count($item->item_nota) }}" class="text-end">{{ number_format($item->total_nota, 0, ',', '.') }}</td>
                                        <td rowspan="{{ count($item->item_nota) }}">{{ $item->keterangan }}</td>
                                        <td rowspan="{{ count($item->item_nota) }}" class="text-center">
                                            <a href="/editNota/{{ $item->id_nota }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                            <a href="/hapusNota/{{ $item->id_nota }}" class="btn btn-sm btn-outline-danger">Hapus</a>
                                        </td>
                                    @endif
                                    </tr>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addNotaModal" tabindex="-1" aria-labelledby="addNotaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNotaModalLabel">Tambah Nota Harga Pabrik</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="notaForm" action="/admin/TambahNotaHargaPabrik" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="tanggalNota" class="form-label">Tanggal Nota</label>
                            <input type="date" class="form-control" id="tanggalNota" name="tanggalNota" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenisNota" class="form-label">Jenis Nota</label>
                            <select class="form-select" id="jenisNota" name="jenisNota" required>
                                <option value="" disabled selected>Pilih Jenis Nota</option>
                                <option value="nota_cash">Cash</option>
                                <option value="nota_noncash">Non-Cash</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="namaPelanggan" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="namaPelanggan" name="namaPelanggan" required>
                        </div>
                        <div class="mb-3">
                            <label for="oleh" class="form-label">Oleh</label>
                            <input type="text" class="form-control" id="oleh" name="oleh" required>
                        </div>
                        <div class="mb-3">
                            <label for="produk" class="form-label">Produk</label>
                            <div id="produkContainer">
                                <div class="row mb-2 produk-item">
                                    <div class="col-md-6">
                                        <select class="form-select" name="produk[]" required>
                                            <option value="" disabled selected>Pilih Produk</option>
                                            @foreach ($produks as $produk)
                                                <option value="{{ $produk->id_produk }}">{{ $produk->nama_produk }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" class="form-control" name="jumlah[]" placeholder="Jumlah" required>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm remove-produk">hapus</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success btn-sm mt-2" id="addProduk">+ Tambah Produk</button>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

                <script>
                    document.getElementById('addProduk').addEventListener('click', function () {
                        const produkContainer = document.getElementById('produkContainer');
                        const newProduk = document.createElement('div');
                        newProduk.classList.add('row', 'mb-2', 'produk-item');
                        newProduk.innerHTML = `
                            <div class="col-md-6">
                                <select class="form-select" name="produk[]" required>
                                    <option value="" disabled selected>Pilih Produk</option>
                                    @foreach ($produks as $produk)
                                        <option value="{{ $produk->id_produk }}">{{ $produk->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" class="form-control" name="jumlah[]" placeholder="Jumlah" required>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-sm remove-produk">hapus</button>
                            </div>
                        `;
                        produkContainer.appendChild(newProduk);
                    });

                    document.getElementById('produkContainer').addEventListener('click', function (e) {
                        if (e.target.classList.contains('remove-produk')) {
                            e.target.closest('.produk-item').remove();
                        }
                    });
                </script>
            </div>
        </div>
    </div>

    <!-- Modal for Nota Pemasaran -->
    <div class="modal fade" id="addNotaPemasaranModal" tabindex="-1" aria-labelledby="addNotaPemasaranModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNotaPemasaranModalLabel">Tambah Nota Pemasaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="notaPemasaranForm" action="/admin/TambahNotaPemasaran" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="tanggalNotaPemasaran" class="form-label">Tanggal Nota</label>
                            <input type="date" class="form-control" id="tanggalNotaPemasaran" name="tanggalNotaPemasaran" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenisNotaPemasaran" class="form-label">Jenis Nota</label>
                            <select class="form-select" id="jenisNotaPemasaran" name="jenisNotaPemasaran" required>
                                <option value="" disabled selected>Pilih Jenis Nota</option>
                                <option value="nota_cash">Cash</option>
                                <option value="nota_noncash">Non-Cash</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="namaPelangganPemasaran" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="namaPelangganPemasaran" name="namaPelangganPemasaran" required>
                        </div>
                        <div class="mb-3">
                            <label for="oleh" class="form-label">Oleh</label>
                            <input type="text" class="form-control" id="oleh" name="oleh" required>
                        </div>
                        <div class="mb-3">
                            <label for="produkPemasaran" class="form-label">Produk</label>
                            <div id="produkPemasaranContainer">
                                <div class="row mb-2 produk-item">
                                    <div class="col-md-4">
                                        <select class="form-select" name="produk[]" required>
                                            <option value="" disabled selected>Pilih Produk</option>
                                            @foreach ($produks as $produk)
                                                <option value="{{ $produk->id_produk }}">{{ $produk->nama_produk }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" class="form-control" name="jumlah[]" placeholder="Jumlah" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" class="form-control" name="harga_satuan[]" placeholder="Harga Satuan" required>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm remove-produk">hapus</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success btn-sm mt-2" id="addProdukPemasaran">+ Tambah Produk</button>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

                <script>
                    document.getElementById('addProdukPemasaran').addEventListener('click', function () {
                        const produkContainer = document.getElementById('produkPemasaranContainer');
                        const newProduk = document.createElement('div');
                        newProduk.classList.add('row', 'mb-2', 'produk-item');
                        newProduk.innerHTML = `
                            <div class="col-md-4">
                                <select class="form-select" name="produk[]" required>
                                    <option value="" disabled selected>Pilih Produk</option>
                                    @foreach ($produks as $produk)
                                        <option value="{{ $produk->id_produk }}">{{ $produk->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control" name="jumlah[]" placeholder="Jumlah" required>
                            </div>
                            <div class="col-md-3">
                                <input type="number" class="form-control" name="harga_satuan[]" placeholder="Harga Satuan" required>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-sm remove-produk">hapus</button>
                            </div>
                        `;
                        produkContainer.appendChild(newProduk);
                    });

                    document.getElementById('produkPemasaranContainer').addEventListener('click', function (e) {
                        if (e.target.classList.contains('remove-produk')) {
                            e.target.closest('.produk-item').remove();
                        }
                    });
                </script>
            </div>
        </div>
    </div>

    
</x-layout-admin>
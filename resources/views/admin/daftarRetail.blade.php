<x-layout-admin>
    <x-slot:title>Daftar Retail</x-slot>
    <x-slot:tabs>Daftar Retail</x-slot>

    <!-- Button to Open Modal -->
    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addRetailModal">
        Tambah Retail
    </button>

    <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped table-sm border border-dark align-middle mt-3">
            <thead class="text-center align-middle">
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Tanggal</th>
                    <th rowspan="2">Nama Pelanggan</th>
                    <th colspan="4">Item Nota</th>
                    <th rowspan="2">Total</th>
                    <th rowspan="2">Aksi</th>
                </tr>
                <tr>
                    <th>Nama Produk</th>
                    <th>qty</th>
                    <th>harga Satuan</th>
                    <th>jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notaretail as $item)
                    <tr>
                        <td rowspan="{{ count($item->item_nota) }}" class="text-center">{{ $loop->iteration }}</td>
                        <td rowspan="{{ count($item->item_nota) }}">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                        <td rowspan="{{ count($item->item_nota) }}">{{ $item->nama_toko }}</td>
                        @foreach ($item->item_nota as $index => $product)
                            @if ($index > 0)
                                <tr>
                            @endif
                            <td>{{ $product->nama_produk }}</td>
                            <td class="text-end">{{ $product->qty }}</td>
                            <td class="text-end">{{ number_format($product->harga_satuan, 0, ',', '.') }}</td>
                            <td class="text-end">{{ number_format($product->qty * $product->harga_satuan, 0, ',', '.') }}</td>
                            @if ($index == 0)
                                <td rowspan="{{ count($item->item_nota) }}" class="text-end">{{ number_format($item->total_nota, 0, ',', '.') }}</td>
                                <td rowspan="{{ count($item->item_nota) }}" class="text-center">
                                    <a href="/editNota/{{ $item->id_nota }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <a href="/hapusRetail/{{ $item->id_nota }}" class="btn btn-sm btn-outline-danger">Hapus</a>
                                </td>
                            @endif
                            </tr>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addRetailModal" tabindex="-1" aria-labelledby="addRetailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRetailModalLabel">Tambah Retail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addRetailForm" action="/user/admin/tambahretail" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                        <div class="mb-3">
                            <label for="namaPelanggan" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="namaPelanggan" name="namaPelanggan" required>
                        </div>
                        <div class="mb-3">
                            <label for="itemProduk" class="form-label">Item Produk</label>
                            <div id="itemProdukContainer">
                                <div class="input-group mb-2">
                                    <select class="form-select" name="itemProduk[]" required>
                                        <option value="" disabled selected>Pilih Produk</option>
                                        @foreach ($produks as $produk)
                                            <option value="{{ $produk->id_produk }}">{{ $produk->nama_produk }}</option>
                                        @endforeach
                                    </select>
                                    <input type="number" class="form-control" name="jumlahProduk[]" placeholder="Jumlah" min="0" step="0.01" required>
                                    <input type="number" class="form-control" name="hargaSatuan[]" placeholder="Harga Satuan" min="0" step="0.01" required>
                                    <button type="button" class="btn btn-danger remove-item">Hapus</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success" id="addItem">+ Tambah Item</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" form="addRetailForm">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('addItem').addEventListener('click', function () {
            const container = document.getElementById('itemProdukContainer');
            const newItem = document.createElement('div');
            newItem.classList.add('input-group', 'mb-2');
            newItem.innerHTML = `
                <select class="form-select" name="itemProduk[]" required>
                    <option value="" disabled selected>Pilih Produk</option>
                    @foreach ($produks as $produk)
                        <option value="{{ $produk->id_produk }}">{{ $produk->nama_produk }}</option>
                    @endforeach
                </select>
                <input type="number" class="form-control" name="jumlahProduk[]" placeholder="Jumlah" min="0" step="0.01" required>
                <input type="number" class="form-control" name="hargaSatuan[]" placeholder="Harga Satuan" min="0" step="0.01" required>
                <button type="button" class="btn btn-danger remove-item">Hapus</button>
            `;
            container.appendChild(newItem);
        });

        document.getElementById('itemProdukContainer').addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-item')) {
                e.target.parentElement.remove();
            }
        });
    </script>
</x-layout-admin>
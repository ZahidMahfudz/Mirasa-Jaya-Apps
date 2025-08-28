<x-layout-admin>
    <x-slot:title>Edit Nota {{ $nota->id_nota }}</x-slot>
    <x-slot:tabs>Edit Nota {{ $nota->id_nota }}</x-slot>

    <form id="notaPemasaranForm" action="/editNotaRev/{{ $nota->id_nota }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="tanggalNotaPemasaran" class="form-label">Tanggal Nota</label>
            <input type="date" class="form-control" id="tanggalNotaPemasaran" name="tanggalNotaPemasaran" value="{{ $nota->tanggal }}" required>
        </div>
        <div class="mb-3">
            <label for="jenisNotaPemasaran" class="form-label">Jenis Nota</label>
            <select class="form-select" id="jenisNotaPemasaran" name="jenisNotaPemasaran" required>
                <option value="" disabled>Pilih Jenis Nota</option>
                <option value="nota_cash" {{ $nota->jenis_nota == 'nota_cash' ? 'selected' : '' }}>Cash</option>
                <option value="nota_noncash" {{ $nota->jenis_nota == 'nota_noncash' ? 'selected' : '' }}>Non-Cash</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="namaPelangganPemasaran" class="form-label">Nama Pelanggan</label>
            <input type="text" class="form-control" id="namaPelangganPemasaran" name="namaPelangganPemasaran" value="{{ $nota->nama_toko }}" required>
        </div>
        <div class="mb-3">
            <label for="keteranganNotaPemasaran" class="form-label">Keterangan</label>
            <textarea class="form-control" id="keteranganNotaPemasaran" name="keteranganNotaPemasaran" rows="3">{{ $nota->keterangan }}</textarea>
        </div>
        
        <button type="button" class="btn btn-success btn-sm mt-2" id="addProdukPemasaran">+ Tambah Produk</button>
        <div id="produkPemasaranContainer" class="mt-3"></div>
        <div class="modal-footer mt-4">
            @if ($nota->status != 'lunas')
                <a href="/admin/UbahStatusNota/{{ $nota->id_nota }}" class="btn btn-success me-2">Ubah Status ke Lunas</a>
            @endif
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
    
    <div class="mb-3">
        <label for="itemNotaPemasaran" class="form-label">Item Nota</label>
        <table class="table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nota->item_nota as $item)
                    <tr>
                        <td>{{ $item->nama_produk }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->harga_satuan }}</td>
                        <td>{{ $item->qty * $item->harga_satuan }}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editItemModal{{ $item->id_item_nota }}">Edit</button>
                            <a href="/admin/HapusItemNota/{{ $item->id_item_nota }}" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="editItemModal{{ $item->id_item_nota }}" tabindex="-1" aria-labelledby="editItemModalLabel{{ $item->id_item_nota }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="/admin/EditItemNota/{{ $item->id_item_nota }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editItemModalLabel{{ $item->id_item_nota }}">Edit Item Nota</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="namaProduk{{ $item->id_item_nota }}" class="form-label">Nama Produk</label>
                                            <select class="form-select" id="namaProduk{{ $item->id_item_nota }}" name="nama_produk" required>
                                                <option value="" disabled selected>Pilih Produk</option>
                                                @foreach ($produks as $produk)
                                                    <option value="{{ $produk->nama_produk }}" {{ $item->nama_produk == $produk->nama_produk ? 'selected' : '' }}>
                                                        {{ $produk->nama_produk }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="qty{{ $item->id_item_nota }}" class="form-label">Jumlah</label>
                                            <input type="number" class="form-control" id="qty{{ $item->id_item_nota }}" name="qty" value="{{ $item->qty }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="hargaSatuan{{ $item->id_item_nota }}" class="form-label">Harga Satuan</label>
                                            <input type="number" class="form-control" id="hargaSatuan{{ $item->id_item_nota }}" name="harga_satuan" value="{{ $item->harga_satuan }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
                    
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    {{-- <div class="modal fade" id="editItemModal{{ $item->id_item_nota }}" tabindex="-1" aria-labelledby="editItemModalLabel{{ $item->id_item_nota }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/admin/EditItemNota/{{ $item->id_item_nota }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="editItemModalLabel{{ $item->id_item_nota }}">Edit Item Nota</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="namaProduk{{ $item->id_item_nota }}" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="namaProduk{{ $item->id_item_nota }}" name="nama_produk" value="{{ $item->nama_produk }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="qty{{ $item->id_item_nota }}" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="qty{{ $item->id_item_nota }}" name="qty" value="{{ $item->qty }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="hargaSatuan{{ $item->id_item_nota }}" class="form-label">Harga Satuan</label>
                            <input type="number" class="form-control" id="hargaSatuan{{ $item->id_item_nota }}" name="harga_satuan" value="{{ $item->harga_satuan }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

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
</x-layout-admin>
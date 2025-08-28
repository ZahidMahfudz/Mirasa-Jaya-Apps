<x-layout-admin>
    <x-slot:title>Harga Produk</x-slot>
    <x-slot:tabs>Manager-Harga Produk</x-slot>

    <div class="mt-2">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahProduk">Tambah Produk</button>
    </div>
    <div class="mt-3">
        <table class="table table-bordered table-striped table-sm border border-dark align-middle">
            <thead>
                <tr>
                    <th style="width: 3%;">No</th>
                    <th>Nama Produk</th>
                    <th>Jenis Kardus</th>
                    <th>Harga Satuan</th>
                    <th style="width: 9%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nama_produk }}</td>
                        <td>{{ $item->jenis_kardus }}</td>
                        <td style="text-align: right;">{{ number_format($item->harga_satuan) }}</td>
                        <td>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editProduk-{{ $item->id_produk }}">Edit</button>
                            <div class="modal fade" id="editProduk-{{ $item->id_produk }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Edit Produk {{ $item->nama_produk }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="/editproduk/{{ $item->id_produk }}" method="post">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="nama_produk" class="form-label">Nama Produk :</label>
                                                    <input type="text" name="nama_produk" class="form-control" value="{{ $item->nama_produk }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="harga_satuan" class="form-label">Harga Satuan:</label>
                                                    <input type="number" name="harga_satuan" class="form-control" value="{{ $item->harga_satuan }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jenis_kardus" class="form-label">Jenis Kardus:</label>
                                                    <select name="jenis_kardus" class="form-select">
                                                        <option value="{{ $item->jenis_kardus }}" selected>{{ $item->jenis_kardus }}</option>
                                                        @foreach ($kardus as $karduse)
                                                            @if ($karduse->nama_bahan != $item->jenis_kardus)
                                                                <option value="{{ $karduse->nama_bahan }}">{{ $karduse->nama_bahan }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
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
                            <a href="/delete/{{ $item->id_produk }}" 
                                class="btn btn-danger" 
                                onclick="return confirm('Apakah Anda yakin ingin menghapus produk {{ $item->nama_produk }}?')">Hapus</a>
                             
                        </td>
                    </tr>
    
    
                @endforeach
            </tbody>
        </table>
    </div>
    
      <!-- Modal -->
            <div class="modal fade" id="tambahProduk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="tambahproduk" method="POST">
                                    @csrf
                                    <div>
                                        <label for="nama_produk" class="form-label">Nama Produk :</label>
                                        <input type="text" name="nama_produk" id="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror" value="{{ old('nama_produk') }}">
                                        @error('nama_produk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="harga_satuan" class="form-label">Harga Satuan:</label>
                                        <input type="number" name="harga_satuan" id="harga_satuan" class="form-control  @error('harga_satuan') is-invalid @enderror" value="{{ old('harga_satuan') }}">
                                        @error('harga_satuan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                            <label for="jenis_kardus" class="form-label">Jenis Kardus:</label>
                                            <select name="jenis_kardus" class="form-select">        
                                                <option value="" disabled {{ old('jenis_kardus') ? '' : 'selected' }}>-- Pilih Kardus --</option>      
                                                @foreach ($kardus as $karduse)
                                                    <option value="{{ $item->jenis_kardus }}">
                                                        {{ $karduse->nama_bahan }}
                                                    </option>
                                                @endforeach
                                            </select>
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
    
</x-layout-admin>

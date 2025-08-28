<x-layout-manager>
    
    <x-slot:title>Drop Out</x-slot>
    <x-slot:tabs>manager - Drop Out</x-slot>

    <div>
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahDO">Tambah Drop Out</button>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="dropoutproses-tab" data-bs-toggle="tab" data-bs-target="#dropoutproses"
                        type="button" role="tab" aria-controls="dropoutproses" aria-selected="false">Proses</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="dropoutdiambil-tab" data-bs-toggle="tab" data-bs-target="#dropoutdiambil"
                        type="button" role="tab" aria-controls="dropoutdiambil" aria-selected="false">Selesai</button>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="dropoutproses" role="tabpanel" aria-labelledby="dropoutproses-tab">
                    <div class="mt-1">
                        <div>
                            @if($dropoutproses->isEmpty())
                                <p class="text-center">Tidak ada drop out yang diproses</p>
                            @else
                                <table class="table table-bordered table-sm border border-dark align-middle mt-2">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center; vertcal-align: middle; width: 8%;">Status</th>
                                            <th style="text-align: center; width: 7%; vertcal-align: middle;">Tanggal</th>
                                            <th style="text-align: center; width: 15%; vertcal-align: middle;">Nama Pengambil</th>
                                            <th style="text-align: center; vertcal-align: middle;" >Nama Barang</th>
                                            <th style="text-align: center; vertcal-align: middle; width: 7%;">Jumlah Barang</th>
                                            <th style="text-align: center; vertcal-align: middle; width: 10%;" colspan="2">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dropoutproses as $index => $dropoutItem)
                                            @foreach ($dropoutItem->ListDropOut as $listIndex => $listdropout)
                                                <tr>
                                                    @if ($listIndex == 0)
                                                        @if ($dropoutItem->status == 'proses')
                                                            <td style="text-align: center;" rowspan="{{ $dropoutItem->ListDropOut->count() +2 }} "><span class="badge rounded-pill bg-danger">{{ $dropoutItem->status }}</span></td>
                                                        @endif
                                                        <td rowspan="{{ $dropoutItem->ListDropOut->count() +2 }}">{{ \Carbon\Carbon::parse($dropoutItem->tanggal)->format('d/m/Y') }}</td>
                                                        <td rowspan="{{ $dropoutItem->ListDropOut->count() +2 }}">{{ $dropoutItem->nama_pengambil }}</td>
                                                    @endif
                                                    <td>{{ $listdropout->nama_barang }}</td>
                                                    <td style="text-align: right;">{{ $listdropout->jumlah_barang }}</td>
                                                    <td>
                                                        <a href="hapusListDO/{{ $listdropout->id }}" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    </td>
                                                    @if ($listIndex == 0)
                                                        <td rowspan="{{ $dropoutItem->ListDropOut->count() + 2 }}" style="text-align: center;">
                                                            <a href="cetakDropOut/{{ $dropoutItem->id }}" class="btn btn-secondary me-2 mb-2" target="blank_">Selesai & Cetak</a>
                                                            <button class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#editdropout{{ $dropoutItem->id }}">Edit</button>
                                                        </td>
                                                        <div class="modal fade" id="editdropout{{ $dropoutItem->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                    <h5 class="modal-title" id="staticBackdropLabel">Edit Drop Out</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="editdropout/{{ $dropoutItem->id }}" method="post">
                                                                                @csrf
                                                                                <div class="mt-2">
                                                                                    <label for="tanggal_hari_ini" class="form-label">Tanggal Hari Ini :</label>
                                                                                    <input type="date" name="tanggal_hari_ini" id="tanggal_hari_ini" class="form-control" value="{{ $dropoutItem->tanggal }}" disabled>
                                                                                </div>
                                                                                <div class="mt-2">
                                                                                    <label for="nama_seller" class="form-label">Nama Seller:</label>
                                                                                    <input type="text" name="nama_seller" id="nama_seller" class="form-control  @error('nama_seller') is-invalid @enderror" value="{{ $dropoutItem->nama_pengambil }}">
                                                                                    @error('nama_seller')
                                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="row mt-2">
                                                                                    <div class="col-md-6">
                                                                                        <label for="produk" class="form-label">Produk:</label>
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <label for="jumlah" class="form-label">Jumlah:</label>
                                                                                    </div>
                                                                                </div>
                                                                                @foreach ($dropoutItem->ListDropOut as $listIndex => $listdropout)
                                                                                    <div class="row mb-2">
                                                                                        <div class="col-md-6">
                                                                                            {{-- <label for="produk" class="form-label">Produk:</label> --}}
                                                                                            <select name="nama_produk[]" class="form-select">
                                                                                                <option value="" disabled selected>Pilih Produk</option>
                                                                                                @foreach ($produk as $produklist)
                                                                                                    <option value="{{ $produklist->nama_produk }}" {{ $listdropout->nama_barang == $produklist->nama_produk ? 'selected' : '' }}>{{ $produklist->nama_produk }}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            {{-- <label for="jumlah" class="form-label">Jumlah:</label> --}}
                                                                                            <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" value="{{ $listdropout->jumlah_barang }}">
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                                <div class="modal-footer mt-5">
                                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                                                </div>
                                                                        </form>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td style="text-align: right;"><strong>Total:</strong></td>
                                                <td style="text-align: right;"><strong>{{ $dropoutItem->ListDropOut->sum('jumlah_barang') }}</strong></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahlistDO{{ $dropoutItem->id }}">Tambah List Produk</button>
                                                </td>
                                                <div class="modal fade" id="tambahlistDO{{ $dropoutItem->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                            <h5 class="modal-title" id="staticBackdropLabel">Tambah Produk</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="addlistDO/{{ $dropoutItem->id }}" method="post">
                                                                        @csrf
                                                                        <div class="row mt-2 mb-2">
                                                                            <div class="col-md-6">
                                                                                <label for="product_name" class="form-label">Produk:</label>
                                                                                <select name="product_name" class="form-select">
                                                                                    <option value="" selected>Pilih Produk</option>
                                                                                    @foreach ($produk as $produklist)
                                                                                        <option value="{{ $produklist->nama_produk }}">{{ $produklist->nama_produk }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <label for="qty" class="form-label">Jumlah:</label>
                                                                                <input type="number" name="qty" class="form-control" placeholder="Jumlah">
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer mt-5">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                                        </div>
                                                                </form>
                                                            </div>
                                                    </div>
                                                </div>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="dropoutdiambil" role="tabpanel" aria-labelledby="dropoutdiambil-tab">
                    <div class="mt-2">
                        <div>
                            @if ($dropoutdiambil->isEmpty())
                                <p class="text-center">Tidak ada drop out yang sudah selesai</p>
                            @else
                                <table class="table table-bordered table-sm border border-dark align-middle">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center; vertcal-align: middle; width: 8%;">Status</th>
                                            <th style="text-align: center; width: 7%; vertcal-align: middle;">Tanggal</th>
                                            <th style="text-align: center; width: 15%; vertcal-align: middle;">Nama Pengambil</th>
                                            <th style="text-align: center; vertcal-align: middle;" >Nama Barang</th>
                                            <th style="text-align: center; vertcal-align: middle; width: 7%;">Jumlah Barang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dropoutdiambil as $index => $dropoutItem)
                                            @foreach ($dropoutItem->ListDropOut as $listIndex => $listdropout)
                                                <tr>
                                                    @if ($listIndex == 0)
                                                        @if ($dropoutItem->status == 'diambil')
                                                            <td style="text-align: center;" rowspan="{{ $dropoutItem->ListDropOut->count() +1 }} "><span class="badge rounded-pill bg-success">{{ $dropoutItem->status }}</span></td>
                                                        @endif
                                                        <td rowspan="{{ $dropoutItem->ListDropOut->count() +1 }}">{{ \Carbon\Carbon::parse($dropoutItem->tanggal)->format('d/m/Y') }}</td>
                                                        <td rowspan="{{ $dropoutItem->ListDropOut->count() +1 }}">{{ $dropoutItem->nama_pengambil }}</td>
                                                    @endif
                                                    <td>{{ $listdropout->nama_barang }}</td>
                                                    <td style="text-align: right;">{{ $listdropout->jumlah_barang }}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td style="text-align: right;"><strong>Total:</strong></td>
                                                <td style="text-align: right;"><strong>{{ $dropoutItem->ListDropOut->sum('jumlah_barang') }}</strong></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambahDO" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Drop Out</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="tambahDO" method="post">
                            @csrf
                            <div class="mt-2">
                                <label for="tanggal_hari_ini" class="form-label">Tanggal Hari Ini :</label>
                                <input type="date" name="tanggal_hari_ini" id="tanggal_hari_ini" class="form-control" value="{{ \Carbon\Carbon::now()->toDateString() }}" disabled>
                            </div>
                            <div class="mt-2">
                                <label for="nama_seller" class="form-label">Nama Seller:</label>
                                <input type="text" name="nama_seller" id="nama_seller" class="form-control  @error('nama_seller') is-invalid @enderror" value="{{ old('nama_seller') }}">
                                @error('nama_seller')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row mt-2 mb-2">
                                <div class="col-md-6">
                                    <label for="produk" class="form-label">Produk:</label>
                                    <select name="nama_produk[]" class="form-select">
                                        <option value="" disabled selected>Pilih Produk</option>
                                        @foreach ($produk as $produklist)
                                            <option value="{{ $produklist->nama_produk }}">{{ $produklist->nama_produk }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="jumlah" class="form-label">Jumlah:</label>
                                    <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah">
                                </div>
                            </div>
                            <div id="produk-container-tambah"></div>
                            <button type="button" class="btn btn-outline-secondary mt-2" onclick="tambahProduk()">Tambah Produk</button>

                            <script>
                                const produkOptionsTambah = `
                                    @foreach ($produk as $produkItem)
                                        <option value="{{ $produkItem->nama_produk }}">{{ $produkItem->nama_produk }}</option>
                                    @endforeach
                                `;
                            </script>
                            <script>
                                function tambahProduk() {
                                    const container = document.getElementById('produk-container-tambah');
                                    const newProduk = document.createElement('div');
                                    newProduk.classList.add('row', 'mt-2');
                                    newProduk.innerHTML = `
                                        <div class="col-md-6">
                                            <select name="nama_produk[]" class="form-select">
                                                <option value="" disabled selected>Pilih Produk</option>
                                                ${produkOptionsTambah}
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah">
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-outline-danger" onclick="removeProduk(this)">Hapus</button>
                                        </div>
                                    `;
                                    container.appendChild(newProduk);
                                }

                                function removeProduk(button) {
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

    
</x-layout-manager>
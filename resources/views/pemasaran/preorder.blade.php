<x-layout-pemasaran>
    <x-slot:title>Pre Order</x-slot>
    <x-slot:tabs>Pemasaran - Pre Order</x-slot>

    <div class="mt-2">
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addpreorder">Tambah Order</button>
    </div>

    <div class="modal fade" id="addpreorder" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="addpreorderLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addpreorderLabel">Tambah Order</h5>
                </div>
                <div class="modal-body">
                    <form action="addorder" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_pemesan" class="form-label">Nama Pemesan</label>
                            <input type="text" name="nama_pemesan" id="nama_pemesan" class="form-control" value="{{ Auth::user()->name }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_pesanan" class="form-label">Untuk Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="produk" class="form-label">Produk</label>
                            <div id="produk-container">
                                <div class="input-group mb-2">
                                    <select name="nama_produk[]" class="form-select" required>
                                        <option value="" disabled selected>Pilih Produk</option>
                                        @foreach ($produk as $produkItem)
                                            <option value="{{ $produkItem->nama_produk }}">{{ $produkItem->nama_produk }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="jumlah_barang[]" class="form-control" placeholder="(jumlah)" step="0.001" required>
                                    <button type="button" class="btn btn-danger remove-produk">Hapus</button>
                                </div>
                            </div>
                            <button type="button" id="add-bahan" class="btn btn-secondary">Tambah Produk</button>
                        </div>
                        <script>
                            document.getElementById('add-bahan').addEventListener('click', function () {
                                var produkContainer = document.getElementById('produk-container');
                                var newProduk = document.createElement('div');
                                newProduk.classList.add('input-group', 'mb-2');
                                newProduk.innerHTML = `
                                    <select name="nama_produk[]" class="form-select" required>
                                        <option value="" disabled selected>Pilih Produk</option>
                                        @foreach ($produk as $produkItem)
                                            <option value="{{ $produkItem->nama_produk }}">{{ $produkItem->nama_produk }}</option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="jumlah_barang[]" class="form-control" placeholder="(jumlah)" step="0.001" required>
                                    <button type="button" class="btn btn-danger remove-produk">Hapus</button>
                                `;
                                produkContainer.appendChild(newProduk);
                            });

                            document.getElementById('produk-container').addEventListener('click', function (e) {
                                if (e.target.classList.contains('remove-produk')) {
                                    e.target.parentElement.remove();
                                }
                            });
                        </script>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Pesanan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h4>Detail order {{ Auth::user()->name }}</h4>
            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="preorderpending-tab" data-bs-toggle="tab" data-bs-target="#preorderpending"
                        type="button" role="tab" aria-controls="preorderpending" aria-selected="false">Pending</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="preorderproses-tab" data-bs-toggle="tab" data-bs-target="#preorderproses"
                        type="button" role="tab" aria-controls="preorderproses" aria-selected="false">Proses</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="preorderselesai-tab" data-bs-toggle="tab" data-bs-target="#preorderselesai"
                        type="button" role="tab" aria-controls="preorderselesai" aria-selected="false">Selesai</button>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="preorderpending" role="tabpanel" aria-labelledby="bahanbaku-tab">
                    <div class="mt-1">
                        <div>
                            @if($orderpending->isEmpty())
                                <p class="text-center">Tidak ada order</p>
                            @else
                                <table class="table table-bordered table-sm border border-dark align-middle mt-1">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 2%;">No</th>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 10%;">Untuk Tanggal</th>
                                            <th colspan="2" style="text-align: center; vertical-align: middle;">Detail Order</th>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 10%;">Status</th>
                                        </tr>
                                        <tr>
                                            <th style="text-align: center; vertical-align: middle;">Nama Barang</th>
                                            <th style="text-align: center; vertical-align: middle;">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderpending as $index => $orderItem)
                                            @foreach ($orderItem->detailOrder as $listIndex => $listOrder)
                                                <tr>
                                                    @if ($listIndex == 0)
                                                        <td rowspan="{{ count($orderItem->detailOrder) }}" style="text-align: center;">{{ $index + 1 }}</td>
                                                        <td rowspan="{{ count($orderItem->detailOrder) }}" style="text-align: center;">{{ \Carbon\Carbon::parse($orderItem->tanggal_selesai)->format('d/m/Y') }}</td>
                                                    @endif
                                                    <td>{{ $listOrder->nama_barang }}</td>
                                                    <td style="text-align: right;">{{ $listOrder->jumlah_barang }}</td>
                                                    @if ($listIndex == 0)
                                                        <td style="text-align: center;" rowspan="{{ count($orderItem->detailOrder) }} "><span class="badge rounded-pill bg-danger">{{ $orderItem->status }}</span></td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="preorderproses" role="tabpanel" aria-labelledby="bahanpenolong-tab">
                    <div class="mt-2">
                        <div>
                            @if ($orderproses->isEmpty())
                                <p class="text-center">Tidak ada order yang diproses</p>
                            @else
                            <table class="table table-bordered table-sm border border-dark align-middle mt-1">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="text-align: center; vertical-align: middle; width: 2%;">No</th>
                                        <th rowspan="2" style="text-align: center; vertical-align: middle; width: 10%;">Untuk Tanggal</th>
                                        <th colspan="2" style="text-align: center; vertical-align: middle;">Detail Order</th>
                                        <th rowspan="2" style="text-align: center; vertical-align: middle; width: 10%;">Status</th>
                                    </tr>
                                    <tr>
                                        <th style="text-align: center; vertical-align: middle;">Nama Barang</th>
                                        <th style="text-align: center; vertical-align: middle;">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orderproses as $index => $orderItem)
                                        @foreach ($orderItem->detailOrder as $listIndex => $listOrder)
                                            <tr>
                                                @if ($listIndex == 0)
                                                    <td rowspan="{{ count($orderItem->detailOrder) }}" style="text-align: center;">{{ $index + 1 }}</td>
                                                    <td rowspan="{{ count($orderItem->detailOrder) }}" style="text-align: center;">{{ \Carbon\Carbon::parse($orderItem->tanggal_selesai)->format('d/m/Y') }}</td>
                                                @endif
                                                <td>{{ $listOrder->nama_barang }}</td>
                                                <td style="text-align: right;">{{ $listOrder->jumlah_barang }}</td>
                                                @if ($listIndex == 0)
                                                    <td style="text-align: center;" rowspan="{{ count($orderItem->detailOrder) }} "><span class="badge rounded-pill bg-secondary">{{ $orderItem->status }}</span></td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="preorderselesai" role="tabpanel" aria-labelledby="wip-tab">
                    <div class="mt-2">
                        <div>
                            @if ($orderselesai->isEmpty())
                                <p class="text-center">Tidak ada order selesai</p>
                            @else
                            <table class="table table-bordered table-sm border border-dark align-middle mt-1">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="text-align: center; vertical-align: middle; width: 2%;">No</th>
                                        <th rowspan="2" style="text-align: center; vertical-align: middle; width: 10%;">Untuk Tanggal</th>
                                        <th colspan="2" style="text-align: center; vertical-align: middle;">Detail Order</th>
                                        <th rowspan="2" style="text-align: center; vertical-align: middle; width: 10%;">Status</th>
                                    </tr>
                                    <tr>
                                        <th style="text-align: center; vertical-align: middle;">Nama Barang</th>
                                        <th style="text-align: center; vertical-align: middle;">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orderselesai as $index => $orderItem)
                                        @foreach ($orderItem->detailOrder as $listIndex => $listOrder)
                                            <tr>
                                                @if ($listIndex == 0)
                                                    <td rowspan="{{ count($orderItem->detailOrder) }}" style="text-align: center;">{{ $index + 1 }}</td>
                                                    <td rowspan="{{ count($orderItem->detailOrder) }}" style="text-align: center;">{{ \Carbon\Carbon::parse($orderItem->tanggal_selesai)->format('d/m/Y') }}</td>
                                                @endif
                                                <td>{{ $listOrder->nama_barang }}</td>
                                                <td style="text-align: right;">{{ $listOrder->jumlah_barang }}</td>
                                                @if ($listIndex == 0)
                                                    <td style="text-align: center;" rowspan="{{ count($orderItem->detailOrder) }} "><span class="badge rounded-pill bg-success">{{ $orderItem->status }}</span></td>
                                                @endif
                                            </tr>
                                        @endforeach
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

    <div>  
        
    </div>
</x-layout-pemasaran>
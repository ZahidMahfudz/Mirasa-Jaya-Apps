<x-layout-manager>
    <x-slot:title>Hutang Bahan Baku</x-slot>
    <x-slot:tabs>Manager-Hutang Bahan Baku</x-slot>

    <div>
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahHutang">Tambah Hutang</button>
    </div>

    <div class="card mt-2">
        <div class="card-header">
            <strong>Update: {{ \Carbon\Carbon::parse($update)->translatedFormat('d F Y') }}</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Bahan</th>
                        <th>QTY</th>
                        <th>Satuan</th>
                        <th>Harga/Sat</th>
                        <th>PPN</th>
                        <th>Jumlah</th>
                        <th>Supplier</th>
                        <th style="width: 14%; text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($hutangbelumlunas as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ Carbon\Carbon::parse($item->tanggal)->format('d/m/y') }}</td>
                            <td>{{ $item->nama_bahan }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ $item->satuan }}</td>
                            <td style="text-align: right;">{{ number_format($item->harga_satuan) }}</td>
                            <td style="text-align: right;">{{ number_format($item->ppn) }}</td>
                            <td style="text-align: right;">{{ number_format($item->jumlah) }}</td>
                            <td>{{ $item->supplier }}</td>
                            <td>
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editHutang-{{ $item->id }}">Edit</button>
                                <a href="/lunasbahanbaku/{{ $item->id }}" class="btn btn-secondary">Lunas</a>
                                <a href="/hapushutangbahanbaku/{{ $item->id }}" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
    
                        <div class="modal fade" id="editHutang-{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Edit Produk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="edithutang/{{ $item->id }}" method="post">
                                            @csrf
                                            <div>
                                                <label for="nama_bahan" class="form-label">Nama Bahan :</label>
                                                <select name="nama_bahan" id="nama_bahan" class="form-select">
                                                    <option selected disabled>{{ $item->nama_bahan }}</option>
                                            </select>
                                            </div>
                                            <div class="mt-2">
                                                <label for="qty" class="form-label">qty :</label>
                                                <input type="number" name="qty" id="qty" class="form-control " value="{{ $item->qty }}">
                                            </div>
                                            <div class="mt-2">
                                                <label for="ppn" class="form-label">ppn :</label>
                                                <input type="number" name="ppn" id="ppn" class="form-control " value="{{ $item->ppn }}">
                                            </div>
                                            <div class="mt-2">
                                                <label for="supplier" class="form-label">Supplier:</label>
                                                <input type="text" name="supplier" id="supplier" class="form-control" value="{{ $item->supplier }}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Edit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <tr>
                        <td colspan="7" style="text-align: right;"><b>Total Hutang Bahan Baku :</b></td>
                        <td style="text-align: right;">
                            {{-- @foreach ($totalHutangBahanBaku as $total)
                                Rp.{{ number_format($total->total_hutang_bahan_baku) }}
                            @endforeach --}}
                            Rp.{{ number_format($totalHutangBahanBaku) }}
                        </td>
                        <td colspan="2"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- <div class="card mt-3">
        <div class="card-header">
            <strong>Riwayat Hutang Bahan Baku</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                <thead>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Tanggal Lunas</th>
                    <th>Nama Bahan</th>
                    <th>QTY</th>
                    <th>Satuan</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th>supplier</th>
                </thead>
                <tbody>
                    @foreach ($hutanglunas as $index => $lunas)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ Carbon\Carbon::parse($lunas->tanggal)->format('d/m/y') }}</td>
                            <td>{{ Carbon\Carbon::parse($lunas->tanggal_lunas)->format('d/m/y') }}</td>
                            <td>{{ $lunas->nama_bahan }}</td>
                            <td>{{ $lunas->qty }}</td>
                            <td>{{ $lunas->satuan }}</td>
                            <td style="text-align: right;">{{ number_format($lunas->harga_satuan) }}</td>
                            <td style="text-align: right;">{{ number_format($lunas->jumlah) }}</td>
                            <td>{{ $lunas->supplier }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> --}}

    <div class="modal fade" id="tambahHutang" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah hutang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="tambahhutang" method="post">
                            @csrf
                            <div>
                                <label for="nama_bahan" class="form-label">Nama Bahan :</label>
                                <select name="nama_bahan" id="nama_bahan" class="form-select">
                                    <option selected>Pilih Bahan Baku</option>
                                    @foreach ($bahanbaku as $bahan)
                                        <option value="{{ $bahan->nama_bahan }}">{{ $bahan->nama_bahan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-2">
                                <label for="tanggal_hutang" class="form-label">Tanggal :</label>
                                <input type="Date" name="tanggal_hutang" id="tanggal_hutang" class="form-control  @error('tanggal_hutang') is-invalid @enderror" value="{{ old('tanggal_hutang') }}">
                                @error('tanggal_hutang')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="qty" class="form-label">qty :</label>
                                <input type="number" name="qty" id="qty" class="form-control  @error('qty') is-invalid @enderror" value="{{ old('qty') }}">
                                @error('qty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="ppn" class="form-label">Nominal PPN (nominal ppn/jumlah item pada nota) :</label>
                                <input type="number" name="ppn" id="ppn" class="form-control  @error('ppn') is-invalid @enderror" value="{{ old('ppn') }}">
                                @error('ppn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="supplier" class="form-label">Supplier:</label>
                                <input type="text" name="supplier" id="supplier" class="form-control  @error('supplier') is-invalid @enderror" value="{{ old('supplier') }}">
                                @error('supplier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                    </form>
                </div>
        </div>
    </div>
</x-layout-manager>

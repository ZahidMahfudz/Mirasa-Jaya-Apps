<title>Mirasa Jaya - Uang Masuk</title>
@extends('manager.layout')
@section('main_content')
    <h1>Uang Masuk</h1>
    <div class="mt-2">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahuangmasukpiutang">Tambah Uang Masuk</button>
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahretail">Tambah Retail</button>
    </div>
    <div class="mt-3 mb-0">
        <p><b>
            Total Uang Masuk :
            @foreach ($totaluangmasuk as $totaluangmasuk)
                {{ number_format($totaluangmasuk->total_uang_masuk) }} per : {{ Carbon\Carbon::parse($totaluangmasuk->update)->format('d F Y') }}
            @endforeach
        </b></p>
    </div>
    <div>
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#nota_piutang" type="button" role="tab" aria-controls="nota_piutang" aria-selected="false">Nota Piutang</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#retail" type="button" role="tab" aria-controls="retail" aria-selected="false">retail</button>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="nota_piutang" role="tabpanel" aria-labelledby="nota_piutang-tab">
                        <div class="mt-3">
                            <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Toko</th>
                                        <th>Tanggal Nota</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal Lunas</th>
                                        <th>Total Piutang</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($piutang as $index => $piutang)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $piutang->tanggal }}</td>
                                            <td>{{ $piutang->nama_toko }}</td>
                                            <td>{{ Carbon\Carbon::parse($piutang->tanggal)->format('d F Y') }}</td>
                                            <td>{{ $piutang->keterangan }}</td>
                                            <td>
                                                @if ($piutang->tanggal_lunas == null)
                                                    -
                                                @else
                                                    {{ $piutang->tanggal_lunas }}
                                                @endif
                                            </td>
                                            <td>{{ number_format($piutang->total_piutang) }}</td>
                                            <td>
                                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editpiutang-{{ $piutang->id }}">Edit</button>
                                                <a href="/deleteuangmasukpiutang/{{ $piutang->id }}" class="btn btn-danger">Hapus</a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="editpiutang-{{ $piutang->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Edit Nota</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="edituangmasukpiutang/{{ $piutang->id }}" method="POST">
                                                            @csrf
                                                            <div>
                                                                <label for="nama_toko" class="form-label">Nama Toko :</label>
                                                                <input type="text" name="nama_toko" id="nama_toko" class="form-control" value="{{ $piutang->nama_toko }}" disabled>
                                                            </div>
                                                            <div class="mt-2">
                                                                <label for="tanggal_nota" class="form-label">Tanggal Nota:</label>
                                                                <input type="date" name="tanggal_nota" id="tanggal_nota" class="form-control @error('tanggal_nota') is-invalid @enderror" value="{{ $piutang->tanggal }}">
                                                                @error('tanggal_nota')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="mt-2">
                                                                <label for="keterangan" class="form-label">Keterangan:</label>
                                                                <input type="text" name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" value="{{ $piutang->keterangan }}">
                                                                @error('keterangan')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="mt-2">
                                                                <label for="total_piutang" class="form-label">Total Piutang:</label>
                                                                <input type="number" name="total_piutang" id="total_piutang" class="form-control @error('total_piutang') is-invalid @enderror" value="{{ $piutang->total_piutang }}">
                                                                @error('total_piutang')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Edit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="retail" role="tabpanel" aria-labelledby="retail-tab">
                        <div class="mt-3">
                            <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Produk</th>
                                        <th>QTY</th>
                                        <th>Satuan</th>
                                        <th>Harga Satuan</th>
                                        <th>Jumlah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($retail as $index => $retail)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ Carbon\Carbon::parse($retail->tanggal)->format('d F Y') }}</td>
                                            <td>{{ $retail->nama_produk }}</td>
                                            <td>{{ $retail->qty }}</td>
                                            <td>{{ $retail->satuan }}</td>
                                            <td>{{ number_format($retail->harga_satuan) }}</td>
                                            <td>{{ number_format($retail->jumlah) }}</td>
                                            <td>
                                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editretail-{{ $retail->id }}">Edit</button>
                                                <a href="/deleteuangmasukretail/{{ $retail->id }}" class="btn btn-danger">Hapus</a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="editretail-{{ $retail->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Edit Retail</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="edituangmasukretail/{{ $retail->id }}" method="POST">
                                                            @csrf
                                                            <div class="mt-2">
                                                                <label for="tanggal" class="form-label">Tanggal:</label>
                                                                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $retail->tanggal }}" disabled>
                                                            </div>
                                                            <div>
                                                                <label for="nama_produk" class="form-label">Nama Produk :</label>
                                                                <select name="nama_produk" id="nama_produk" class="form-select">
                                                                    <option selected>{{ $retail->nama_produk }}</option>
                                                                </select>
                                                            </div>
                                                            <div class="mt-2">
                                                                <label for="qty" class="form-label">QTY:</label>
                                                                <input type="number" name="qty" id="qty" class="form-control @error('qty') is-invalid @enderror" value="{{ $retail->qty }}">
                                                                @error('qty')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="mt-2">
                                                                <label for="satuan" class="form-label">Satuan:</label>
                                                                <input type="text" name="satuan" id="satuan" class="form-control @error('satuan') is-invalid @enderror" value="{{ $retail->satuan }}">
                                                                @error('satuan')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Edit</button>
                                                            </div>
                                                        </form>

                                                    </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="tambahuangmasukpiutang" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Uang Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="tambahuangmasukpiutang" method="POST">
                            @csrf
                            <div>
                                <label for="nama_toko" class="form-label">Nama Toko :</label>
                                <input type="text" name="nama_toko" id="nama_toko" class="form-control @error('nama_toko') is-invalid @enderror" value="{{ old('nama_toko') }}">
                                @error('nama_toko')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="tanggal_nota" class="form-label">tanggal Nota:</label>
                                <input type="date" name="tanggal_nota" id="tanggal_nota" class="form-control  @error('tanggal_nota') is-invalid @enderror" value="{{ old('tanggal_nota') }}">
                                @error('tanggal_nota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="keterangan" class="form-label">Keterangan:</label>
                                <input type="text" name="keterangan" id="keterangan" class="form-control  @error('keterangan') is-invalid @enderror" value="{{ old('keterangan') }}">
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="total_piutang" class="form-label">Total Piutang/Nota:</label>
                                <input type="number" name="total_piutang" id="total_piutang" class="form-control  @error('total_piutang') is-invalid @enderror" value="{{ old('total_piutang') }}">
                                @error('total_piutang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
        </div>
    </div>
    <div class="modal fade" id="tambahretail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Retail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="tambahretail" method="POST">
                            @csrf
                            <div class="mt-2">
                                <label for="tanggal" class="form-label">tanggal:</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control  @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}">
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="nama_produk" class="form-label">Nama Produk :</label>
                                <select name="nama_produk" id="nama_produk" class="form-select">
                                    <option selected>Pilih Produk</option>
                                    @foreach ($produk as $produk)
                                        <option value="{{ $produk->nama_produk }}">{{ $produk->nama_produk }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-2">
                                <label for="qty" class="form-label">QTY:</label>
                                <input type="number" name="qty" id="qty" class="form-control  @error('qty') is-invalid @enderror" value="{{ old('qty') }}">
                                @error('qty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="satuan" class="form-label">Satuan:</label>
                                <input type="text" name="satuan" id="satuan" class="form-control  @error('satuan') is-invalid @enderror" value="{{ old('satuan') }}">
                                @error('satuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
        </div>
    </div>

@endsection

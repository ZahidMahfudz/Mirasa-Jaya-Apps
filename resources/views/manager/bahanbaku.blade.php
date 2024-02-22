<title>Mirasa Jaya - Harga Bahan Baku</title>
@extends('manager.layout')
@section('main_content')
    <h1>Bahan Baku</h1>
    <div class="mt-2">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahBB">Tambah Bahan Baku</button>
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahBP">Tambah Bahan Penolong</button>
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahKardus">Tambah Kardus</button>
    </div>

    <div class="mt-3">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="false">Bahan Baku</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Bahan Penolong</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Kardus</button>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="mt-3">
                            <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Bahan</th>
                                        <th>Satuan</th>
                                        <th>Harga /satuan (zak)</th>
                                        <th>Harga /kg</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bahanbaku as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->nama_bahan }}</td>
                                            <td>{{ $item->satuan }} ({{ $item->banyak_satuan }} {{ $item->jenis_satuan }})</td>
                                            <td>{{ number_format($item->harga_persatuan) }}</td>
                                            <td>{{ number_format($item->harga_perkilo) }}</td>
                                            <td>
                                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editbahanbaku-{{ $item->id }}">Edit</button>
                                                <a href="/deletebahanbaku/{{ $item->id }}" class="btn btn-danger">Hapus</a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="editbahanbaku-{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Edit Bahan Baku</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="editbahanbaku/{{ $item->id }}" method="POST">
                                                                @csrf
                                                                <div>
                                                                    <label for="nama_bahan_baku" class="form-label">Nama bahan baku :</label>
                                                                    <input type="text" name="nama_bahan_baku" id="nama_bahan_baku" class="form-control" value="{{ $item->nama_bahan }}" disabled>
                                                                </div>
                                                                <div class="mt-2">
                                                                    <label for="satuan" class="form-label">Satuan:</label>
                                                                    <input type="text" name="satuan" id="satuan" class="form-control" value="{{ $item->satuan }}">
                                                                </div>
                                                                <div class="mt-2">
                                                                    <label for="banyaknya_satuan" class="form-label">banyaknya satuan:</label>
                                                                    <input type="number" name="banyaknya_satuan" id="banyaknya_satuan" class="form-control" value="{{ $item->banyak_satuan }}">
                                                                </div>
                                                                <div class="mt-2">
                                                                    <label for="jenis_satuan" class="form-label"> Jenis Satuan:</label>
                                                                    <select name="jenis_satuan" id="jenis_satuan" class="form-select form-select-sm" aria-label=".form-select-sm example">
                                                                        <option value="{{ $item->jenis_satuan }}" selected>{{ $item->jenis_satuan }}</option>
                                                                        <option value="Kg">Kg</option>
                                                                        <option value="Gr">Gr</option>
                                                                        <option value="Biji">Biji</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mt-2">
                                                                    <label for="harga_persatuan" class="form-label">Harga persatuan:</label>
                                                                    <input type="number" name="harga_persatuan" id="harga_persatuan" class="form-control" value="{{ $item->harga_persatuan }}">
                                                                </div>
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
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="mt-3">
                            <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Bahan</th>
                                        <th>Satuan</th>
                                        <th>Harga /satuan (zak)</th>
                                        <th>Harga /kg</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bahanpenolong as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->nama_bahan }}</td>
                                            <td>{{ $item->satuan }} ({{ $item->banyak_satuan }} {{ $item->jenis_satuan }})</td>
                                            <td>{{ number_format($item->harga_persatuan) }}</td>
                                            <td>{{ number_format($item->harga_perkilo) }}</td>
                                            <td>
                                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editbahanpenolong-{{ $item->id }}">Edit</button>
                                                <a href="/deletebahanbaku/{{ $item->id }}" class="btn btn-danger">Hapus</a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="editbahanpenolong-{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Edit Bahan Penolong</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="editbahanpenolong/{{ $item->id }}" method="POST">
                                                                @csrf
                                                                <div>
                                                                    <label for="nama_bahan_baku" class="form-label">Nama bahan baku :</label>
                                                                    <input type="text" name="nama_bahan_baku" id="nama_bahan_baku" class="form-control" value="{{ $item->nama_bahan }}" disabled>
                                                                </div>
                                                                <div class="mt-2">
                                                                    <label for="satuan" class="form-label">Satuan:</label>
                                                                    <input type="text" name="satuan" id="satuan" class="form-control" value="{{ $item->satuan }}">
                                                                </div>
                                                                <div class="mt-2">
                                                                    <label for="banyaknya_satuan" class="form-label">banyaknya satuan:</label>
                                                                    <input type="number" name="banyaknya_satuan" id="banyaknya_satuan" class="form-control" value="{{ $item->banyak_satuan }}">
                                                                </div>
                                                                <div class="mt-2">
                                                                    <label for="jenis_satuan" class="form-label"> Jenis Satuan:</label>
                                                                    <select name="jenis_satuan" id="jenis_satuan" class="form-select form-select-sm" aria-label=".form-select-sm example">
                                                                        <option value="{{ $item->jenis_satuan }}" selected>{{ $item->jenis_satuan }}</option>
                                                                        <option value="Kg">Kg</option>
                                                                        <option value="Gr">Gr</option>
                                                                        <option value="Biji">Biji</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mt-2">
                                                                    <label for="harga_persatuan" class="form-label">Harga persatuan:</label>
                                                                    <input type="number" name="harga_persatuan" id="harga_persatuan" class="form-control" value="{{ $item->harga_persatuan }}">
                                                                </div>
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
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="mt-3">
                            <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Bahan</th>
                                        <th>Satuan</th>
                                        <th>Harga /satuan (zak)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kardus as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->nama_bahan }}</td>
                                            <td>{{ $item->satuan }} ({{ $item->banyak_satuan }} {{ $item->jenis_satuan }})</td>
                                            <td>{{ number_format($item->harga_persatuan) }}</td>
                                            <td>
                                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editkardus-{{ $item->id }}">Edit</button>
                                                <a href="/deletebahanbaku/{{ $item->id }}" class="btn btn-danger">Hapus</a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="editkardus-{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Edit Kardus</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="editkardus/{{ $item->id }}" method="POST">
                                                                @csrf
                                                                <div>
                                                                    <label for="nama_kardus" class="form-label">Nama Kardus :</label>
                                                                    <input type="text" name="nama_kardus" id="nama_kardus" class="form-control" value="{{ $item->nama_bahan }}" disabled>
                                                                </div>
                                                                <div class="mt-2">
                                                                    <label for="satuan" class="form-label">Satuan:</label>
                                                                    <input type="text" name="satuan" id="satuan" class="form-control" value="{{ $item->satuan }}">
                                                                </div>
                                                                <div class="mt-2">
                                                                    <label for="harga_persatuan" class="form-label">Harga persatuan:</label>
                                                                    <input type="number" name="harga_persatuan" id="harga_persatuan" class="form-control" value="{{ $item->harga_persatuan }}">
                                                                </div>
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

    <div class="modal fade" id="tambahBB" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Bahan Baku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="tambahbahanbaku" method="POST">
                            @csrf
                            <div>
                                <label for="nama_bahan_baku" class="form-label">Nama bahan baku :</label>
                                <input type="text" name="nama_bahan_baku" id="nama_bahan_baku" class="form-control @error('nama_bahan_baku') is-invalid @enderror" value="{{ old('nama_bahan_baku') }}">
                                @error('nama_bahan_baku')
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
                            <div class="mt-2">
                                <label for="banyaknya_satuan" class="form-label">banyaknya satuan:</label>
                                <input type="number" name="banyaknya_satuan" id="banyaknya_satuan" class="form-control  @error('banyaknya_satuan') is-invalid @enderror" value="{{ old('banyaknya_satuan') }}">
                                @error('banyaknya_satuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="jenis_satuan" class="form-label"> Jenis Satuan:</label>
                                <select name="jenis_satuan" id="jenis_satuan" class="form-select form-select-sm" aria-label=".form-select-sm example">
                                    <option selected disabled>Jenis Satuan</option>
                                    <option value="Kg">Kg</option>
                                    <option value="Gr">Gr</option>
                                    <option value="Biji">Biji</option>
                                </select>
                                @error('jenis_satuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="harga_persatuan" class="form-label">Harga persatuan:</label>
                                <input type="number" name="harga_persatuan" id="harga_persatuan" class="form-control  @error('harga_persatuan') is-invalid @enderror" value="{{ old('harga_persatuan') }}">
                                @error('harga_persatuan')
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

    <div class="modal fade" id="tambahBP" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Bahan Penolong</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="tambahbahanpenolong" method="POST">
                            @csrf
                            <div>
                                <label for="nama_bahan_penolong" class="form-label">Nama Bahan Penolong :</label>
                                <input type="text" name="nama_bahan_penolong" id="nama_bahan_penolong" class="form-control @error('nama_bahan_penolong') is-invalid @enderror" value="{{ old('nama_bahan_penolong') }}">
                                @error('nama_bahan_penolong')
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
                            <div class="mt-2">
                                <label for="banyaknya_satuan" class="form-label">banyaknya satuan:</label>
                                <input type="number" name="banyaknya_satuan" id="banyaknya_satuan" class="form-control  @error('banyaknya_satuan') is-invalid @enderror" value="{{ old('banyaknya_satuan') }}">
                                @error('banyaknya_satuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-2">
                                <label for="jenis_satuan" class="form-label"> Jenis Satuan:</label>
                                <select name="jenis_satuan" id="jenis_satuan" class="form-select form-select-sm" aria-label=".form-select-sm example">
                                    <option selected disabled>Jenis Satuan</option>
                                    <option value="Kg">Kg</option>
                                    <option value="Gr">Gr</option>
                                    <option value="Biji">Biji</option>
                                </select>
                            </div>
                            <div class="mt-2">
                                <label for="harga_persatuan" class="form-label">Harga persatuan:</label>
                                <input type="number" name="harga_persatuan" id="harga_persatuan" class="form-control  @error('harga_persatuan') is-invalid @enderror" value="{{ old('harga_persatuan') }}">
                                @error('harga_persatuan')
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

    <div class="modal fade" id="tambahKardus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Kardus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="tambahkardus" method="POST">
                            @csrf
                            <div>
                                <label for="nama_kardus" class="form-label">Nama Kardus :</label>
                                <input type="text" name="nama_kardus" id="nama_kardus" class="form-control @error('nama_kardus') is-invalid @enderror" value="{{ old('nama_kardus') }}">
                                @error('nama_kardus')
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
                            <div class="mt-2">
                                <label for="harga_persatuan" class="form-label">Harga persatuan:</label>
                                <input type="number" name="harga_persatuan" id="harga_persatuan" class="form-control  @error('harga_persatuan') is-invalid @enderror" value="{{ old('harga_persatuan') }}">
                                @error('harga_persatuan')
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

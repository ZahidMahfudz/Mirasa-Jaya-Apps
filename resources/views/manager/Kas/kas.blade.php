<x-layout-manager>
    <x-slot:title>Kas</x-slot>
    <x-slot:tabs>Manager-Kas</x-slot>

    <!-- BODY -->
    <ul class="nav nav-tabs nav-fill" style="margin-bottom: 20px;">
        <li class="nav-item">
          <a class="nav-link active" href="{{ route('kas') }}">
           <i class="bi bi-wallet-fill"></i> Kas
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('bank-permata')}}">
            <i class="bi bi-bank"></i> Kas Bank Permata
        </a>
        </li>
    </ul>

    <!-- Filter Tanggal -->
    <div class="row mb-4">
        <!-- Filter Tanggal -->
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">Filter Tanggal</h5>
                <div class="card-body">
                    <form action="{{ route('kas') }}" method="GET">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="start_date" class="col-form-label">Mulai:</label>
                            </div>
                            <div class="col-auto">
                                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ $startDate }}">
                            </div>
                            <div class="col-auto">
                                <label for="end_date" class="col-form-label">Sampai:</label>
                            </div>
                            <div class="col-auto">
                                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ $endDate }}">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-filter"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tombol Tambah Data -->
        <div class="col-md-4 text-end align-self-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDataModal">
                <i class="bi bi-plus-lg"></i> Tambah Data
            </button>
            @include('manager.Kas.create-kas')
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <!-- Periode Tanggal -->
                <h5 class="card-title">Periode Tanggal Minggu ini :</h5>
                <span class="badge bg-primary mb-4">
                    {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                </span>

                <!-- Tampilkan total saldo terkini -->
                <div class="alert alert-info">
                    <strong>Total Saldo Kas Terkini: </strong> Rp {{ number_format($totalSaldo, 2, ',', '.') }}
                </div>


                <!-- Tabel data kas -->
                <table class="table table-bordered table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kas</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <!-- Menampilkan semua data dari Kas -->
                        @foreach($kas as $dataKas)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $dataKas->kas }}</td>
                            <td>{{ $dataKas->jumlah }}</td>
                            <td>
                                <a href="{{ url('/Kas/edit/'.$dataKas->id)}}" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editDataModal{{$dataKas->id}}">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <a href="{{ url('/Kas/delete/'.$dataKas->id)}}" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{$dataKas->id}}">
                                    <i class="bi bi-trash-fill"></i> Delete
                                </a>
                                @include('manager.Kas.delete-kas')
                            </td>
                        </tr>
                        @endforeach
                
                        <!-- Baris terakhir untuk Bank Permata -->
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>Bank Permata</td>
                            <td>{{ number_format($totalKasBankPermataSaldo, 2, ',', '.') }}</td>
                            <td>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>   
        </div>
        <!-- Modal Edit Data -->
        @include('manager.Kas.edit-kas')
    </section>
</x-layout-manager>

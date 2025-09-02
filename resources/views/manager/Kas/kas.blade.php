<x-layout-manager>
    <x-slot:title>Kas</x-slot>
    <x-slot:tabs>Manager-Kas</x-slot>

    <!-- BODY -->
    <ul class="nav nav-tabs" style="margin-bottom: 20px;">
        <li class="nav-item">
          <a class="nav-link active" href="{{ route('kas') }}">
            Kas
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('bank-permata')}}">
             Kas Bank Permata
        </a>
        </li>
    </ul>

    <!-- Filter Tanggal -->
    {{-- <div class="row mb-4">
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
    </div> --}}
    <div class="mb-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDataModal">
            <i class="bi bi-plus-lg"></i> Tambah Data Item Kas
        </button>
        @include('manager.Kas.create-kas')
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <!-- Periode Tanggal -->
                <h5 class="card-title">Periode Tanggal Minggu ini : {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</h5>

                {{-- <!-- Tampilkan total saldo terkini -->
                <div class="alert alert-info">
                    <strong>Total Saldo Kas Terkini: </strong> Rp {{ number_format($totalSaldo, 2, ',', '.') }}
                </div> --}}


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
                            <td style="width: 100px; min-width: 50px; text-align: center;">{{ $no++ }}</td>
                            <td>{{ $dataKas->kas }}</td>
                            <td style="text-align: right;">{{ number_format($dataKas->jumlah, 2, ',', '.') }}</td>
                            <td style="width: 180px; min-width: 120px; text-align: center;">
                                <a href="{{ url('/Kas/edit/'.$dataKas->id)}}" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editDataModal{{$dataKas->id}}">
                                     Edit
                                </a>
                                <a href="{{ url('/Kas/delete/'.$dataKas->id)}}" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{$dataKas->id}}">
                                    </i> Delete
                                </a>
                                @include('manager.Kas.delete-kas')
                            </td>
                        </tr>
                        @endforeach
                
                        <!-- Baris terakhir untuk Bank Permata -->
                        <tr>
                            <td style="text-align: center;">{{ $no++ }}</td>
                            <td>Bank Permata</td>
                            <td style="text-align: right;">{{ number_format($totalKasBankPermataSaldo, 2, ',', '.') }}</td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: right;"><Strong>Total Kas</Strong></td>
                            <td style="text-align: right;"><strong>{{ number_format($totalSaldo, 2, ',', '.') }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>   
        </div>
        <!-- Modal Edit Data -->
        @include('manager.Kas.edit-kas')
    </section>
</x-layout-manager>

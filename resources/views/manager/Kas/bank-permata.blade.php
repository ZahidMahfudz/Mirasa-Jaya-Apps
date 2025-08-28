<x-layout-manager>
    <x-slot:title>Kas</x-slot>
    <x-slot:tabs>Manager-Kas</x-slot>

    <!-- BODY -->
    <ul class="nav nav-tabs nav-fill" style="margin-bottom: 20px;">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('kas') }}">
           <i class="bi bi-wallet-fill"></i> Kas
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link  active" href="{{ route('bank-permata')}}">
            <i class="bi bi-bank"></i> Kas Bank Permata
        </a>
        </li>
    </ul>

    <!-- TOMBOL TAMBAH DATA -->
    <div class="pb-2 col-md-6 text-end align-self-end">
        <div class="row">
            <div class="col-md-12 ml-auto">
                <a href="{{ route('store-bank-permata') }}" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#tambahDataModal">+ Tambah</a>
                    <!-- Modal Tambah Data -->
                    @include('manager.Kas.create-bank-permata')
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-body">
                <!-- Tampilkan total saldo terkini -->
                <div class="alert alert-info">
                    <strong>Total Saldo Bank Permata Terkini: </strong> Rp {{ number_format($totalSaldo, 2, ',', '.') }}
                </div>
                <table class="table table-bordered table-striped" id="table1">
                    <thead>
                            <tr>
                                <th rowspan="2" style="vertical-align: middle; text-align: center; width: 50px;">No</th>
                                <th rowspan="2" style="vertical-align: middle; text-align: center;">Tanggal</th>
                                <th rowspan="2" style="vertical-align: middle; text-align: center;">Hal</th>
                                <th colspan="2" style="text-align: center;">Mutasi</th>
                                <th colspan="1" style="text-align: center;">Saldo</th>
                                <th rowspan="2" style="vertical-align: middle; text-align: center; width: 130px;">Aksi</th>
                            </tr>
                            <tr>
                                <th style="text-align: center;">Debit</th>
                                <th style="text-align: center;">Kredit</th>
                                <th style="text-align: center;">(Rupiah)</th>
                            </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; ?>
                        @foreach ($kas_bank_permata as $data)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ \Carbon\Carbon::parse($data->tanggal)->locale('id')->translatedFormat('j F Y') }}</td>
                            <td>{{ $data->hal }}</td>
                            <td>{{ $data->debit }}</td>
                            <td>{{ $data->kredit }}</td>
                            <td>{{ $data->saldo }}</td>
                            <td>
                                <a href="{{ url('Bank-Permata/edit/'.$data->id)}}" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $data->id}}">Edit</a>
                                <a href="{{ url('Bank-Permata/delete/'.$data->id)}}" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $data->id}}">Delete</a>
                                <!--- Modal Delete Data -->
                                @include('manager.Kas.delete-bank-permata')
                            </td> 
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>   
        </div>
        <!--- Modal Edit Data -->
        @include('manager.Kas.edit-bank-permata')
    </section>
</x-layout-manager>
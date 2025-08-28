<x-layout-owner>
    <x-slot:title>Modal Disetor</x-slot>
    <x-slot:tabs>owner-Modal Disetor</x-slot>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    
                </div>
                <div class="mt-1">
                    <a href="" onclick=" this.href='/cetak-Modal'" class="btn btn-secondary" target="_blank" >Cetak</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h3>Modal Disetor</h3>
                        <p class="badge bg-secondary fs-7">
                            <i class="fas fa-calendar-alt"></i> Periode: 1 Januari s.d {{ date('d F Y') }}
                        </p>
                    </div>
                    
                    <!-- Tombol Tambah Data -->
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Modal</th>
                            <th>Tanggal</th>
                            <th class="text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @forelse ($modalDisetor as $modal)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $modal->jenis_modal }}</td>
                            <td>{{ \Carbon\Carbon::parse($modal->tanggal)->locale('id')->translatedFormat('j F Y') }}</td>
                            <td class="text-right">Rp {{ number_format($modal->jumlah, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak Ada Data Modal Disetor</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td colspan="3" class="text-center"><strong>Total Jumlah</strong></td>
                        <td class="text-right"><strong>Rp {{ number_format($modalDisetor->sum('jumlah')) }}</strong></td>
                    </tr>                
                    </tbody>
                </table>
            </div>

            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h3>Modal dari Bank Permata</h3>
                    </div>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Deskripsi</th>
                            <th>Tanggal</th>
                            <th class="text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modalBankPermata as $permata)
                        <tr>
                            <td>Pinjaman Bank Permata</td>
                            <td>{{ \Carbon\Carbon::parse($permata->tanggal)->locale('id')->translatedFormat('j F Y') }}</td>
                            <td class="text-right">Rp {{ number_format($permata->jumlah, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout-owner>
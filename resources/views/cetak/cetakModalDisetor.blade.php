<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap JavaScript (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    
    <title>Cetak Modal Disetor</title>
</head>

<h3>Modal Disetor</h3>
<p>Periode: 1 Januari s.d {{ date('d F Y') }}</p>

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

<script type="text/javascript">
    window.print();
</script>
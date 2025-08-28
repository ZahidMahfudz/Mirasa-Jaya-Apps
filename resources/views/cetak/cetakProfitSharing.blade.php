<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap JavaScript (Popper.js included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Load Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    
    <title>Cetak Profit Sharing</title>
</head>

<h3>Profit Sharing</h3>

<div class="profit-sharing-details">
    <div class="row">
        <div class="col-12">
            <!-- Display Date -->
            @if($profitDibagi)
            <p>
                <strong>{{ \Carbon\Carbon::parse($profitDibagi->tanggal)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</strong>
            </p>
            @else
            <p class="text-muted"><strong>Data belum di isi</strong></p>
            @endif
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <tr>
            <td>Profit Yang Dibagi:</td>
            <td>
                @if($profitDibagi)
                Rp {{ number_format($profitDibagi->jumlah, 0, ',', '.') }}
                @else
                Rp 0
                @endif
            </td>
        </tr>
    </table>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>(%)</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @if($pembagianProfit->isEmpty())
            <tr>
                <td colspan="5" class="text-center">Belum ada daftar pembagian profit</td>
            </tr>
            @else
            @foreach($pembagianProfit as $key => $profit)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $profit->nama }}</td>
                <td>{{ $profit->persen }}</td>
                <td>Rp {{ number_format($profit->jumlah, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" class="text-center"><strong>Total Jumlah</strong></td>
                <td><strong>Rp {{ number_format($totalJumlah, 0, ',', '.') }}</strong></td>
            </tr>
            @endif
        </tbody>
    </table>

    @foreach($pembagianProfit->groupBy('nama') as $nama => $profits)
        <div class="col-md-8">
            <h5>{{ $nama }}</h5>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Sumber</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Filter detail berdasarkan nama
                        $filteredDetails = $detailPembagianProfit->where('nama', $nama);
                        $no = 1; // Inisialisasi nomor urut
                    @endphp
                    @foreach($filteredDetails as $key => $detail)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $detail->sumber ?? 'Tidak ada sumber' }}</td>
                            <td>Rp {{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" class="text-center"><strong>Jumlah</strong></td>
                        <td><strong>Rp {{ number_format($filteredDetails->sum('jumlah'), 0, ',', '.') }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endforeach
</div>

<script type="text/javascript">
    window.print();
</script>
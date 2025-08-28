@extends('manager.layout')

@section('main_content')
<style>
    table th {
        text-align: center;
    }
    table, th, td {
        border: 1px solid black;
    }
    th, td {
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
</style>
<h1>Neraca Saldo</h1>
<ul class="nav nav-tabs nav-fill mb-4">
    <li class="nav-item">
      <a class="nav-link active" href="{{ url('user/manager/dasboard/neraca') }}">
        <i class="fas fa-balance-scale"></i> Neraca
    </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('user/manager/dashboard/neraca-saldo')}}">
        <i class="fas fa-calculator"></i> Neraca Saldo
    </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('user/manager/dashboard/laporan-rugi-laba')}}">
        <i class="fas fa-chart-line"></i> Laporan Rugi Laba
    </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ url('user/manager/dashboard/pengeluaran')}}">
        <i class="fas fa-money-bill-wave"></i> Pengeluaran
    </a>
    </li>
</ul>
    
        <form action="{{ url('user/manager/dashboard/neraca-saldo') }}" method="GET">
            <div class="row">
                <div class="col">
                    <label for="tanggal_awal">Tanggal Awal:</label>
                    <input type="date" class="form-control" name="tanggal_awal" id="tanggal_awal" required>
                </div>
                <div class="col">
                    <label for="tanggal_akhir">Tanggal Akhir:</label>
                    <input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir" required>
                </div>
                <div class="col d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
        <h4 style="margin-top:50px; text-align: center;">CV. Mirasa Jaya</h4>
        <h4 style="text-align: center;">Neraca Saldo</h4>
        <p style="text-align: center;">Periode: 1 Januari s.d 9 Desember 2023</p>
            <table>
                <thead>
                    <tr>
                        <th rowspan="2">Nama Akun</th>
                        <th colspan="2">Saldo</th>
                    </tr>
                    <tr>
                        <th>Debit</th>
                        <th>Kredit</th>
                    </tr>
                </thead>
                <tbody>  
                    @foreach ($akun as $item)
                    <tr>
                        <td>{{ $item->nama }}</td>
                        <td>{{ number_format($item->debit, 0, ',', '.') }}</td>
                        <td>{{ $item->kredit }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
@endsection


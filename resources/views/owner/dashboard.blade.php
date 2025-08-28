<x-layout-owner>
    <x-slot:title>Profit Mingguan</x-slot>
    <x-slot:tabs>Owner-Profit Mingguan</x-slot>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="mt-3">
                        <form action="/user/owner/filterProfit" method="GET">
                            @csrf
                            <div class="row">
                                <div class="col" style="width: 90px;">
                                    <p>Tanggal : </p>
                                </div>
                                <div class="col">
                                    {{-- <label for="startDate" class="form-label">Mulai:</label> --}}
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $tanggal ?? '' }}">
                                </div>
                                <div class="col">
                                    {{-- <label for="submit" class="form-label"></label> --}}
                                    <button type="submit" class="btn btn-primary" name="submit" id="submit">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-1">
                    <a href="" onclick=" this.href='/user/owner/cetak-profit-mingguan/'+ document.getElementById('tanggal').value " class="btn btn-secondary" target="_blank" >Cetak</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="mt-2">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            @foreach($data as $week)
                                <th style="border-bottom: 1px solid black; text-align:center;">{{ $week['tanggal'] }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Kas</td>
                            @foreach($data as $week)
                                <td style="text-align: right;">{{ number_format($week['kas']) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Piutang Usaha</td>
                            @foreach($data as $week)
                                <td style="text-align: right;">{{ number_format($week['piutang']) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Stock Roti Jadi</td>
                            @foreach($data as $week)
                                <td style="text-align: right;">{{ number_format($week['stok_roti_jadi']) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Stock Bahan Baku dan Kardus</td>
                            @foreach($data as $week)
                                <td style="text-align: right; border-bottom:1px solid #000;">{{ number_format($week['stok_bahan_baku']) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td> </td>
                            @foreach($data as $week)
                            <td style="text-align: right; border-top:1px solid #000;">{{ number_format($totaluang = $week['kas'] + $week['piutang'] + $week['stok_roti_jadi'] + $week['stok_bahan_baku']) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Hutang Bahan Baku</td>
                            @foreach($data as $week)
                            <td style="text-align: right; border-bottom:1px solid #000;">{{ number_format($week['hutang_bb']) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td style="font-weight:bold;"></td>
                            @foreach($data as $week)
                                <td style="text-align: right; font-weight:bold;">
                                    {{ number_format($totaluang - $week['hutang_bb']) }}
                                </td>
                            @endforeach
                        </tr>
                        <tr class="profit-row">
                            <td style="font-weight:bold;">Profit</td>
                            @foreach($data as $week)
                                <td>
                                    
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout-owner>

{{-- @extends('owner.layout')
@section('main_content')
    <h1>Dashboard</h1>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui aut vel similique eum aperiam aspernatur sint? Maxime possimus, quaerat numquam officiis beatae excepturi voluptatibus animi, reiciendis error commodi quia cupiditate.</p>
@endsection --}}

@extends('owner.layout')
@section('main_content')
    <h1>Stok Kardus</h1>

    <div class="mt-2">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                    <div class="mt-1">
                        <h5>Rincian Stok Kardus</h5>
                    </div>
                    <div class="mt-3">
                        <form action="filterstokkardus" method="GET">
                            <div class="row">
                                <div class="col">
                                    <p>periode</p>
                                </div>
                                <div class="col">
                                    {{-- <label for="startDate" class="form-label">Mulai:</label> --}}
                                    <input type="date" class="form-control" id="startDate" name="startDate" value="{{ $startDate ?? '' }}">
                                </div>
                                <div class="col">
                                    <p>s/d</p>
                                </div>
                                <div class="col">
                                    {{-- <label for="endDate" class="form-label">Selesai:</label> --}}
                                    <input type="date" class="form-control" id="endDate" name="endDate" value="{{ $endDate ?? '' }}">
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
                        <a href="" onclick=" this.href='cetak-stok-kardus-filter/'+ document.getElementById('startDate').value + '/' + document.getElementById('endDate').value " class="btn btn-secondary" target="_blank" >Cetak</a>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                    <thead>
                        <tr>
                            <th rowspan="2" style="text-align: center; vertical-align: middle;">Nama Kardus</th>
                            @foreach ($uniqueDates as $tanggal)
                                <th colspan="2" style="text-align: center;">{{ $tanggal }}</th>
                            @endforeach
                        </tr>
                        <tr>
                            @foreach ($uniqueDates as $tanggal)
                                <th style="text-align: center;">Pakai</th>
                                <th style="text-align: center;">Sisa</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groupedData as $nama_kardus => $data_per_kardus)
                            <tr>
                                <td>{{ $nama_kardus }}</td>

                                @php
                                    $total_pakai = 0;
                                    $total_sisa = 0;
                                @endphp

                                @foreach ($uniqueDates as $tanggal)
                                    @php
                                        $data_tgl_kardus = $data_per_kardus->where('tanggal', $tanggal)->first();
                                        $pakai = $data_tgl_kardus ? $data_tgl_kardus->pakai : 0;
                                        $sisa = $data_tgl_kardus ? $data_tgl_kardus->sisa : 0;

                                        $total_pakai += $pakai;
                                        $total_sisa += $sisa;
                                    @endphp
                                    <td>{{ $pakai != 0 ? $pakai : '' }}</td>
                                    <td>{{ $sisa != 0 ? $sisa : '' }}</td>
                                @endforeach
                            </tr>

                        @endforeach
                        <tr>
                            <td><b>Total</b></td>
                            @foreach ($uniqueDates as $tanggal)
                                @php
                                    $total_pakai_column = $groupedData->sum(function ($data_per_kardus) use ($tanggal) {
                                        $data_tanggal = $data_per_kardus->where('tanggal', $tanggal)->first();
                                        return $data_tanggal ? $data_tanggal->pakai : 0;
                                    });
                                    $total_sisa_column = $groupedData->sum(function ($data_per_kardus) use ($tanggal) {
                                        $data_tanggal = $data_per_kardus->where('tanggal', $tanggal)->first();
                                        return $data_tanggal ? $data_tanggal->sisa : 0;
                                    });
                                @endphp
                                <td><b>{{ $total_pakai_column }}</b></td>
                                <td><b>{{ $total_sisa_column }}</b></td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

<title>Mirasa Jaya - Uang Masuk</title>
@extends('owner.layout')
@section('main_content')
    <h1>Uang Masuk</h1>

    <div>
        <div class="card mb-1 w-50">
            <div class="card-header">
                <h6 class="mb-0">Filter Periode</h6>
            </div>
            <div class="card-body">
                <form action="filter" method="GET">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label for="startDate" class="form-label">Mulai:</label>
                            <input type="date" class="form-control" id="startDate" name="startDate" value="{{ $startDate ?? '' }}">
                        </div>
                        <div class="col-md-5">
                            <label for="endDate" class="form-label">Selesai:</label>
                            <input type="date" class="form-control" id="endDate" name="endDate" value="{{ $endDate ?? '' }}">
                        </div>
                        <div class="col-12">
                            <label for="submit" class="form-label"></label>
                            <button type="submit" class="btn btn-primary" name="submit" id="submit">Filter</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>

    <div>
        <div class="card mt-3">
            <div class="card-header">
                <div  class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5>Rekap Uang Masuk Periode : {{ Carbon\Carbon::parse($startDate ?? '')->format('d F Y') }} - {{ Carbon\Carbon::parse($endDate ?? '')->format('d F Y') }}</h5>
                    </div>
                    <div class="mt-2">
                        <a href="" onclick=" this.href='cetak-uang-masuk-filter/'+ document.getElementById('startDate').value + '/' + document.getElementById('endDate').value " class="btn btn-secondary" target="_blank" >Cetak</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div>
                    <table class="table table-bordered table-sm border border-dark align-middle">
                        <tr>
                            <td><b>total Uang Masuk</b></td>
                            <td><b>{{ number_format($piutangplusretail) }}</b></td>
                        </tr>
                    </table>
                </div>
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                              <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#nota_piutang" type="button" role="tab" aria-controls="nota_piutang" aria-selected="false">Nota Piutang</button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#retail" type="button" role="tab" aria-controls="retail" aria-selected="false">retail</button>
                            </li>
                          </ul>
                          <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="nota_piutang" role="tabpanel" aria-labelledby="nota_piutang-tab">
                                <div class="mt-3">
                                    <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Toko</th>
                                                <th>Tanggal</th>
                                                <th>Keterangan</th>
                                                <th>Tanggal Lunas</th>
                                                <th>Total Piutang</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($piutang as $index => $piutang)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $piutang->nama_toko }}</td>
                                                    <td>{{ Carbon\Carbon::parse($piutang->tanggal)->format('d F Y') }}</td>
                                                    <td>{{ $piutang->keterangan }}</td>
                                                    <td>
                                                        @if ($piutang->tanggal_lunas == null)
                                                            -
                                                        @else
                                                            {{ Carbon\Carbon::parse($piutang->tanggal_lunas)->format('d F Y') }}
                                                        @endif
                                                    </td>
                                                    <td>{{ number_format($piutang->total_piutang) }}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="4"></td>
                                                <td><b>Total</b></td>
                                                <td><b>{{ number_format($jumlahpiutang) }}</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="retail" role="tabpanel" aria-labelledby="retail-tab">
                                <div class="mt-3">
                                    <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Nama Produk</th>
                                                <th>QTY</th>
                                                <th>Satuan</th>
                                                <th>Harga Satuan</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($retail as $index => $retail)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ Carbon\Carbon::parse($retail->tanggal)->format('d F Y') }}</td>
                                                    <td>{{ $retail->nama_produk }}</td>
                                                    <td>{{ $retail->qty }}</td>
                                                    <td>{{ $retail->satuan }}</td>
                                                    <td>{{ number_format($retail->harga_satuan) }}</td>
                                                    <td>{{ number_format($retail->jumlah) }}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="5"></td>
                                                <td><b>total</b></td>
                                                <td><b>{{ number_format($jumlahretail) }}</b></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="card mt-3 mb-0">
        <div class="card-header">
            <p>Total Uang Masuk</p>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                <tbody>
                    <tr>
                        @foreach ($totaluangmasuk as $totaluangmasuk)
                            <th>Total Uang Masuk per {{ Carbon\Carbon::parse($totaluangmasuk->update)->format('d F Y') }} : </th>
                            <th>{{ number_format($totaluangmasuk->total_uang_masuk) }}</th>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

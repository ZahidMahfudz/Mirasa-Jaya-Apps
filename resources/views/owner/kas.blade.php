<x-layout-owner>
    <x-slot:title>Kas</x-slot>
    <x-slot:tabs>owner-Kas</x-slot>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="mt-3">
                        <form action="{{ url('/filterkas') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col" style="width: 90px;">
                                    <p>Tanggal : </p>
                                </div>
                                <div class="col">
                                    {{-- <label for="endDate" class="form-label">Selesai:</label> --}}
                                    <input type="date" class="form-control" id="tanggalAkhir" name="tanggalAkhir" value="{{ $tanggalAkhir ?? '' }}">
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
                    <a href="" onclick=" this.href='/cetak-kas/'+ document.getElementById('tanggalAkhir').value " class="btn btn-secondary" target="_blank" >Cetak</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-4" style="margin-bottom: 40px;">
                <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="false">Kas</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Kas Bank Permata</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="mt-2">
                            <p>Hari : {{ \Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') }}</p>
                        </div>
                        <div>
                            <table class="table table-bordered table-striped border border-dark">
                                <thead>
                                    <tr>
                                        <th style="text-align: center; width:60%;">Item Kas</th>
                                        <th style="text-align: center;">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalKas = 0;
                                    @endphp
                                    @foreach ($kas as $item)
                                        <tr>
                                            <td>{{ $item->kas }}</td>
                                            <td style="text-align: right;">{{ number_format($item->jumlah) }}</td>
                                        </tr>
                                        @php
                                            $totalKas += $item->jumlah;
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <td>Bank Permata</td>
                                        <td style="text-align: right;">{{ number_format($totalKasBankPermataSaldo) }}</td>
                                        @php
                                            $totalKas += $totalKasBankPermataSaldo;
                                        @endphp
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;"><strong>Total</strong></td>
                                        <td style="text-align: right;">{{ number_format($totalKas) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="mt-2">
                            <table class="table table-bordered table-striped border border-dark" id="table1">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle; text-align: center; width: 50px;">No</th>
                                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Tanggal</th>
                                        <th rowspan="2" style="vertical-align: middle; text-align: center;">Hal</th>
                                        <th colspan="2" style="text-align: center;">Mutasi</th>
                                        <th colspan="1" style="text-align: center;">Saldo</th>
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
                                        <td style="text-align: right;">{{ $data->debit !=0 ? number_format($data->debit) : '' }}</td>
                                        <td style="text-align: right;">{{ $data->kredit !=0 ? number_format($data->kredit) : '' }}</td>
                                        <td style="text-align: right;">{{ $data->saldo != 0 ? number_format($data->saldo) : '' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</x-layout-owner>
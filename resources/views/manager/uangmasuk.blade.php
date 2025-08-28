<x-layout-manager>
    <x-slot:title>Uang Masuk</x-slot>
    <x-slot:tabs>Manager-Uang Masuk</x-slot>

    {{-- <div class="mt-2">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahuangmasukpiutang">Tambah Uang Masuk</button>
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahretail">Tambah Retail</button>
    </div> --}}
    <div>
        <div class="card mt-2">
            <div class="card-header">
                <strong>Update {{ Carbon\Carbon::parse($update)->translatedFormat('d F Y') }}</strong>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#nota_piutang" type="button" role="tab" aria-controls="nota_piutang" aria-selected="false">Nota Piutang</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#retail" type="button" role="tab" aria-controls="retail" aria-selected="false">Retail</button>
                    </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="nota_piutang" role="tabpanel" aria-labelledby="nota_piutang-tab">
                        <div class="mt-3">
                            <table class="table table-bordered table-striped table-sm border border-dark align-middle">
                                <thead class="text-center">
                                    <tr>
                                        <th style="width: 2%; vertical-align: middle;">No</th>
                                        <th style="width: 5%; vertical-align: middle;">Tanggal Nota</th>
                                        <th style="width: 5%; vertical-align: middle;">Jenis Nota</th>
                                        <th style="width: 20%; vertical-align: middle;">Nama Toko</th>
                                        <th style="width: 25%; vertical-align: middle;">Keterangan</th>
                                        <th style="width: 5%; vertical-align: middle;">Tanggal Lunas</th>
                                        <th style="width: 5%; vertical-align: middle;">Total Piutang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totaluangmasuknota = 0;
                                    @endphp
                                    @foreach ($piutang as $index => $piutang)
                                        <tr>
                                            <td style="text-align: center;">{{ $index + 1 }}</td>
                                            <td style="text-align: center;">{{ Carbon\Carbon::parse($piutang->tanggal)->format('d/m/Y') }}</td>
                                            <td style="text-align: center;">
                                                @if($piutang->jenis_nota == 'nota_cash')
                                                    Cash
                                                @elseif($piutang->jenis_nota == 'nota_noncash')
                                                    Non Cash
                                                @endif
                                            </td>
                                            <td>{{ $piutang->nama_toko }}</td>
                                            <td>{{ $piutang->keterangan }}</td>
                                            <td style="text-align: center;">
                                                @if ($piutang->tanggal_lunas == null)
                                                    -
                                                @else
                                                    {{ Carbon\Carbon::parse($piutang->tanggal_lunas)->format('d/m/Y') }}
                                                @endif
                                            </td>
                                            <td style="text-align: right;">{{ number_format($piutang->total_nota) }}</td>
                                            @php
                                                $totaluangmasuknota += $piutang->total_nota;
                                            @endphp
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="6" style="text-align: right;"><b>Total Uang Masuk dari Nota/Piutang s/d {{ Carbon\Carbon::parse($update)->translatedFormat('d F Y') }}: </b></td>
                                        <td style="text-align: right;">Rp.{{ number_format($totaluangmasuknota) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="retail" role="tabpanel" aria-labelledby="retail-tab">
                        <div class="mt-3">
                            <table class="table table-bordered table-striped table-sm border border-dark align-middle mt-3">
                                <thead class="text-center align-middle">
                                    <tr>
                                        <th style="width: 2%;" rowspan="2">No</th>
                                        <th style="width: 5%;" rowspan="2">Tanggal</th>
                                        <th style="width: 15%;" rowspan="2">Nama Pelanggan</th>
                                        <th colspan="4">Item Nota</th>
                                        <th style="width: 7%;" rowspan="2">Total</th>
                                    </tr>
                                    <tr>
                                        <th style="width: 15%;">Nama Produk</th>
                                        <th style="width: 2%;">QTY</th>
                                        <th style="width: 7%;">Harga Satuan</th>
                                        <th style="width: 7%;">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totaluangmasukretail = 0;
                                    @endphp
                                    @foreach ($retail as $item)
                                        <tr>
                                            <td rowspan="{{ count($item->item_nota) }}" class="text-center">{{ $loop->iteration }}</td>
                                            <td rowspan="{{ count($item->item_nota) }}">{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                                            <td rowspan="{{ count($item->item_nota) }}">{{ $item->nama_toko }}</td>
                                            @foreach ($item->item_nota as $index => $product)
                                                @if ($index > 0)
                                                    <tr>
                                                @endif
                                                <td>{{ $product->nama_produk }}</td>
                                                <td class="text-end">{{ $product->qty }}</td>
                                                <td class="text-end">{{ number_format($product->harga_satuan, 0, ',', '.') }}</td>
                                                <td class="text-end">{{ number_format($product->qty * $product->harga_satuan, 0, ',', '.') }}</td>
                                                    @if ($index == 0)
                                                        <td rowspan="{{ count($item->item_nota) }}" class="text-end">{{ number_format($item->total_nota, 0, ',', '.') }}</td>
                                                    @endif
                                                    @php
                                                        $totaluangmasukretail += $product->qty * $product->harga_satuan;
                                                    @endphp
                                                </tr>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="7" style="text-align: right;"><b>Total Uang Masuk dari retail s/d {{ Carbon\Carbon::parse($update)->translatedFormat('d F Y') }}: </b></td>
                                        <td style="text-align: right;">Rp.{{ number_format($totaluangmasukretail) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</x-layout-manager>
<x-layout-manager>
    <x-slot:title>Pre Order</x-slot>
    <x-slot:tabs>manager - Pre order</x-slot>

    <div class="card mt-3">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="preorderpending-tab" data-bs-toggle="tab" data-bs-target="#preorderpending"
                        type="button" role="tab" aria-controls="preorderpending" aria-selected="false">Pending</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="preorderproses-tab" data-bs-toggle="tab" data-bs-target="#preorderproses"
                        type="button" role="tab" aria-controls="preorderproses" aria-selected="false">Proses</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="preorderselesai-tab" data-bs-toggle="tab" data-bs-target="#preorderselesai"
                        type="button" role="tab" aria-controls="preorderselesai" aria-selected="false">Selesai</button>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="preorderpending" role="tabpanel" aria-labelledby="bahanbaku-tab">
                    <div class="mt-1">
                        <div>
                            @if($orderpending->isEmpty())
                                <p class="text-center">Tidak ada order</p>
                            @else
                                <table class="table table-bordered table-sm border border-dark align-middle mt-2">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 2%;">No</th>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 7%;">Tanggal Order</th>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 7%;">Tanggal selesai</th>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 9%;">Nama Pemesan</th>
                                            <th colspan="2" style="text-align: center; vertical-align: middle;">Detail Order</th>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 5%;">Status</th>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 10%;">Aksi</th>
                                        </tr>
                                        <tr>
                                            <th style="text-align: center; vertical-align: middle;">Nama Barang</th>
                                            <th style="text-align: center; vertical-align: middle;">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderpending as $index => $orderItem)
                                            @foreach ($orderItem->detailOrder as $listIndex => $listOrder)
                                                <tr>
                                                    @if ($listIndex == 0)
                                                        <td rowspan="{{ count($orderItem->detailOrder) }}" style="text-align: center;">{{ $index + 1 }}</td>
                                                        <td rowspan="{{ count($orderItem->detailOrder) }}" style="text-align: center;">{{ \Carbon\Carbon::parse($orderItem->tanggal_order)->format('d/m/Y') }}</td>
                                                        <td rowspan="{{ count($orderItem->detailOrder) }}" style="text-align: center;">{{ \Carbon\Carbon::parse($orderItem->tanggal_selesai)->format('d/m/Y') }}</td>
                                                        <td rowspan="{{ count($orderItem->detailOrder) }}" style="text-align: center;">{{ $orderItem->nama_pemesan }}</td>
                                                    @endif
                                                    <td>{{ $listOrder->nama_barang }}</td>
                                                    <td style="text-align: right;">{{ $listOrder->jumlah_barang }}</td>
                                                    @if ($listIndex == 0)
                                                        @if ($orderItem->status == 'pending')
                                                            <td style="text-align: center;" rowspan="{{ count($orderItem->detailOrder) }} "><span class="badge rounded-pill bg-danger">{{ $orderItem->status }}</span></td>
                                                        @endif
                                                        <td rowspan="{{ count($orderItem->detailOrder) }}" style="text-align: center;">
                                                            <a href="/prosesOrder/{{ $orderItem->id }}" class="btn btn-secondary">proses pesanan</a>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="preorderproses" role="tabpanel" aria-labelledby="bahanpenolong-tab">
                    <div class="mt-2">
                        <div>
                            @if ($orderproses->isEmpty())
                                <p class="text-center">Tidak ada order yang diproses</p>
                            @else
                                <table class="table table-bordered table-sm border border-dark align-middle mt-2">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 2%;">No</th>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 7%;">Tanggal Order</th>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 7%;">Tanggal selesai</th>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 9%;">Nama Pemesan</th>
                                            <th colspan="2" style="text-align: center; vertical-align: middle;">Detail Order</th>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 5%;">Status</th>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 10%;">Aksi</th>
                                        </tr>
                                        <tr>
                                            <th style="text-align: center; vertical-align: middle;">Nama Barang</th>
                                            <th style="text-align: center; vertical-align: middle;">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderproses as $index => $orderItem)
                                            @foreach ($orderItem->detailOrder as $listIndex => $listOrder)
                                                <tr>
                                                    @if ($listIndex == 0)
                                                        <td rowspan="{{ count($orderItem->detailOrder) }}" style="text-align: center;">{{ $index + 1 }}</td>
                                                        <td rowspan="{{ count($orderItem->detailOrder) }}" style="text-align: center;">{{ \Carbon\Carbon::parse($orderItem->tanggal_order)->format('d/m/Y') }}</td>
                                                        <td rowspan="{{ count($orderItem->detailOrder) }}" style="text-align: center;">{{ \Carbon\Carbon::parse($orderItem->tanggal_selesai)->format('d/m/Y') }}</td>
                                                        <td rowspan="{{ count($orderItem->detailOrder) }}" style="text-align: center;">{{ $orderItem->nama_pemesan }}</td>
                                                    @endif
                                                    <td>{{ $listOrder->nama_barang }}</td>
                                                    <td style="text-align: right;">{{ $listOrder->jumlah_barang }}</td>
                                                    @if ($listIndex == 0)
                                                        @if ($orderItem->status == 'proses')
                                                            <td style="text-align: center;" rowspan="{{ count($orderItem->detailOrder) }} "><span class="badge rounded-pill bg-secondary">{{ $orderItem->status }}</span></td>
                                                        @endif
                                                        <td rowspan="{{ count($orderItem->detailOrder) }}" style="text-align: center;">
                                                            <a href="/completeOrder/{{ $orderItem->id }}" class="btn btn-success">selesaikan pesanan</a>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="preorderselesai" role="tabpanel" aria-labelledby="wip-tab">
                    <div class="mt-2">
                        <div>
                            @if ($orderselesai->isEmpty())
                                <p class="text-center">Tidak ada order selesai</p>
                            @else
                                <table class="table table-bordered table-sm border border-dark align-middle mt-2">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 2%;">No</th>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 7%;">Tanggal Order</th>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 7%;">Tanggal selesai</th>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 9%;">Nama Pemesan</th>
                                            <th colspan="2" style="text-align: center; vertical-align: middle;">Detail Order</th>
                                            <th rowspan="2" style="text-align: center; vertical-align: middle; width: 5%;">Status</th>
                                        </tr>
                                        <tr>
                                            <th style="text-align: center; vertical-align: middle;">Nama Barang</th>
                                            <th style="text-align: center; vertical-align: middle;">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderselesai as $index => $orderItem)
                                            @foreach ($orderItem->detailOrder as $listIndex => $listOrder)
                                                <tr>
                                                    @if ($listIndex == 0)
                                                        <td rowspan="{{ count($orderItem->detailOrder) }}" style="text-align: center;">{{ $index + 1 }}</td>
                                                        <td rowspan="{{ count($orderItem->detailOrder) }}" style="text-align: center;">{{ \Carbon\Carbon::parse($orderItem->tanggal_order)->format('d/m/Y') }}</td>
                                                        <td rowspan="{{ count($orderItem->detailOrder) }}" style="text-align: center;">{{ \Carbon\Carbon::parse($orderItem->tanggal_selesai)->format('d/m/Y') }}</td>
                                                        <td rowspan="{{ count($orderItem->detailOrder) }}" style="text-align: center;">{{ $orderItem->nama_pemesan }}</td>
                                                    @endif
                                                    <td>{{ $listOrder->nama_barang }}</td>
                                                    <td style="text-align: right;">{{ $listOrder->jumlah_barang }}</td>
                                                    @if ($listIndex == 0)
                                                        @if ($orderItem->status == 'selesai')
                                                            <td style="text-align: center;" rowspan="{{ count($orderItem->detailOrder) }} "><span class="badge rounded-pill bg-success">{{ $orderItem->status }}</span></td>
                                                        @endif
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>  
        {{-- <table class="table table-bordered table-sm border border-dark align-middle mt-3">
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Tanggal Order</th>
                    <th rowspan="2">Tanggal selesai</th>
                    <th rowspan="2">Nama Pemesan</th>
                    <th colspan="2">Detail Order</th>
                    <th rowspan="2">Status</th>
                    <th rowspan="2">Aksi</th>
                </tr>
                <tr>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order as $index => $orderItem)
                    @foreach ($orderItem->detailOrder as $listIndex => $listOrder)
                        <tr>
                            @if ($listIndex == 0)
                                <td rowspan="{{ count($orderItem->detailOrder) }}">{{ $index + 1 }}</td>
                                <td rowspan="{{ count($orderItem->detailOrder) }}">{{ $orderItem->tanggal_order }}</td>
                                <td rowspan="{{ count($orderItem->detailOrder) }}">{{ $orderItem->tanggal_selesai }}</td>
                                <td rowspan="{{ count($orderItem->detailOrder) }}">{{ $orderItem->nama_pemesan }}</td>
                            @endif
                            <td>{{ $listOrder->nama_barang }}</td>
                            <td>{{ $listOrder->jumlah_barang }}</td>
                            @if ($listIndex == 0)
                                @if ($orderItem->status == 'pending')
                                    <td style="text-align: center;" rowspan="{{ count($orderItem->detailOrder) }} "><span class="badge rounded-pill bg-danger">{{ $orderItem->status }}</span></td>
                                @elseif ($orderItem->status == 'proses')
                                    <td style="text-align: center;" rowspan="{{ count($orderItem->detailOrder) }} "><span class="badge rounded-pill bg-secondary">{{ $orderItem->status }}</span></td>
                                @elseif ($orderItem->status == 'selesai')
                                    <td style="text-align: center;" rowspan="{{ count($orderItem->detailOrder) }} "><span class="badge rounded-pill bg-success">{{ $orderItem->status }}</span></td>
                                @endif
                                <td rowspan="{{ count($orderItem->detailOrder) }} ">
                                    <a href="/prosesOrder/{{ $orderItem->id }}" class="btn btn-secondary">proses pesanan</a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table> --}}
    </div>
</x-layout-manager>
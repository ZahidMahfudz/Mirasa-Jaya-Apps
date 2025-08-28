<head>
    <link href="{{ asset('css/sidebars.css') }}" rel="stylesheet">
</head>

<div class="flex-column flex-shrink-0 p-3 scrollable-div overflow-auto" style="width: 280px; height: 100%; background-color: #d4bd0f;">
    <p style="margin-bottom: 0%;">Masuk Sebagai : {{ Auth::user()->name }}</p>
    <p class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">Role : {{ Auth::user()->role }}</p>

    <ul class="nav nav-pills flex-column mb-auto ps-0">
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#produksi" aria-expanded="{{ request()->is('user/manager/resumeproduksi', 'user/manager/stokbb', 'user/manager/kardus', 'user/manager/resepwip', 'user/manager/harga_bahan_baku', 'user/manager/harga_produk') ? 'true' : 'false'}}">
                Produksi
            </button>
            <div class="{{ request()->is('user/manager/preorder','user/manager/dropOut','user/manager/resumeproduksi', 'user/manager/stokbb', 'user/manager/kardus', 'user/manager/resepwip', 'user/manager/harga_bahan_baku', 'user/manager/harga_produk') ? 'collapse show' : 'collapse'}}" id="produksi">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    {{-- <li><a href="/user/manager/preorder" class="{{ request()->is('user/manager/preorder') ? 'nav-link active' : 'link-dark rounded' }}">Pre-order</a></li> --}}
                    <li><a href="/user/manager/dropOut" class="{{ request()->is('user/manager/dropOut') ? 'nav-link active' : 'link-dark rounded' }}">Drop Out</a></li>
                    <li><a href="/user/manager/resumeproduksi" class="{{ request()->is('user/manager/resumeproduksi') ? 'nav-link active' : 'link-dark rounded' }}">Resume Produksi</a></li>
                    <li><a href="/user/manager/stokbb" class="{{ request()->is('user/manager/stokbb') ? 'nav-link active' : 'link-dark rounded' }}">Stok Bahan Baku dan Penolong</a></li>
                    <li><a href="/user/manager/kardus" class="{{ request()->is('user/manager/kardus') ? 'nav-link active' : 'link-dark rounded' }}">Stok kardus</a></li>
                </ul>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#laporanpemasaran" aria-expanded="{{ request()->is('user/manager/rekapitulasipenjualan/*') ? 'true' : 'false' }}">
                Pemasaran
            </button>
            <div class="{{ request()->is('user/manager/rekapitulasipenjualan/*') ? 'collapse show' : 'collapse' }}" id="laporanpemasaran">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="/user/manager/rekapitulasipenjualan/{{ \Carbon\Carbon::now()->subDays(6)->format('Y-m-d') }}/{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="{{ request()->is('user/manager/rekapitulasipenjualan/*') ? 'nav-link active' : 'nav-link link-dark' }}">Rekapitulasi Pemasaran</a></li>
                </ul>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#keuangan" aria-expanded="{{ request()->is('user/manager/piutang', 'user/manager/uangmasuk/*', 'user/manager/hutang_bahan_baku') ? 'true' : 'false' }}">
                Keuangan
            </button>
            <div class="{{ request()->is('user/manager/piutang', 'user/manager/uangmasuk/*', 'user/manager/hutang_bahan_baku', 'user/manager/Kas', 'user/manager/Bank-Permata', 'user/manager/AssetMesin', 'user/manager/ModalDisetor') ? 'collapse show' : 'collapse' }}" id="keuangan">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="/user/manager/Kas" class="{{ request()->is('user/manager/Kas', 'user/manager/Bank-Permata') ? 'nav-link active' : 'link-dark rounded' }}">Kas</a></li>
                    <li><a href="/user/manager/piutang" class="{{ request()->is('user/manager/piutang') ? 'nav-link active' : 'link-dark rounded' }}">Piutang Usaha</a></li>
                    <li><a href="/user/manager/uangmasuk/{{ \Carbon\Carbon::now()->subDays(6)->format('Y-m-d') }}/{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="{{ request()->is('user/manager/uangmasuk/*') ? 'nav-link active' : 'link-dark rounded' }}">Uang Masuk</a></li>
                    <li><a href="/user/manager/hutang_bahan_baku" class="{{ request()->is('user/manager/hutang_bahan_baku') ? 'nav-link active' : 'link-dark rounded' }}">Hutang Bahan Baku</a></li>
                </ul>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#BebanUsaha" aria-expanded="{{ request()->is('user/manager/pengeluaran/' . \Carbon\Carbon::now()->format('Y-m-d'), 'user/manager/bebanUsaha/' . \Carbon\Carbon::now()->subDays(6)->format('Y-m-d') . '/' . \Carbon\Carbon::now()->format('Y-m-d')) ? 'true' : 'false' }}">
                Pengeluaran Beban Usaha
            </button>
            <div class="{{ request()->is('user/manager/pengeluaran/' . \Carbon\Carbon::now()->format('Y-m-d')) || request()->is('user/manager/bebanUsaha/' . \Carbon\Carbon::now()->subDays(6)->format('Y-m-d') . '/' . \Carbon\Carbon::now()->format('Y-m-d')) || request()->is('user/manager/gajiKaryawan/' . \Carbon\Carbon::now()->format('Y-m-d')) ? 'collapse show' : 'collapse' }}" id="BebanUsaha">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="/user/manager/pengeluaran/{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="{{ url()->current() == url('/user/manager/pengeluaran/' . \Carbon\Carbon::now()->format('Y-m-d')) ? 'nav-link active' : 'link-dark rounded' }}">Pengeluaran</a></li>
                    <li><a href="/user/manager/gajiKaryawan/{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="{{ request()->is('user/manager/gajiKaryawan/' . \Carbon\Carbon::now()->format('Y-m-d')) ? 'nav-link active' : 'link-dark rounded' }}">Gaji Karyawan</a></li>
                    <li><a href="/user/manager/bebanUsaha/{{ \Carbon\Carbon::now()->subDays(6)->format('Y-m-d') }}/{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="{{ request()->is('user/manager/bebanUsaha/' . \Carbon\Carbon::now()->subDays(6)->format('Y-m-d') . '/' . \Carbon\Carbon::now()->format('Y-m-d')) ? 'nav-link active' : 'link-dark rounded' }}">Beban Usaha</a></li>
                </ul>
            </div>
        </li>
    </ul>
</div>

<head>
    <link href="{{ asset('css/sidebars.css') }}" rel="stylesheet">
</head>

<div class="flex-column flex-shrink-0 p-3 overflow-auto" style="width: 280px; height: 100%; background-color: #d4bd0f;">
    <p style="margin-bottom: 0;">login as : {{ Auth::user()->name }}</p>
    <p class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">Role : {{ Auth::user()->role }}</p>

    <ul class="nav nav-pills flex-column mb-auto ps-0">
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Dashboard" aria-expanded="{{ request()->is('user/owner/dasboard/*') ? 'true' : 'false' }}">
                Dashboard
            </button>
            <div class="{{ request()->is('user/owner/dasboard/*', 'filterProfitMingguan') ? 'collapse show' : 'collapse' }}" id="Dashboard">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li>
                        <a href="/user/owner/dasboard/{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="{{ request()->is('user/owner/dasboard/*', 'filterProfitMingguan') ? 'nav-link active' : 'nav-link link-dark' }}" aria-expanded="false">
                            Dashboard
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#keuangan" aria-expanded="{{ request()->is('user/owner/uangmasuk/*', 'user/owner/piutang', 'user/owner/hutangbahanbaku') ? 'true' : 'false' }}">
                Keuangan
            </button>
            <div class="{{ request()->is('user/owner/uangmasuk/*', 'user/owner/piutang', 'user/owner/hutangbahanbaku', 'user/owner/filteruangmasuk', 'user/owner/Kas', 'filterkas', 'user/owner/AsetMesin', 'user/owner/ModalDisetor') ? 'collapse show' : 'collapse' }}" id="keuangan">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="/user/owner/Kas" class="{{ request()->is('user/owner/Kas', 'filterkas') ? 'nav-link active' : 'nav-link link-dark' }}">Kas</a></li>
                    <li><a href="/user/owner/uangmasuk/{{ \Carbon\Carbon::now()->subDays(6)->format('Y-m-d') }}/{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="{{ request()->is('user/owner/uangmasuk/*') || request()->is('user/owner/filteruangmasuk') ? 'nav-link active' : 'nav-link link-dark' }}">Uang Masuk</a></li>
                    <li><a href="/user/owner/piutang" class="{{ request()->is('user/owner/piutang') ? 'nav-link active' : 'nav-link link-dark' }}">Piutang</a></li>
                    <li><a href="/user/owner/hutangbahanbaku" class="{{ request()->is('user/owner/hutangbahanbaku') ? 'nav-link active' : 'nav-link link-dark' }}">Hutang Bahan Baku</a></li>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#stok" aria-expanded="{{ request()->is('user/owner/laporanproduksi', 'user/owner/stokrotijadi', 'user/owner/stokbb', 'user/owner/stokkardus') ? 'true' : 'false' }}">
                Produksi
            </button>
            <div class="{{ request()->is('user/owner/laporanproduksi', 'user/owner/stokrotijadi', 'user/owner/stokbb', 'user/owner/stokkardus', 'user/owner/filterlaporanproduksi', 'user/owner/filterstokrotijadi', 'user/owner/filterstokbb', 'user/owner/filterstokkardus') ? 'collapse show' : 'collapse' }}" id="stok">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="/user/owner/laporanproduksi" class="{{ request()->is('user/owner/laporanproduksi',  'user/owner/filterlaporanproduksi') ? 'nav-link active' : 'nav-link link-dark' }}">Laporan Produksi</a></li>
                    <li><a href="/user/owner/stokrotijadi" class="{{ request()->is('user/owner/stokrotijadi', 'user/owner/filterstokrotijadi') ? 'nav-link active' : 'nav-link link-dark' }}">Stok Roti Jadi</a></li>
                    <li><a href="/user/owner/stokbb" class="{{ request()->is('user/owner/stokbb', 'user/owner/filterstokbb') ? 'nav-link active' : 'nav-link link-dark' }}">Stok Bahan Baku, bahan penolong, dan wip</a></li>
                    <li><a href="/user/owner/stokkardus" class="{{ request()->is('user/owner/stokkardus', 'user/owner/filterstokkardus') ? 'nav-link active' : 'nav-link link-dark' }}">Stok Kardus</a></li>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#laporanpemasaran" aria-expanded="{{ request()->is('user/owner/rekapitulasipenjualan/*') ? 'true' : 'false' }}">
                Laporan Pemasaran
            </button>
            <div class="{{ request()->is('user/owner/rekapitulasipenjualan/*') ? 'collapse show' : 'collapse' }}" id="laporanpemasaran">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="/user/owner/rekapitulasipenjualan/{{ \Carbon\Carbon::now()->subDays(6)->format('Y-m-d') }}/{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="{{ request()->is('user/owner/rekapitulasipenjualan/*') ? 'nav-link active' : 'nav-link link-dark' }}">Rekapitulasi Pemasaran</a></li>
                </ul>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#bebanUsaha" aria-expanded="{{ request()->is('user/owner/bebanUsaha/*') ? 'true' : 'false' }}">
                Beban Usaha
            </button>
            <div class="{{ request()->is('user/owner/bebanUsaha/*') ? 'collapse show' : 'collapse' }}" id="bebanUsaha">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="/user/owner/bebanUsaha/{{ \Carbon\Carbon::now()->subDays(6)->format('Y-m-d') }}/{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="{{ request()->is('user/owner/bebanUsaha/*') ? 'nav-link active' : 'link-dark rounded' }}">Beban Usaha</a></li>
                </ul>
            </div>
        </li>
    </ul>
</div>
<head>
    <link href="{{ asset('css/sidebars.css') }}" rel="stylesheet">
</head>

<div class="flex-column flex-shrink-0 p-3 scrollable-div overflow-auto" style="width: 280px; height: 100%; background-color: #d4bd0f;">
    <p style="margin-bottom: 0%;">login as : {{ Auth::user()->name }}</p>
    <p class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">Role : {{ Auth::user()->role }}</p>

    <ul class="nav nav-pills flex-column mb-auto ps-0">
        <li>
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#pengeluaran" aria-expanded="{{ request()->is('user/admin/datakaryawanborongan','user/admin/datakaryawan', 'user/admin/gajiankaryawan/' . \Carbon\Carbon::now()->format('Y-m-d')) ? 'true' : 'false'}}">
                Pengeluaran
            </button>
            <div class="{{ request()->is('user/admin/pengeluaran/' . \Carbon\Carbon::now()->format('Y-m-d')) ? 'collapse show' : 'collapse'}}" id="pengeluaran">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="/user/admin/pengeluaran/{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="{{ request()->is('user/admin/pengeluaran/'.\Carbon\Carbon::now()->format('Y-m-d')) ? 'nav-link active' : 'link-dark rounded' }}">Pengeluaran</a></li>
                </ul>
            </div>
        </li>
        <li>
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Data_Karyawan" aria-expanded="{{ request()->is('user/admin/datakaryawanborongan','user/admin/datakaryawan', 'user/admin/gajiankaryawan/' . \Carbon\Carbon::now()->format('Y-m-d')) ? 'true' : 'false'}}">
                Data Karyawan
            </button>
            <div class="{{ request()->is('user/admin/datakaryawanborongan', 'user/admin/datakaryawan', 'user/admin/gajiankaryawan/' . \Carbon\Carbon::now()->format('Y-m-d'), 'user/admin/gajiboronganspet/' . \Carbon\Carbon::now()->format('Y-m-d')) ? 'collapse show' : 'collapse'}}" id="Data_Karyawan">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="/user/admin/gajiankaryawan/{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="{{ request()->is('user/admin/gajiankaryawan/'.\Carbon\Carbon::now()->format('Y-m-d')) ? 'nav-link active' : 'link-dark rounded' }}">Gajian Karyawan Harian</a></li>
                    <li><a href="/user/admin/gajiboronganspet/{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="{{ request()->is('user/admin/gajiboronganspet/'. \Carbon\Carbon::now()->format('Y-m-d')) ? 'nav-link active' : 'link-dark rounded' }}">Gajian Karyawan Borongan Spet</a></li>
                    <li><a href="/user/admin/datakaryawan" class="{{ request()->is('user/admin/datakaryawan') ? 'nav-link active' : 'link-dark rounded' }}">Data Karyawan Harian</a></li>
                    <li><a href="/user/admin/datakaryawanborongan" class="{{ request()->is('user/admin/datakaryawanborongan') ? 'nav-link active' : 'link-dark rounded' }}">Data Karyawan Borongan</a></li>
                </ul>
            </div>
        </li>
        <li>
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#Nota_pemasaran" aria-expanded="{{ request()->is('user/admin/daftarRetail', 'user/admin/daftarNota') ? 'true' : 'false'}}">
                Nota Pemasaran
            </button>
            <div class="{{ request()->is('user/admin/daftarNota', 'user/admin/daftarRetail') ? 'collapse show' : 'collapse'}}" id="Nota_pemasaran">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="/user/admin/daftarNota" class="{{ request()->is('user/admin/daftarNota') ? 'nav-link active' : 'link-dark rounded' }}">Daftar Nota</a></li>
                    <li><a href="/user/admin/daftarRetail" class="{{ request()->is('user/admin/daftarRetail') ? 'nav-link active' : 'link-dark rounded' }}">Retail</a></li>
                </ul>
            </div>
        </li>
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#produksi" aria-expanded="{{ request()->is('user/admin/KelolaAkun', 'user/admin/GantiPembukuan', 'user/admin/resepwip', 'user/admin/harga_bahan_baku', 'user/admin/harga_produk') ? 'true' : 'false'}}">
                Lain-lain
            </button>
            <div class="{{ request()->is('user/admin/KelolaAkun', 'user/admin/GantiPembukuan', 'user/admin/resepwip', 'user/admin/harga_bahan_baku', 'user/admin/harga_produk') ? 'collapse show' : 'collapse'}}" id="produksi">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="/user/admin/KelolaAkun" class="{{ request()->is('user/admin/KelolaAkun') ? 'nav-link active' : 'link-dark rounded' }}">Kelola Akun</a></li>
                    {{-- <li><a href="/user/admin/GantiPembukuan" class="{{ request()->is('user/admin/GantiPembukuan') ? 'nav-link active' : 'link-dark rounded' }}">Ganti Pembukuan</a></li> --}}
                    <li><a href="/user/admin/resepwip" class="{{ request()->is('user/admin/resepwip') ? 'nav-link active' : 'link-dark rounded' }}">Resep WIP</a></li>
                    <li><a href="/user/admin/harga_bahan_baku" class="{{ request()->is('user/admin/harga_bahan_baku') ? 'nav-link active' : 'link-dark rounded' }}">Harga Bahan Baku</a></li>
                    <li><a href="/user/admin/harga_produk" class="{{ request()->is('user/admin/harga_produk') ? 'nav-link active' : 'link-dark rounded' }}">Harga Produk</a></li>
                </ul>
            </div>
        </li>
    </ul>
</div>

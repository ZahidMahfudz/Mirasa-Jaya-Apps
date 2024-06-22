<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Mirasa Jaya - Dashboard</title>

   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

   <!-- Bootstrap JavaScript (Popper.js included) -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

   <!-- Load Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <!-- Bootstrap core CSS -->
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/sidebars.css') }}" rel="stylesheet">
</head>
<body>
<main>
    <div class="flex-column flex-shrink-0 p-3 scrollable-div" style="background-color: #d4bd0f;">
        <p>login as : {{ Auth::user()->name }} Role : {{ Auth::user()->role }}</p>
        <img src="/logo_perusahaan.png" alt="Logo Mirasa Jaya" width="120" height="57" class="align: center; mb-1">
        <p class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
            <span class="fs-5 fw-bold">CV. Mirasa Jaya Magelang</span>
        </p>
        <ul class="list-unstyled ps-0">
            <li class="mb-1">
                <a href="dasboard" class="btn btn-toggle" aria-expanded="true">
                    Dashboard
                </a>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#rugilaba" aria-expanded="true">
                    Neraca dan Rugi Laba
                </button>
                <div class="collapse" id="rugilaba">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="#" class="link-dark rounded">Neraca</a></li>
                        <li><a href="#" class="link-dark rounded">Laporan Rugi Laba</a></li>
                </div>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#keuangan" aria-expanded="true">
                    Keuangan
                </button>
                <div class="collapse" id="keuangan">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="#" class="link-dark rounded">Modal</a></li>
                        <li><a href="#" class="link-dark rounded">Kas</a></li>
                        <li><a href="/user/owner/uangmasuk" class="link-dark rounded">Uang Masuk</a></li>
                        <li><a href="/user/owner/piutang" class="link-dark rounded">Piutang</a></li>
                        <li><a href="#" class="link-dark rounded">Aset Mesin dan Peralatan</a></li>
                        <li><a href="/user/owner/hutangbahanbaku" class="link-dark rounded">Hutang Bahan Baku</a></li>
                </div>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#stok" aria-expanded="true">
                    Produksi
                </button>
                <div class="collapse" id="stok">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="/user/owner/laporanproduksi" class="link-dark rounded">Laporan Produksi</a></li>
                        <li><a href="/user/owner/stokrotijadi" class="link-dark rounded">Stok Roti Jadi</a></li>
                        <li><a href="/user/owner/stokbb" class="link-dark rounded">Stok Bahan Baku, bahan penolong, dan wip</a></li>
                        <li><a href="/user/owner/stokkardus" class="link-dark rounded">Stok Kardus</a></li>
                </div>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#laporanpemasaran" aria-expanded="true">
                    Laporan Pemasaran
                </button>
                <div class="collapse {{ request()->is('user/owner/rekapitulasipenjualan') ? 'show' : '' }}" id="laporanpemasaran">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="/user/owner/rekapitulasipenjualan" class="link-dark rounded" >Rekapitulasi Pemasaran</a></li>
                    </ul>
                </div>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#bebanusaha" aria-expanded="true">
                    Beban Usaha
                </button>
                <div class="collapse" id="bebanusaha">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="#" class="link-dark rounded">Pembelian Bahan Baku</a></li>
                        <li><a href="#" class="link-dark rounded">Akomodasi Produksi</a></li>
                        <li><a href="#" class="link-dark rounded">Akomodasi Pemasaran</a></li>
                        <li><a href="#" class="link-dark rounded">Pembelian Spare Part</a></li>
                        <li><a href="#" class="link-dark rounded">Perawatan Alat Produksi</a></li>
                        <li><a href="#" class="link-dark rounded">Pembelian Mesin & Alat Produksi</a></li>
                        <li><a href="#" class="link-dark rounded">Gaji Karyawan</a></li>
                        <li><a href="#" class="link-dark rounded">Gaji Direksi & Akomodasi Owner</a></li>
                        <li><a href="#" class="link-dark rounded">Profit Owner</a></li>
                        <li><a href="#" class="link-dark rounded">Biaya Makan & Minum</a></li>
                        <li><a href="#" class="link-dark rounded">Biaya Listrik</a></li>
                        <li><a href="#" class="link-dark rounded">Bunga Bank & Pajak</a></li>
                        <li><a href="#" class="link-dark rounded">Kepentingan Sosial & Kesehatan Karyawan</a></li>
                        <li><a href="#" class="link-dark rounded">R&D</a></li>
                        <li><a href="#" class="link-dark rounded">Sewa Tempat</a></li>
                        <li><a href="#" class="link-dark rounded">Project</a></li>
                        <li><a href="#" class="link-dark rounded">THR & Bingkisan Lebaran</a></li>
                        <li><a href="#" class="link-dark rounded">Profit Sharing</a></li>
                    </ul>
                </div>
            </li>
            <li class="border-top my-3"></li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="true">
                    Account
                </button>
                <div class="collapse" id="account-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="#" class="link-dark rounded">Profile</a></li>
                        <li><a href="/logout" class="link-dark rounded">Sign out</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light scrollable" style="width: 80%; overflow-y: auto;">
        @yield('main_content')
    </div>
</main>


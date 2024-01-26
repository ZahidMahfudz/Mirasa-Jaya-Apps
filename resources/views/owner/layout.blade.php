<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Mirasa Jaya - Dashboard</title>

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
                <a href="owner/dasboard" class="btn btn-toggle" aria-expanded="true">
                    Dashboard
                </a>
            </li>
            <li class="mb-1">
                <a href="#" class="btn btn-toggle" aria-expanded="true">
                    Neraca
                </a>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
                    Rugi Laba
                </button>
                <div class="collapse show" id="home-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="#" class="link-dark rounded">Neraca Saldo</a></li>
                        <li><a href="#" class="link-dark rounded">Laporan Rugi Laba</a></li>
                        <li><a href="#" class="link-dark rounded">Laporan Perubahan Modal</a></li>
                </div>
            </li>
            <li class="mb-1">
                <a href="#" class="btn btn-toggle" aria-expanded="true">
                    Uang Masuk
                </a>
            </li>
            <li class="mb-1">
                <a href="#" class="btn btn-toggle" aria-expanded="true">
                    Piutang Usaha
                </a>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
                    Kas
                </button>
                <div class="collapse show" id="home-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="#" class="link-dark rounded">Kas (Liquid)</a></li>
                        <li><a href="#" class="link-dark rounded">Kas Rekening Bank</a></li>
                </div>
            </li>
            <li class="mb-1">
                <a href="#" class="btn btn-toggle" aria-expanded="true">
                    Modal
                </a>
            </li>
            <li class="mb-1">
                <a href="#" class="btn btn-toggle" aria-expanded="true">
                    Aset Mesin dan Peralatan
                </a>
            </li>
            <li class="mb-1">
                <a href="#" class="btn btn-toggle" aria-expanded="true">
                    Laporan Produksi
                </a>
            </li>
            <li class="mb-1">
                <a href="#" class="btn btn-toggle" aria-expanded="true">
                    Stok Roti Jadi
                </a>
            </li>
            <li class="mb-1">
                <a href="#" class="btn btn-toggle" aria-expanded="true">
                    Laporan Produksi
                </a>
            </li>
            <li class="mb-1">
                <a href="#" class="btn btn-toggle" aria-expanded="true">
                    Hutang Bahan Baku
                </a>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
                    Stok
                </button>
                <div class="collapse show" id="home-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="#" class="link-dark rounded">Stok Bahan Baku dan Kardus</a></li>
                        <li><a href="#" class="link-dark rounded">Stok Bahan Penolong</a></li>
                        <li><a href="#" class="link-dark rounded">Stok Kardus</a></li>
                        <li><a href="#" class="link-dark rounded">Work In Progress (WIP)</a></li>
                </div>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
                    Laporan Pemasaran
                </button>
                <div class="collapse show" id="home-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="#" class="link-dark rounded">Penjualan</a></li>
                        <li><a href="#" class="link-dark rounded">Nota Penjualan</a></li>
                </div>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
                    Beban Usaha
                </button>
                <div class="collapse show" id="home-collapse">
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
                <div class="collapse show" id="account-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="#" class="link-dark rounded">Profile</a></li>
                        <li><a href="/logout" class="link-dark rounded">Sign out</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 79%;">
        @yield('main_content')
    </div>
</main>


{{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-dpVz0Ia5PaE5HJvXR5eF5nGQs54N98YRYJvsVp/6zpEMxVxd93QT3LGAVFDaPWA" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-eNpEnSVu+AFtCUGOIIJ8l7luPeHEGTsxmKfDQVwSPWXb+1BDkGNqQ8t5b9N2b8Kn" crossorigin="anonymous"></script>

<!-- Your custom script for initializing Bootstrap components -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Select all elements with data-bs-toggle="collapse"
        var collapseTriggerList = document.querySelectorAll('[data-bs-toggle="collapse"]');

        // Iterate over each collapse element
        collapseTriggerList.forEach(function (collapseTrigger) {
            // Add a click event listener to toggle the collapse
            collapseTrigger.addEventListener('click', function () {
                var targetId = this.getAttribute('data-bs-target'); // Get the target ID from data-bs-target attribute
                var targetElement = document.querySelector(targetId); // Find the target element

                // Toggle the collapse on the target element
                var bsCollapse = new bootstrap.Collapse(targetElement);
                bsCollapse.toggle();
            });
        });
    });
</script> --}}

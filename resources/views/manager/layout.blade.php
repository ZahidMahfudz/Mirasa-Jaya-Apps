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
                <a href="/user/manager/dasboard" class="btn btn-toggle" aria-expanded="true">
                    Dashboard
                </a>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#produksi" aria-expanded="true">
                    Produksi
                </button>
                <div class="collapse" id="produksi">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="/user/manager/resumeproduksi" class="link-dark rounded">Resume Produksi</a></li>
                        <li><a href="/user/manager/stokbb" class="link-dark rounded">Stok Bahan Baku dan Penolong</a></li>
                        <li><a href="/user/manager/kardus" class="link-dark rounded">Stok kardus</a></li>
                        <li><a href="/user/manager/resepwip" class="link-dark rounded">Resep WIP</a></li>
                        <li><a href="/user/manager/harga_bahan_baku" class="link-dark rounded">Harga Bahan Baku</a></li>
                        <li><a href="/user/manager/harga_produk" class="link-dark rounded">Harga Produk</a></li>
                    </ul>
                </div>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#pemasaran" aria-expanded="true">
                    Pemasaran
                </button>
                <div class="collapse" id="pemasaran">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="/user/manager/rekappemasaran" class="link-dark rounded">Rekapitulasi Pemasaran</a></li>
                    </ul>
                </div>
            </li>
            <li class="mb-1">
                <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#keuangan" aria-expanded="true">
                    Keuangan
                </button>
                <div class="collapse" id="keuangan">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="#" class="link-dark rounded">Kas</a></li>
                        <li><a href="/user/manager/piutang" class="link-dark rounded">Piutang Usaha</a></li>
                        <li><a href="/user/manager/uang_masuk" class="link-dark rounded">Uang Masuk</a></li>
                        <li><a href="/user/manager/hutang_bahan_baku" class="link-dark rounded">Hutang Bahan Baku</a></li>
                        <li><a href="#" class="link-dark rounded">Aset Mesin dan Peralatan Produksi</a></li>
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

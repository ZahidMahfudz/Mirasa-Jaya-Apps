<head>
    <link href="{{ asset('css/sidebars.css') }}" rel="stylesheet">
</head>

<div class="flex-column flex-shrink-0 p-3 scrollable-div overflow-auto" style="width: 280px; height: 100%; background-color: #d4bd0f;">
    <p style="margin-bottom: 0%;">login as : {{ Auth::user()->name }}</p>
    <p class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">Role : {{ Auth::user()->role }}</p>

    <ul class="nav nav-pills flex-column mb-auto ps-0">
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#produksi" aria-expanded="{{ request()->is('#') ? 'true' : 'false'}}">
                Menu
            </button>
            <div class="{{ request()->is('user/pemasaran/preorder/' . Auth::user()->name) || request()->is('user/pemasaran/dasboard') ? 'collapse show' : 'collapse'}}" id="produksi">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="/user/pemasaran/dasboard" class="{{ request()->is('user/pemasaran/dasboard') ? 'nav-link active' : 'link-dark rounded' }}">Dashboard</a></li>
                    <li><a href="/user/pemasaran/preorder/{{ Auth::user()->name }}" class="{{ request()->is('user/pemasaran/preorder/'.Auth::user()->name) ? 'nav-link active' : 'link-dark rounded' }}">Pre-order</a></li>
                </ul>
            </div>
    </ul>
</div>

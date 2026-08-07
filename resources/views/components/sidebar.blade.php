<aside class="app-sidebar">

    <div class="sidebar-brand">
        <h1 class="sidebar-brand-title">Sparepart Manager</h1>
        <p class="sidebar-brand-subtitle">Industrial Solutions</p>
    </div>

    <nav class="sidebar-nav">

        {{-- General --}}
        <p class="sidebar-group-label">General</p>

        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }} js-disable-link">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>

        {{-- Master Data --}}
        <p class="sidebar-group-label">Master Data</p>

        @if (auth()->user()->role === 'manager')
            <a href="{{ route('users.index') }}"
                class=" js-disable-link sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">

                <i class="bi bi-person"></i>
                <span>User</span>

            </a>
        @endif

        <a href="{{ route('kategori.index') }}"
            class="js-disable-link sidebar-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i>
            <span>Kategori</span>
        </a>

        <a href="{{ route('brand.index') }}" class="js-disable-link sidebar-link {{ request()->routeIs('brand.*') ? 'active' : '' }}">
            <i class="bi bi-bookmark-star"></i>
            <span>Brand</span>
        </a>

        <a href="{{ route('unit.index') }}" class="js-disable-link sidebar-link {{ request()->routeIs('unit.*') ? 'active' : '' }}">
            <i class="bi bi-rulers"></i>
            <span>Unit</span>
        </a>

        <a href="{{ route('supplier.index') }}"
            class="js-disable-link sidebar-link {{ request()->routeIs('supplier.*') ? 'active' : '' }}">
            <i class="bi bi-truck"></i>
            <span>Supplier</span>
        </a>

        <a href="{{ route('spareparts.index') }}"
            class="js-disable-link sidebar-link {{ request()->routeIs('spareparts.*') ? 'active' : '' }}">
            <i class="bi bi-tools"></i>
            <span>Sparepart</span>
        </a>

        {{-- Transaksi --}}
        <button class="js-disable-link sidebar-group-toggle {{ request()->routeIs('transaksi.*') ? '' : 'collapsed' }}" type="button"
            data-bs-toggle="collapse" data-bs-target="#menuTransaksi">

            <span>Transaksi</span>

            <i class="bi bi-chevron-down sidebar-group-toggle-icon"></i>

        </button>

        <div class="js-disable-link collapse {{ request()->routeIs('transaksi.*') ? 'show' : '' }}" id="menuTransaksi">

            <a href="{{ route('transaksi.barang-masuk') }}"
                class="js-disable-link sidebar-link sidebar-link-sub {{ request()->routeIs('transaksi.barang-masuk') ? 'active' : '' }}">

                <i class="bi bi-box-arrow-in-down"></i>
                <span>Barang Masuk</span>

            </a>

            <a href="{{ route('transaksi.barang-keluar') }}"
                class="js-disable-link sidebar-link sidebar-link-sub {{ request()->routeIs('transaksi.barang-keluar') ? 'active' : '' }}">

                <i class="bi bi-box-arrow-up"></i>
                <span>Barang Keluar</span>

            </a>

            <a href="{{ route('transaksi.riwayat') }}"
                class="js-disable-link sidebar-link sidebar-link-sub {{ request()->routeIs('transaksi.riwayat') ? 'active' : '' }}">

                <i class="bi bi-clock-history"></i>
                <span>Riwayat Transaksi</span>

            </a>

        </div>

    </nav>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="sidebar-link sidebar-button">
                <i class="bi bi-box-arrow-right"></i>
                <span>Log Out</span>
            </button>
        </form>

    </div>

</aside>

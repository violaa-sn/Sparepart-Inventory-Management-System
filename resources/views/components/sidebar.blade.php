<aside class="app-sidebar">

    <div class="sidebar-brand">
        <h1 class="sidebar-brand-title">Sparepart Manager</h1>
        <p class="sidebar-brand-subtitle">Industrial Solutions</p>
    </div>

    <nav class="sidebar-nav">

        {{-- General --}}
        <p class="sidebar-group-label">General</p>

        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>

        {{-- Master Data --}}
        <p class="sidebar-group-label">Master Data</p>

        <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-person"></i>
            <span>User</span>
        </a>

        <a href="{{ route('kategori.index') }}"
            class="sidebar-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i>
            <span>Kategori</span>
        </a>

        <a href="{{ route('brand.index') }}" class="sidebar-link {{ request()->routeIs('brand.*') ? 'active' : '' }}">
            <i class="bi bi-bookmark-star"></i>
            <span>Brand</span>
        </a>

        <a href="{{ route('unit.index') }}" class="sidebar-link {{ request()->routeIs('unit.*') ? 'active' : '' }}">
            <i class="bi bi-rulers"></i>
            <span>Unit</span>
        </a>

        <a href="{{ route('suppliers.index') }}"
            class="sidebar-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
            <i class="bi bi-truck"></i>
            <span>Supplier</span>
        </a>

        <a href="{{ route('spareparts.index') }}"
            class="sidebar-link {{ request()->routeIs('spareparts.*') ? 'active' : '' }}">
            <i class="bi bi-tools"></i>
            <span>Sparepart</span>
        </a>

        {{-- Transaksi --}}
        <button class="sidebar-group-toggle {{ request()->routeIs('transactions.*') ? '' : 'collapsed' }}"
            type="button" data-bs-toggle="collapse" data-bs-target="#menuTransaksi"
            aria-expanded="{{ request()->routeIs('transactions.*') ? 'true' : 'false' }}">

            <span>Transaksi</span>

            <i class="bi bi-chevron-down sidebar-group-toggle-icon"></i>
        </button>

        <div class="collapse {{ request()->routeIs('transactions.*') ? 'show' : '' }}" id="menuTransaksi">

            <a href="{{ route('transactions.in') }}"
                class="sidebar-link sidebar-link-sub {{ request()->routeIs('transactions.in') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-in-down"></i>
                <span>Barang Masuk</span>
            </a>

            <a href="{{ route('transactions.out') }}"
                class="sidebar-link sidebar-link-sub {{ request()->routeIs('transactions.out') ? 'active' : '' }}">
                <i class="bi bi-box-arrow-up"></i>
                <span>Barang Keluar</span>
            </a>

            <a href="{{ route('transactions.history') }}"
                class="sidebar-link sidebar-link-sub {{ request()->routeIs('transactions.history') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Riwayat</span>
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

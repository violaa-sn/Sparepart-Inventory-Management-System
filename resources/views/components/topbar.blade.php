{{--
    Komponen Topbar
    ---------------
    Judul halaman dioper lewat @section('page-title') dari masing-masing view.
    Data user (nama, email, foto) masih statis, nanti tinggal ganti ke Auth::user().
--}}
<header class="app-topbar">
    <div>
        <h2 class="topbar-title">@yield('page-title', 'Dashboard')</h2>
    </div>

    <div class="topbar-profile">
        <div class="topbar-avatar">V</div>
        <div class="topbar-profile-text d-none d-md-block">
            <p class="topbar-profile-name">Viola Sabrina Nait</p>
            <p class="topbar-profile-email">violasabrina270308@gmail.com</p>
        </div>
    </div>
</header>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Spareparts Inventory System</title>

    <!-- Font  -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="login-page">

    <main class="login-wrapper">
        <div class="login-card">

            <!-- Sisi Kiri: Branding (cuma tampil di layar besar) -->
            <section class="login-brand d-none d-md-flex flex-column justify-content-between">
                <div>
                    <h1 class="brand-title">Sparepart Manager</h1>
                    <h2 class="brand-heading">
                        Presisi di setiap bagian,<br>
                        efisiensi di setiap langkah.
                    </h2>
                    <p class="brand-desc">
                        Kelola aset industri dan rampingkan alur kerja pengadaan Anda
                        dengan solusi industri profesional kami.
                    </p>
                </div>
                <p class="brand-footer-text">Dipercaya oleh 2.000+ Fasilitas Industri</p>
            </section>

            <!-- Sisi Kanan: Form Login -->
            <section class="login-form-side">

                <!-- Header khusus mobile -->
                <div class="login-header-mobile d-md-none text-center">
                    <span class="material-symbols-outlined brand-icon-mobile">precision_manufacturing</span>
                    <h1 class="brand-title-mobile">Sparepart Manager</h1>
                    <p class="brand-subtitle-mobile">Solusi Industri</p>
                </div>

                <div class="login-form-container">
                    <div class="mb-4">
                        <h3 class="login-title">Selamat Datang Kembali</h3>
                        <p class="login-subtitle">Silakan masukkan kredensial Anda untuk mengakses dashboard inventaris.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('login.process') }}">
                        @csrf

                        <!-- Input Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <div class="input-icon-group">
                                <span class="material-symbols-outlined input-icon">mail</span>
                                <input type="email"
                                    class="form-control input-with-icon  @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" id="email" name="email"
                                    placeholder="nama@gmail.com" required>

                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                        </div>

                        <!-- Input Password -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="password" class="form-label">Password</label>
                            </div>
                            <div class="input-icon-group">
                                <span class="material-symbols-outlined input-icon">lock</span>
                                <input type="password"
                                    class="form-control input-with-icon input-with-icon-right @error('password') is-invalid @enderror"
                                    id="password" name="password" required>
                                <button type="button" class="btn-toggle-password" id="btnTogglePassword">
                                    <span class="material-symbols-outlined" id="iconTogglePassword">visibility</span>
                                </button>

                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Checkbox Ingat Saya -->
                        <div class="form-check mb-4">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>

                        <!-- Tombol Login -->
                        <button type="submit" class="btn btn-login w-100">
                            Login
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </button>
                    </form>

                    <p class="text-center login-register-text">
                        Belum punya akun?
                        <a href="#" class="link-register">silahkan hubungi manager</a>
                    </p>
                </div>
            </section>
        </div>
    </main>

    <!-- Footer bawah, cuma tampil di layar besar -->
    <footer class="login-footer d-none d-md-block">
        <div class="login-footer-inner">
            <p class="mb-0">© 2026 Sparepart Manager Industrial. Seluruh hak cipta dilindungi undang-undang.</p>
            <div class="login-footer-links">
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Syarat &amp; Ketentuan</a>
                <a href="#">Bantuan</a>
            </div>
        </div>
    </footer>

</body>

</html>

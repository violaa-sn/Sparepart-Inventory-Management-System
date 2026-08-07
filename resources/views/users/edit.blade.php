@extends('layouts.app')

@section('title', 'Edit User - Sparepart Manager')
@section('page-title', 'Edit User')

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-10">

            <section class="card-surface">
                <div class="card-surface-header d-flex justify-content-between align-items-center">
                    <h2 class="section-title mb-0">Edit User</h2>

                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                </div>

                <form class="card-surface-body" action="{{ route('users.update', $user) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="row g-4">

                        <div class="col-md-6 col-lg-4">
                            <label class="form-label text-uppercase small">
                                Kode User
                            </label>

                            <input type="text" class="form-control form-control-pill" value="{{ $user->kode_user }}"
                                disabled>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <label class="form-label text-uppercase small fw-semibold">
                                Nama User
                            </label>

                            <input type="text" class="form-control form-control-pill" name="nama_user"
                                value="{{ old('nama_user', $user->nama_user) }}">
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <label class="form-label text-uppercase small fw-semibold">
                                Email
                            </label>

                            <input type="email" class="form-control form-control-pill" name="email"
                                value="{{ old('email', $user->email) }}">
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <label class="form-label text-uppercase small fw-semibold">
                                Nomor Telepon
                            </label>

                            <input type="text" class="form-control form-control-pill" name="nomor_telepon"
                                value="{{ old('nomor_telepon', $user->nomor_telepon) }}">
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <label class="form-label text-uppercase small fw-semibold">
                                Role Akses
                            </label>

                            <select class="form-select form-select-pill" name="role">

                                <option value="manager" @selected(old('role', $user->role) == 'manager')>
                                    Manager
                                </option>

                                <option value="admin" @selected(old('role', $user->role) == 'admin')>
                                    Admin
                                </option>

                                <option value="staff" @selected(old('role', $user->role) == 'staff')>
                                    Staff
                                </option>

                            </select>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <label class="form-label text-uppercase small fw-semibold">
                                Password Baru
                            </label>

                            <div class="input-icon-group">
                                <span class="material-symbols-outlined input-icon">
                                    lock
                                </span>

                                <input type="password"
                                    class="form-control input-with-icon input-with-icon-right form-control-pill"
                                    id="password" name="password" placeholder="Kosongkan jika tidak diubah">

                                <button type="button" class="btn-toggle-password" data-target="password">

                                    <span class="material-symbols-outlined">
                                        visibility
                                    </span>

                                </button>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4">
                            <label class="form-label text-uppercase small fw-semibold">
                                Konfirmasi Password
                            </label>

                            <div class="input-icon-group">
                                <span class="material-symbols-outlined input-icon">
                                    lock
                                </span>

                                <input type="password"
                                    class="form-control input-with-icon input-with-icon-right form-control-pill"
                                    id="password_confirmation" name="password_confirmation"
                                    placeholder="Ulangi password">

                                <button type="button" class="btn-toggle-password" data-target="password_confirmation">

                                    <span class="material-symbols-outlined">
                                        visibility
                                    </span>

                                </button>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-4 d-flex align-items-end pb-1">
                            <label class="d-flex align-items-center gap-3 mb-0">

                                <span class="text-uppercase small fw-semibold">
                                    Status Aktif
                                </span>

                                <span class="toggle-switch-wrap">
                                    <input type="checkbox" name="status_user" value="aktif"
                                        {{ old('status_user', $user->status_user) == 'aktif' ? 'checked' : '' }}>

                                    <span class="toggle-switch-slider"></span>
                                </span>

                            </label>
                        </div>

                    </div>

                    <div class="mt-4 d-flex justify-content-end gap-2">

                        <a href="{{ route('users.index') }}" class="btn btn-outline-danger px-4 js-disable-link">

                            Batal
                        </a>

                        <button type="submit" class="btn btn-edit d-flex align-items-center gap-2 px-4">

                            <i class="bi bi-check-circle"></i>
                            Simpan Perubahan

                        </button>

                    </div>

                </form>
            </section>

        </div>
    </div>

@endsection

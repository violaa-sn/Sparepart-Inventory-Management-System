@extends('layouts.app')

@section('title', 'Detail User - Sparepart Manager')
@section('page-title', 'Detail User')

@section('content')

    <div class="d-flex justify-content-center">

        <div class="card-surface user-detail-card">

            <div class="card-surface-body">

                {{-- Avatar --}}
                <div class="text-center">

                    <div class="topbar-avatar detail-avatar mx-auto">
                        {{ strtoupper(substr($user->nama_user, 0, 1)) }}
                    </div>

                    <h2 class="mt-4 mb-1 fw-bold">
                        {{ $user->nama_user }}
                    </h2>

                    <p class="text-muted mb-3">
                        {{ $user->email }}
                    </p>

                    <div class="d-flex justify-content-center align-items-center gap-3">

                        {{-- Role --}}
                        @if ($user->role == 'manager')
                            <span class="badge-status badge-status-success">
                                Manager
                            </span>
                        @elseif($user->role == 'admin')
                            <span class="badge-status badge-status-info">
                                Admin
                            </span>
                        @else
                            <span class="badge-status badge-status-warning">
                                Staff
                            </span>
                        @endif

                        {{-- Status --}}
                        <span class="d-flex align-items-center gap-2">

                            <span
                                class="user-status-dot {{ $user->status_user == 'aktif' ? 'user-status-dot-active' : 'user-status-dot-inactive' }}">
                            </span>

                            <span class="user-status-text">
                                {{ ucfirst($user->status_user) }}
                            </span>

                        </span>

                    </div>

                </div>

                <hr class="my-4">

                <table class="table table-borderless detail-user-table align-middle mb-0">

                    <tbody>

                        <tr>
                            <th>Kode User</th>
                            <td>{{ $user->kode_user }}</td>
                        </tr>

                        <tr>
                            <th>Nama Lengkap</th>
                            <td>{{ $user->nama_user }}</td>
                        </tr>

                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>

                        <tr>
                            <th>No. Telepon</th>
                            <td>{{ $user->nomor_telepon }}</td>
                        </tr>

                        <tr>
                            <th>Dibuat Pada</th>
                            <td>{{ $user->created_at->format('d F Y H:i') }}</td>
                        </tr>

                        <tr>
                            <th>Terakhir Diupdate</th>
                            <td>{{ $user->updated_at->format('d F Y H:i') }}</td>
                        </tr>

                    </tbody>

                </table>

                <div class="mt-4 d-flex justify-content-end">

                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>

                </div>

            </div>

        </div>

    </div>

@endsection

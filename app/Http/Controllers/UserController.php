<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->search;

        $users = User::when($keyword, function ($query) use ($keyword) {
            $query->where('kode_user', 'like', "%{$keyword}%")
                ->orWhere('nama_user', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%")
                ->orWhere('nomor_telepon', 'like', "%{$keyword}%");
        })
            ->when($request->role, function ($query) use ($request) {
                $query->where('role', $request->role);
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        $kodeUser = User::generateKode();

        return view('users.index', compact('users', 'kodeUser'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function store(Request $request)
    {
        $data =  $request->validate([
            'nama_user' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'nomor_telepon' => 'required|string|max:13|unique:users,nomor_telepon',
            'password' => 'required|confirmed|min:8',
            'role' => 'required|in:manager,admin,staff'
        ]);

        $data['status_user'] =
            $request->has('status_user')
            ? 'aktif'
            : 'nonaktif';

        User::create($data);

        return redirect()->route('users.index')
            ->with('success', 'user berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'nama_user' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nomor_telepon' => 'required|string|max:13|unique:users,nomor_telepon,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|in:manager,admin,staff'
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $data['status_user'] = $request->has('status_user')
            ? 'aktif'
            : 'nonaktif';

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'users berhasil diperbarui');
    }

    public function toggleStatus(User $user)
    {
        if (Auth::id() === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat menonaktifkan akun yang sedang digunakan.'
            ], 403);
        }

        $user->status_user =
            $user->status_user == 'aktif'
            ? 'nonaktif'
            : 'aktif';

        $user->save();

        return response()->json([
            'success' => true,
            'status' => $user->status_user
        ]);
    }

    public function destroy(User $user)
    {
        if ($user->stokTransaksis()->exists()) {
            return back()->with(
                'error',
                'user masih digunakan oleh transaksi sehingga tidak dapat dihapus.'
            );
        }

        $user->delete();

        return back()->with('success', 'user berhasil dihapus.');
    }

    public function trash(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $users = User::onlyTrashed()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('kode_user', 'like', "%{$search}%")
                        ->orWhere('nama_user', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('nomor_telepon', 'like', "%{$search}%");
                });
            })

            ->when($request->role, function ($query) use ($request) {
                $query->where('role', $request->role);
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'users.trash',
            compact('users')
        );
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.trash')
            ->with('success', 'user berhasil dipulihkan.');
    }

    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        $user->forceDelete();

        return redirect()->route('users.trash')
            ->with('success', 'user berhasil dihapus permanen.');
    }
}

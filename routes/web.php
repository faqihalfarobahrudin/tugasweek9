<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route Logout cepat via GET untuk memudahkan pengujian
Route::get('/keluar', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
});

// Semua role yang sudah login (Admin, Dosen, Mahasiswa)[cite: 8, 14]
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        return "Dashboard Utama — Halo, {$user->name} (Role: {$user->role})";
    })->name('dashboard');

    Route::get('/materi', function () {
        return 'Halaman Lihat Materi (Bisa diakses Admin, Dosen, Mahasiswa)';
    });

    // Route bawaan Breeze untuk profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Khusus Admin[cite: 7, 8, 14]
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', function () {
        return 'Halaman Manajemen Pengguna (Khusus Admin)';
    });
});

// Admin dan Dosen[cite: 7, 8, 14]
Route::middleware(['auth', 'role:admin,dosen'])->group(function () {
    Route::get('/kelola-materi', function () {
        return 'Halaman Kelola Materi (Admin & Dosen)';
    });

    Route::get('/kelola-nilai', function () {
        return 'Halaman Kelola Nilai (Admin & Dosen)';
    });
});

// Khusus Mahasiswa[cite: 7, 8, 14]
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/nilai-saya', function () {
        return 'Halaman Lihat Nilai Pribadi (Khusus Mahasiswa)';
    });
});

require __DIR__.'/auth.php';
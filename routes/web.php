<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LibrarianController;
use App\Http\Controllers\Admin\ReferenceTransactionController;

// Root redirect
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Admin Auth
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Dashboard
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

// Librarians
Route::get('/admin/librarians',                        [LibrarianController::class, 'index'])->name('admin.librarians.index');
Route::get('/admin/librarians/create',                 [LibrarianController::class, 'create'])->name('admin.librarians.create');
Route::post('/admin/librarians',                       [LibrarianController::class, 'store'])->name('admin.librarians.store');
Route::get('/admin/librarians/{id}',                   [LibrarianController::class, 'show'])->name('admin.librarians.show');
Route::get('/admin/librarians/{id}/edit',              [LibrarianController::class, 'edit'])->name('admin.librarians.edit');
Route::put('/admin/librarians/{id}',                   [LibrarianController::class, 'update'])->name('admin.librarians.update');
Route::patch('/admin/librarians/{id}/role',            [LibrarianController::class, 'updateRole'])->name('admin.librarians.updateRole');
Route::delete('/admin/librarians/{id}',                [LibrarianController::class, 'destroy'])->name('admin.librarians.destroy');

// Reference Transactions
Route::get('/admin/transactions',                      [ReferenceTransactionController::class, 'index'])->name('admin.transactions.index');
Route::get('/admin/transactions/create',               [ReferenceTransactionController::class, 'create'])->name('admin.transactions.create');
Route::post('/admin/transactions',                     [ReferenceTransactionController::class, 'store'])->name('admin.transactions.store');
Route::get('/admin/transactions/{id}',                 [ReferenceTransactionController::class, 'show'])->name('admin.transactions.show');
Route::get('/admin/transactions/{id}/edit',            [ReferenceTransactionController::class, 'edit'])->name('admin.transactions.edit');
Route::put('/admin/transactions/{id}',                 [ReferenceTransactionController::class, 'update'])->name('admin.transactions.update');
Route::delete('/admin/transactions/{id}',              [ReferenceTransactionController::class, 'destroy'])->name('admin.transactions.destroy');
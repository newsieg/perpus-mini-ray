<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

Route::get('/', [BookController::class, 'index']);

Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::post('/borrow/{book}', [BorrowingController::class, 'store']);
    Route::get('/borrowings/history', [BorrowingController::class, 'history']);
    Route::post('/borrowings/{id}/return', [BorrowingController::class, 'markReturn']);

    // Admin actions
    Route::get('/admin/borrowings', [AdminController::class, 'index']);
    Route::get('/admin/borrowings/history', [AdminController::class, 'history']);
    Route::get('/admin/books', function () { return view('admin.books.index'); });
    Route::get('/admin/books/create', [BookController::class, 'create']);
    Route::post('/admin/books', [BookController::class, 'store']);
    Route::get('/admin/books/{id}/edit', [BookController::class, 'edit']);
    Route::post('/admin/books/{id}/update', [BookController::class, 'update']);
    Route::post('/admin/books/{id}/delete', [BookController::class, 'destroy']);
    Route::post('/admin/borrowings/{id}/approve', [AdminController::class, 'approve']);
    Route::post('/admin/borrowings/{id}/reject', [AdminController::class, 'reject']);
    Route::post('/admin/borrowings/{id}/return', [AdminController::class, 'markReturned']);
});

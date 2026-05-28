<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookRequestController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\Route;

// ─── Public frontend ─────────────────────────────────────────────────────────

Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/katalog', [FrontendController::class, 'catalog'])->name('katalog');
Route::get('/knjiga/{book}', [FrontendController::class, 'show'])->name('knjiga.show');

// Book request form
Route::get('/knjiga/{book}/zahtev', [BookRequestController::class, 'create'])->name('requests.create');
Route::post('/knjiga/{book}/zahtev', [BookRequestController::class, 'store'])->name('requests.store');
Route::get('/zahtev-potvrda', [FrontendController::class, 'confirmation'])->name('requests.confirmation');

// Legacy aliases so old /books links still work
Route::redirect('/books', '/katalog', 301);
Route::get('/books/{book}', function ($book) {
    return redirect()->route('knjiga.show', $book, 301);
});

// ─── Auth ──────────────────────────────────────────────────────────────────

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── Admin protected routes ───────────────────────────────────────────────

Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Books
    Route::resource('books', BookController::class)->except(['index']);
    Route::get('/books', [BookController::class, 'index'])->name('books.index');

    // Borrowings
    Route::get('/borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
    Route::get('/borrowings/all', [BorrowingController::class, 'all'])->name('borrowings.all');
    Route::get('/borrowings/overdue', [BorrowingController::class, 'overdue'])->name('borrowings.overdue');
    Route::get('/borrowings/create', [BorrowingController::class, 'create'])->name('borrowings.create');
    Route::post('/borrowings', [BorrowingController::class, 'store'])->name('borrowings.store');
    Route::patch('/borrowings/{borrowing}/return', [BorrowingController::class, 'markReturned'])->name('borrowings.return');

    // Categories
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Book requests
    Route::get('/zahtevi', [BookRequestController::class, 'adminIndex'])->name('requests.index');
    Route::patch('/zahtevi/{bookRequest}/obrada', [BookRequestController::class, 'adminUpdate'])->name('requests.update');
});

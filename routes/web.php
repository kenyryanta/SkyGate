<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

// Web Routes
Route::get('/', [ViewController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('show.login')->middleware(['guest:customers','guest:web']);
Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware(['guest:customers','guest:web']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:customers');

Route::get('/register', [AuthController::class, 'showRegister'])->name('show.register')->middleware(['guest:customers','guest:web']);
Route::post('/register', [AuthController::class, 'register'])->name('register')->middleware(['guest:customers','guest:web']);

// Flight Routes
Route::prefix('flights')->name('flights.')->group(function () {
    Route::get('/', [FlightController::class, 'index'])->name('index');
    Route::get('/search', [FlightController::class, 'search'])->name('search');
    Route::get('/{id}', [FlightController::class, 'show'])->name('show');
    Route::get('/{id}/booking', [FlightController::class, 'bookingForm'])->name('booking.form')->middleware('auth:customers');
    Route::post('/{id}/booking', [FlightController::class, 'processBooking'])->name('booking.process')->middleware('auth:customers');
});
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index')->middleware('auth:customers');

Route::post('/api/promo-codes/validate', [FlightController::class, 'validatePromoCode']);
// Route untuk menampilkan detail transaksi
Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show')->middleware('auth:customers');
// Route untuk menampilkan halaman pembayaran
Route::get('/transactions/{transaction}/payment', [TransactionController::class, 'showPayment'])->name('transactions.payment')->middleware('auth:customers');
// Route untuk menangani notifikasi dari Midtrans (webhook)
Route::post('transactions/notification', [TransactionController::class, 'handleNotification'])
    ->name('transactions.notification');

Route::get('/download-ticket/{id}', [TransactionController::class, 'download'])->name('ticket.download');

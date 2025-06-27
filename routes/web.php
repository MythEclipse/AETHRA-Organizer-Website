<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FiturController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ServiceController;

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('fiturs', FiturController::class);
    Route::resource('pakets', PaketController::class);

    Route::get('/checkout/{paket}', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/my-transactions', [CheckoutController::class, 'myTransactions'])->name('my-transactions');
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('transaksis', [TransaksiController::class, 'index'])->name('transaksis.index');
    Route::get('transaksis/{transaksi}', [TransaksiController::class, 'show'])->name('transaksis.show');
    Route::put('transaksis/{transaksi}/status', [TransaksiController::class, 'updateStatus'])->name('transaksis.updateStatus');

    route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('services', [ServiceController::class, 'index'])->name('services.index');
    Route::put('services/{service}', [ServiceController::class, 'update'])->name('services.update');
});
require __DIR__ . '/auth.php';

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FiturController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GalleryLikeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\User\ConversationController as UserConversationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;


Route::get('/', [LandingController::class, 'index'])->name('landing');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('fiturs', FiturController::class);
    Route::resource('pakets', PaketController::class);

    Route::get('/checkout/{paket}', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/my-transactions', [CheckoutController::class, 'myTransactions'])->name('my-transactions');

    Route::resource('galleries', GalleryController::class);

    Route::post('/gallery/{gallery}/like', [GalleryLikeController::class, 'store'])->name('gallery.like');

    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
    Route::prefix('user')->name('user.')->group(function () {
        // ... (route my-transactions jika ada)
        Route::get('/conversations', [UserConversationController::class, 'index'])->name('conversations.index');
        Route::get('/conversations/{conversation}', [UserConversationController::class, 'show'])->name('conversations.show');
    });
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('transaksis', [TransaksiController::class, 'index'])->name('transaksis.index');
    Route::get('transaksis/{transaksi}', [TransaksiController::class, 'show'])->name('transaksis.show');
    Route::put('transaksis/{transaksi}/status', [TransaksiController::class, 'updateStatus'])->name('transaksis.updateStatus');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('services', [ServiceController::class, 'index'])->name('services.index');
    Route::put('services/{service}', [ServiceController::class, 'update'])->name('services.update');

    Route::get('about', [AboutController::class, 'index'])->name('about.index');
    Route::put('about', [AboutController::class, 'update'])->name('about.update');
    Route::resource('users', UserController::class);
    Route::get('conversations', [ContactController::class, 'index'])->name('messages.index');
    Route::get('conversations/{conversation}', [ContactController::class, 'show'])->name('messages.show');
    Route::delete('conversations/{conversation}', [ContactController::class, 'destroy'])->name('messages.destroy');
    Route::post('conversations/{conversation}/reply', [ContactController::class, 'storeReply'])->name('messages.reply');

    Route::post('messages/{message}/toggle-star', [ContactController::class, 'toggleStar'])->name('messages.toggleStar');
});
require __DIR__ . '/auth.php';

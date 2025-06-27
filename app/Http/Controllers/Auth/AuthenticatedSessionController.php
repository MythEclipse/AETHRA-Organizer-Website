<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    // app/Http/Controllers/Auth/AuthenticatedSessionController.php

    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Lakukan proses autentikasi seperti biasa
        $request->authenticate();

        // 2. Buat sesi baru
        $request->session()->regenerate();

        // --- MODIFIKASI DIMULAI DARI SINI ---

        // 3. Dapatkan data user yang baru saja login
        $user = $request->user();

        // 4. Cek jika role user adalah 'admin'
        if ($user->role === 'admin') {
            // Jika ya, arahkan ke dashboard admin
            return redirect()->route('admin.dashboard');
        }

        // 5. Jika bukan admin, gunakan perilaku default (arahkan ke dashboard biasa)
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

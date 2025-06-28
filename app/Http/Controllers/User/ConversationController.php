<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    /**
     * Menampilkan daftar percakapan utama milik pengguna yang sedang login.
     */
    public function index()
    {
        $conversations = Conversation::where('user_id', Auth::id())
                                    ->whereNull('parent_id') // Hanya tampilkan pesan utama (induk)
                                    ->latest()
                                    ->paginate(10);

        return view('user.conversations.index', compact('conversations'));
    }

    /**
     * Menampilkan detail satu percakapan lengkap dengan balasannya.
     */
    public function show(Request $request, Conversation $conversation)
    {
        // Otorisasi: pastikan user hanya bisa melihat percakapannya sendiri
        if (Auth::id() !== $conversation->user_id) {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }

        // Jika ada parameter notifikasi di URL, tandai sebagai sudah dibaca
        if ($request->has('notify_id')) {
            $notification = Auth::user()->notifications()->find($request->notify_id);
            if ($notification) {
                $notification->markAsRead();
            }
        }

        return view('user.conversations.show', compact('conversation'));
    }
}

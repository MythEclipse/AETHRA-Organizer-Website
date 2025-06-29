<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AdminReplyNotification;

class ContactController extends Controller
{
    /**
     * Menyimpan pesan dari form kontak di halaman depan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Conversation::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return redirect('/#contact')->with('success', 'Pesan Anda telah berhasil terkirim! Kami akan segera menghubungi Anda.');
    }

    /**
     * Menampilkan daftar pesan untuk admin.
     */
    public function index(Request $request)
    {
        // Ambil semua pesan sebagai query builder, abaikan yang subject-nya diawali 'Re:'
        $query = Conversation::where('subject', 'not like', 'Re:%')->latest();

        // Cek apakah ada parameter 'filter' di URL dan nilainya 'starred'
        if ($request->filter == 'starred') {
            $query->where('is_starred', true);
        }

        // Eksekusi query dengan pagination
        $conversations = $query->paginate(15);

        $unreadCount = Conversation::where('is_read', false)
            ->where('subject', 'not like', 'Re:%')
            ->count();

        // Kirim juga filter saat ini ke view untuk menandai menu yang aktif
        $currentFilter = $request->filter;

        return view('admin.messages.index', compact('conversations', 'unreadCount', 'currentFilter'));
    }
    public function toggleStar(Conversation $conversation)
    {
        // Ubah status is_starred menjadi kebalikannya (true -> false, false -> true)
        $conversation->update(['is_starred' => !$conversation->is_starred]);

        return response()->json([
            'is_starred' => $conversation->is_starred
        ]);
    }

    /**
     * Menampilkan detail satu pesan dan menandainya sebagai "sudah dibaca".
     */
    public function show(Request $request, Conversation $conversation)
    {
        // Tandai pesan sebagai sudah dibaca jika belum
        if (!$conversation->is_read) {
            $conversation->update(['is_read' => true]);
        }

        // Jika ada parameter notifikasi di URL, tandai sebagai sudah dibaca
        if ($request->has('notify_id')) {
            $notification = Auth::user()->notifications()->find($request->notify_id);
            if ($notification) {
                $notification->markAsRead();
            }
        }

        return view('admin.messages.show', compact('conversation'));
    }
    public function showuser(Request $request, Conversation $conversation)
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

        // Tampilkan view seperti biasa
        return view('user.conversations.show', compact('conversation'));
    }
    public function storeReply(Request $request, Conversation $conversation)
    {
        $request->validate(['message' => 'required|string']);

          $reply = Conversation::create([
            'parent_id'      => $conversation->id,
            'user_id'        => $conversation->user_id, // Tetap user_id dari percakapan asli
            'name'           => Auth::user()->name,      // <-- TAMBAHKAN NAMA ADMIN
            'email'          => Auth::user()->email,     // <-- TAMBAHKAN EMAIL ADMIN
            'subject'        => 'Re: ' . $conversation->subject,
            'message'        => $request->message,
            'is_admin_reply' => true,
        ]);
        $conversation->user->notify(new AdminReplyNotification($reply));

        return redirect()->back()->with('success', 'Balasan berhasil dikirim.');
    }
    /**
     * Menghapus pesan.
     */
    public function destroy(Conversation $conversation)
    {
        $conversation->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Pesan berhasil dihapus.');
    }
     
}

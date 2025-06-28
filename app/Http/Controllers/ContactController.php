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
        // Ambil semua pesan sebagai query builder
        $query = Conversation::latest();

        // Cek apakah ada parameter 'filter' di URL dan nilainya 'starred'
        if ($request->filter == 'starred') {
            $query->where('is_starred', true);
        }

        // Eksekusi query dengan pagination
        $messages = $query->paginate(15);

        $unreadCount = Conversation::where('is_read', false)->count();

        // Kirim juga filter saat ini ke view untuk menandai menu yang aktif
        $currentFilter = $request->filter;

        return view('admin.messages.index', compact('messages', 'unreadCount', 'currentFilter'));
    }
    public function toggleStar(Conversation $message)
    {
        // Ubah status is_starred menjadi kebalikannya (true -> false, false -> true)
        $message->update(['is_starred' => !$message->is_starred]);

        return response()->json([
            'is_starred' => $message->is_starred
        ]);
    }

    /**
     * Menampilkan detail satu pesan dan menandainya sebagai "sudah dibaca".
     */
    public function show(Request $request, Conversation $conversation)
    {
        // Cek otorisasi, pastikan user hanya bisa melihat percakapannya sendiri
        if (Auth::user()->id !== $conversation->user_id) {
            abort(403);
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

        // Buat record balasan baru
        $reply = Conversation::create([
            'parent_id' => $conversation->id,
            'user_id' => $conversation->user_id, // Balasan ditujukan untuk user yang sama
            'subject' => 'Re: ' . $conversation->subject,
            'message' => $request->message,
            'is_admin_reply' => true, // Tandai ini sebagai balasan admin
        ]);

        // Kirim notifikasi ke user yang memulai percakapan
        $conversation->user->notify(new AdminReplyNotification($reply));

        return redirect()->back()->with('success', 'Balasan berhasil dikirim.');
    }
    /**
     * Menghapus pesan.
     */
    public function destroy(Conversation $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Pesan berhasil dihapus.');
    }
}

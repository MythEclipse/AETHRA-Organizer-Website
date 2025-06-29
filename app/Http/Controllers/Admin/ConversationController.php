<?php

namespace App\Http\Controllers\Admin; // <-- Perhatikan namespace

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Notifications\AdminReplyNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function index(Request $request)
    {
        // PERBAIKAN: Gunakan whereNull('parent_id') untuk mendapatkan pesan utama
        $query = Conversation::whereNull('parent_id')->with('user')->latest();

        if ($request->filter == 'starred') {
            $query->where('is_starred', true);
        }

        $messages = $query->paginate(15);

        // PERBAIKAN: Gunakan query yang sama untuk menghitung pesan belum dibaca
        $unreadCount = Conversation::whereNull('parent_id')->where('is_read', false)->count();

        $currentFilter = $request->filter;

        return view('admin.messages.index', compact('messages', 'unreadCount', 'currentFilter'));
    }

    public function show(Conversation $conversation)
    {
        if (!$conversation->is_read) {
            $conversation->update(['is_read' => true]);
        }
        return view('admin.messages.show', compact('conversation'));
    }

    public function storeReply(Request $request, Conversation $conversation)
    {
        $request->validate(['message' => 'required|string']);

        $reply = Conversation::create([
            'parent_id'      => $conversation->id,
            'user_id'        => $conversation->user_id,
            'name'           => Auth::user()->name,
            'email'          => Auth::user()->email,
            'subject'        => 'Re: ' . $conversation->subject,
            'message'        => $request->message,
            'is_admin_reply' => true,
        ]);

        $conversation->user->notify(new AdminReplyNotification($reply));
        return redirect()->back()->with('success', 'Balasan berhasil dikirim.');
    }

    public function toggleStar(Conversation $conversation)
    {
        $conversation->update(['is_starred' => !$conversation->is_starred]);
        return response()->json(['is_starred' => $conversation->is_starred]);
    }

    public function destroy(Conversation $conversation)
    {
        $conversation->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Percakapan berhasil dihapus.');
    }

    public function checkNewMessages()
    {
        // PERBAIKAN: Gunakan whereNull('parent_id')
        $unreadCount = Conversation::whereNull('parent_id')->where('is_read', false)->count();
        return response()->json(['unread_count' => $unreadCount]);
    }
}

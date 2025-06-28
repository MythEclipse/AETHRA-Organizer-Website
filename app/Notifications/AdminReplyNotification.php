<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Conversation; // Import model Conversation

class AdminReplyNotification extends Notification
{
    use Queueable;

    protected $reply;

    public function __construct(Conversation $reply)
    {
        $this->reply = $reply;
    }

    public function via(object $notifiable): array
    {
        return ['database']; // Kita akan simpan notif di database
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => 'Admin telah membalas pesan Anda mengenai: "' . $this->reply->parent->subject . '"',
            'url' => route('user.conversations.show', $this->reply->parent_id), // URL untuk melihat percakapan
            'reply_id' => $this->reply->id
        ];
    }
}

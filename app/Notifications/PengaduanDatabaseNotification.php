<?php

namespace App\Notifications;

use App\Models\Pengaduan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PengaduanDatabaseNotification extends Notification
{
    use Queueable;

    public function __construct(
        private Pengaduan $pengaduan,
        private string $title,
        private string $message,
        private string $type = 'info',
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'type' => $this->type,
            'pengaduan_id' => $this->pengaduan->id,
            'url' => route('pengaduan.show', $this->pengaduan),
        ];
    }
}

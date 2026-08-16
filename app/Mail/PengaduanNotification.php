<?php

namespace App\Mail;

use App\Models\Pengaduan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengaduanNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $pengaduan;
    public $note;

    /**
     * Create a new message instance.
     */
    public function __construct(Pengaduan $pengaduan, string $note = null)
    {
        $this->pengaduan = $pengaduan;
        $this->note = $note;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = 'Pengaduan Baru: ' . ($this->pengaduan->judul ?? 'Tanpa Judul');
        if ($this->note) {
            $subject = $this->note . ' - ' . $subject;
        }

        return $this->subject($subject)
            ->view('emails.pengaduan-notification');
    }
}

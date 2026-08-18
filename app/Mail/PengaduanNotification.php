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
    public $audience;

    /**
     * @param string $audience One of: 'mahasiswa', 'admin_spmi', 'admin_unit'
     */
    public function __construct(Pengaduan $pengaduan, string $note = null, string $audience = 'admin_spmi')
    {
        $this->pengaduan = $pengaduan;
        $this->note = $note;
        $this->audience = $audience;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $judul = $this->pengaduan->judul ?? 'Tanpa Judul';

        $subject = match ($this->audience) {
            'mahasiswa' => 'Update Pengaduan Anda: ' . $judul,
            'admin_unit' => 'Pengaduan Diteruskan ke Unit Anda: ' . $judul,
            default => 'Pengaduan Baru Masuk: ' . $judul,
        };

        if ($this->note) {
            $subject = $this->note . ' - ' . $subject;
        }

        return $this->subject($subject)
            ->view('emails.pengaduan-notification')
            ->with('audience', $this->audience);
    }
}

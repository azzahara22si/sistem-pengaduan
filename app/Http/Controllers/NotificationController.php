<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function read(DatabaseNotification $notification): RedirectResponse
    {
        abort_unless(
            (int) $notification->notifiable_id === (int) Auth::id()
                && $notification->notifiable_type === Auth::user()::class,
            403
        );

        $notification->markAsRead();

        return redirect($notification->data['url'] ?? route('pengaduan.index'));
    }
}

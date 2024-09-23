<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Specialist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
class NotificationController extends Controller
{
    public function specialistNotificationMarkAsRead(string $notifactionId) : RedirectResponse
    {
        $notification=Auth::user()->specialist->notifications()->find($notifactionId);
        $notification->markAsRead();
        return  redirect()->back()->with('message', ['text' => 'Oznaczono jako przeczytane.', 'status' => 'success']);
    }

    public function userNotificationMarkAsRead(string $notifactionId) : RedirectResponse
    {
        $notification=Auth::user()->notifications()->find($notifactionId);
        $notification->markAsRead();
        return  redirect()->back()->with('message', ['text' => 'Oznaczono jako przeczytane.', 'status' => 'success']);
    }
}

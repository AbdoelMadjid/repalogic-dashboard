<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Fetch aggregated notifications via AJAX for real-time topbar update.
     */
    public function poll(Request $request): JsonResponse
    {
        $notifData = NotificationService::getNotifications();
        $unreadCount = $notifData['unread_count'];

        $html = view('layouts.partials.topbar.notification-dropdown-content', [
            'notifItems' => $notifData['items'],
            'unreadCount' => $unreadCount,
            'totalCount' => $notifData['total_count'],
        ])->render();

        return response()->json([
            'success' => true,
            'unread_count' => $unreadCount,
            'total_count' => $notifData['total_count'],
            'html' => $html,
        ]);
    }

    /**
     * Fetch user messages via AJAX for real-time topbar messages dropdown update.
     */
    public function pollMessages(Request $request): JsonResponse
    {
        $messageData = NotificationService::getUserMessages();
        $unreadCount = $messageData['unread_count'];

        $html = view('layouts.partials.topbar.simple-messages-dropdown-content', [
            'messageItems' => $messageData['items'],
            'unreadCount' => $unreadCount,
            'totalCount' => $messageData['total_count'],
        ])->render();

        return response()->json([
            'success' => true,
            'unread_count' => $unreadCount,
            'total_count' => $messageData['total_count'],
            'html' => $html,
        ]);
    }

    /**
     * Mark a specific notification as read.
     */
    public function markAsRead(Request $request, string $id): JsonResponse
    {
        $user = Auth::user();
        if ($user) {
            // Check if it's a grouped message by sender (sender- prefix)
            if (str_starts_with($id, 'sender-')) {
                $senderId = (int) str_replace('sender-', '', $id);
                \App\Models\Message::where('sender_id', $senderId)
                    ->where('receiver_id', $user->id)
                    ->where('is_read', false)
                    ->update([
                        'is_read' => true,
                        'read_at' => now(),
                    ]);
            }
            // Check if it's a single Message record (msg- prefix or numeric)
            elseif (str_starts_with($id, 'msg-') || is_numeric($id)) {
                $cleanId = str_replace('msg-', '', $id);
                $msg = \App\Models\Message::where('id', $cleanId)->where('receiver_id', $user->id)->first();
                if ($msg) {
                    $msg->update([
                        'is_read' => true,
                        'read_at' => now(),
                    ]);
                }
            }

            // Check if it's a Database Notification (db- prefix or UUID)
            $cleanDbId = str_replace('db-', '', $id);
            if (method_exists($user, 'unreadNotifications')) {
                $notification = $user->unreadNotifications()->where('id', $cleanDbId)->first();
                if ($notification) {
                    $notification->markAsRead();
                }
            }
        }

        return response()->json(['success' => true]);
    }
}

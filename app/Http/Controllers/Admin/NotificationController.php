<?php

namespace App\Http\Controllers\Admin;

use App\Events\NotificationCreated;
use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function create(Request $request)
    {
        // Создание уведомления (пример)
        $notification = auth()->user()->notifications->create([
            'data' => [
                'message' => 'Ваше уведомление успешно создано!',
            ],
        ]);

        // Вызов события
        event(new NotificationCreated($notification));

        return response()->json(['message' => 'Уведомление создано!']);
    }
    
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications->find($id);
        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->back();
    }
}

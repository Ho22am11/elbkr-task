<?php

namespace App\Services;

use App\Models\Message;
use GuzzleHttp\Psr7\Request;

class MessageServices
{

    public function getMessages($otherUserId ,  $otherUserType){
        $currentUser = auth('user')->check()
        ? auth('user')->user()
        : auth('admin')->user();

    $currentUserClass = get_class($currentUser);


    $otherUserClass = $otherUserType === 'admin'
        ? 'App\Models\Admin'
        : 'App\Models\User';

    return Message::where(function($query) use ($currentUser, $currentUserClass, $otherUserId, $otherUserClass) {
            $query->where('sender_id', $currentUser->id)
                ->where('sender_type', $currentUserClass)
                ->where('receiver_id', $otherUserId)
                ->where('receiver_type', $otherUserClass);
        })
        ->orWhere(function($query) use ($currentUser, $currentUserClass, $otherUserId, $otherUserClass) {
            $query->where('receiver_id', $currentUser->id)
                ->where('receiver_type', $currentUserClass)
                ->where('sender_id', $otherUserId)
                ->where('sender_type', $otherUserClass);
        })
        ->orderBy('created_at', 'desc')
        ->get();
    }

}

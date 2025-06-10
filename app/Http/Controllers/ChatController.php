<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Services\MessageServices;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    use ApiResponseTrait ;
    public function store(Request $request)
{
     $sender = auth('user')->check()
        ? auth('user')->user()
        : auth('admin')->user();

     $receiverType = $request->receiver_type === 'admin'
        ? 'App\\Models\\Admin'
        : 'App\\Models\\User';

    $message = Message::create([
        'sender_id' => $sender->id,
        'sender_type' => get_class($sender),
        'receiver_id' => $request->receiver_id,
        'receiver_type' => $receiverType ,
        'message' => $request->message,
    ]);

    broadcast(new MessageSent($message))->toOthers();

    return response()->json($message);
}



public function getMessages(Request $request , MessageServices $message_services)
{

    $message = $message_services->getMessages($request->otherUserId ,$request->otherUserType );

   return $this->ApiResponse(MessageResource::collection($message) , 'return message' , 200) ;
}

}

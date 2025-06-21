<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Services\MessageServices;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function store(Request $request , MessageServices $message_services)
{
     $message = $message_services->send($request);

    return $this->ApiResponse( new MessageResource($message) , 'send message' , 201) ;

}



public function getMessages(Request $request , MessageServices $message_services)
{

    $message = $message_services->getMessages($request->otherUserId ,$request->otherUserType );

   return $this->ApiResponse(MessageResource::collection($message) , 'return message' , 200) ;
}

}

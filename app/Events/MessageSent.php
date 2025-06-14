<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent   implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        $receiverType = $this->message->receiver_type;
        $receiverId = $this->message->receiver_id;

        if ($receiverType === 'App\Models\User') {
            return new PrivateChannel('user-chat.' . $receiverId);
        } elseif ($receiverType === 'App\Models\Admin') {
            return new PrivateChannel('admin-chat.' . $receiverId);
        }
        
    }

    public function broadcastAs()
    {
        return 'message-sent';
    }
}

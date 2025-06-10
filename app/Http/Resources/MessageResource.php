<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ,
            'sender_id' => $this->sender_id,
            'sender_type' => $this->sender_type,
            'receiver_id' => $this->receiver_id,
            'receiver_type' => $this->receiver_type,
             'message' => $this->message,
            'time_ago' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}

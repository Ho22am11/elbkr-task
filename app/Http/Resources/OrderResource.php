<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_name' => $this->user->frist_name.' '.$this->user->last_name,
            'status' => $this->status,
            'status_name' => $this->getStatusName(),
            'total_price' => $this->total_price,
            'items_count' => $this->orderItems->count(),
            'order_items' => OrderItemResource::collection($this->orderItems),
            'data' => $this->created_at->format('Y-m-d H:i:s'),

        ];
    }


     private function getStatusName()
    {
        $statuses = [
            'pending' => 'في الانتظار',
            'processing' => 'قيد المعالجة',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغي'
        ];
        
        return $statuses[$this->status] ?? $this->status;
    }
}

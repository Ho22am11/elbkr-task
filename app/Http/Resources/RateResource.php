<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RateResource extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        return [
            'name_user' => $this->user->frist_name.' '.$this->user->last_name,
            'rate' => $this->rating,
            'date' => $this->created_at->diffForHumans(),
            'content' => $this->content,
        ];
    }
}

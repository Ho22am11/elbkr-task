<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'price'       => $this->price,
            'campany_id'  => $this->campany_id,
            'campany_name' => $this->campany->name ,
            'campany_image' => $this->campany->img ,
            'category_id' => $this->category_id,
            'category_name' => $this->campany->name ,
            'rates' => $this->rates ? RateResource::collection($this->rates) : null,
            'avg_rating' => $this->rates_avg_rating ?  $this->rates_avg_rating : 3.5,
            'images'      => $this->attachements->map(function ($img) {
                return asset('storage/' . $img->img);
            }),
        ];
    }
}

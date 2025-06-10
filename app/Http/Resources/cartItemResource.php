<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class cartItemResource extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        return [
            'product_name' => $this->product->name ,
            'product_price' => $this->product->price ,
            'product_description' => $this->product->description ,
            'quantity' => $this->quantity,
            'export' => $this->mapState($this->export_type),
        ];
    }

    private function mapState($value)
    {
        $states = [1 => 'توريد فقط', 2 => 'توريد و تركيب بدون نحاس', 3 => 'عشره متر نحاس + توريد و تركيب'];
        return $states[$value] ?? null;
    }
}

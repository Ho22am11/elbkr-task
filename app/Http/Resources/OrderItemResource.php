<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
         return [
            'id' => $this->id,
            'product_name' => $this->product->name,
            'product_price' => $this->product->price,
            'product_description' => $this->product->description ?? null,
            'quantity' => $this->quantity,
            'export_type' => $this->export_type,
            'export_name' => $this->getExportName(),
            'base_price' => $this->quantity * $this->product->price,
            'service_price' => $this->getExportPricing(),
        ];
    }


    private function getExportName()
{
    $states = [
        1 => 'توريد فقط', 
        2 => 'توريد و تركيب بدون نحاس', 
        3 => 'عشره متر نحاس + توريد و تركيب'
    ];
    return $states[$this->export_type] ?? null;
}

private function getExportPricing()
{
    $statePrices = [
        1 => 0,      
        2 => 500,    
        3 => 850,    
    ];
    return $statePrices[$this->export_type] ?? 0;
}

}

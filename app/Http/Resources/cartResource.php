<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class cartResource extends JsonResource
{
    public function toArray(Request $request): array
{
    return [
        'product_name' => $this->product->name,
        'product_price' => $this->product->price,
        'product_description' => $this->product->description,
        'quantity' => $this->quantity,
        'export' => $this->getExportName($this->export_type),
        'base_price' => $this->quantity * $this->product->price,
        'service_price' => $this->getExportPricing($this->export_type),
        'item_total' => $this->getTotalPrice(),
    ];
}

private function getExportPricing($value)
{
    $statePrices = [
        1 => 0,      
        2 => 500,    
        3 => 850,    
    ];
    return $statePrices[$value] ?? 0;
}

private function getExportName($value)
{
    $states = [
        1 => 'توريد فقط', 
        2 => 'توريد و تركيب بدون نحاس', 
        3 => 'عشره متر نحاس + توريد و تركيب'
    ];
    return $states[$value] ?? null;
}

private function getTotalPrice()
{
    $basePrice = $this->quantity * $this->product->price;
    return $basePrice + $this->getExportPricing($this->export_type);
}


   
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
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
            'first_name'        => $this->first_name,
            'last_name' => $this->last_name,
            'email'       => $this->email,
            'phone'  => $this->phone,
            'message' => $this->message ,
            'project_type' => $this->getExportName() ,


        ];
    }


    private function getExportName()
{
    $states = [
        1 => 'اعمال الصيانه',
        2 => 'اعمال ال -DUCT',
        3 => 'المشاريع',
        4 => 'المنتاجات',
    ];
    return $states[$this->project_type] ?? null;
}
}

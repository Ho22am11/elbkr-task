<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\product;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;


protected function afterCreate(): void
{
    $total = $this->record->orderItems->sum(function ($item) {
        return $item->product->price * $item->quantity;
    });

    $this->record->update(['total_price' => $total]);
}

}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderItemRelationManagerResource\RelationManagers\OrderItemsRelationManager;
use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Table;
use App\Models\product;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Columns\TextColumn;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                ->relationship('user', 'frist_name')
                ->label(__('Customer Name'))
                ->required(),

                Repeater::make('order_items')
                ->relationship('orderItems')
                ->label(__('Order Items'))
                ->schema([
                    Select::make('product_id')
                    ->relationship('product', 'name')
                    ->label(__('Product'))
                    ->required(),

                    TextInput::make('quantity')
                    ->numeric()
                    ->minValue(1)
                    ->label(__('Quantity'))
                    ->required(),

                    Select::make('export_type')
                    ->options([1 => __('Supply Only'), 2 =>  __('Supply and Installation without Copper'),
                    3 => __('Ten Meters Copper + Supply and Installation')
                    ])
                    ->label(__('Export Type'))
                    ->required(),
                     Placeholder::make('price')
                        ->label(__('Price'))
                        ->content(function ($get) {
                            $product = product::find($get('product_id'));
                            return $product ? $product->price . ' ج.م' : '-';
                        }),
                        ])
                        ->live()
                        ->columns(4),


                    Placeholder::make('total_price')
                ->label(__('Total Amount'))
                ->content(function ($get) {
                    $total = 0;
                    foreach ($get('order_items') ?? [] as $item) {
                        $product = \App\Models\Product::find($item['product_id'] ?? null);
                        $qty = $item['quantity'] ?? 0;
                        $total += ($product?->price ?? 0) * $qty;
                    }
                    return number_format($total, 2) . ' ج.م';
                })
                ->columnSpanFull()


                ]);


    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.frist_name')->label(__('Customer Name'))->searchable(),
                TextColumn::make('status')->label(__('Order state')),
                TextColumn::make('total_price')->label(__('Total Amount'))
                    ->searchable(),
                TextColumn::make('created_at')
                   ->since()
                    ->label(__('since')),

            ])
            ->defaultSort('created_at' ,'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }



    public static function getRelations(): array
{
    return [
        OrderItemsRelationManager::class,
    ];
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): ?string
    {
        return __('Orders');
    }

    public static function getNavigationLabel(): string
    {
        return __('Orders');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['user.frist_name'];
    }

public static function getGlobalSearchResultDetails($record): array
{
    return [
        __('Customer Name') => $record->user->frist_name,
        __('Total Amount')=> $record->total_price,
    ];
}
}



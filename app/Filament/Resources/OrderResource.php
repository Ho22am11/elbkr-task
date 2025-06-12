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

    protected static ?string $navigationLabel = 'الطلبات ' ;
    protected static ?string $pluralLabel     = 'قائمه الطلبات';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                ->relationship('user', 'frist_name')
                ->label('اسم العميل')
                ->required(),

                Repeater::make('order_items')
                ->relationship('orderItems')
                ->label('عناصر الطلب')
                ->schema([
                    Select::make('product_id')
                    ->relationship('product', 'name')
                    ->label('المنتج')
                    ->required(),

                    TextInput::make('quantity')
                    ->numeric()
                    ->minValue(1)
                    ->label('الكمية')
                    ->required(),

                    Select::make('export_type')
                    ->options([1 => 'توريد فقط', 2 => 'توريد و تركيب بدون نحاس', 3 => 'عشره متر نحاس + توريد و تركي '
                    ])
                    ->label('نوع التصدير')
                    ->required(),
                     Placeholder::make('price')
                        ->label('السعر')
                        ->content(function ($get) {
                            $product = product::find($get('product_id'));
                            return $product ? $product->price . ' ج.م' : '-';
                        }),
                        ])
                        ->live()
                        ->columns(4),


                    Placeholder::make('total_price')
                ->label('الإجمالي الكلي')
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
                TextColumn::make('user.frist_name')->label('اسم العميل'),
                TextColumn::make('status')->label('حاله الطلب'),
                TextColumn::make('total_price')->label('الاجمالي')
                    ->searchable(),
                TextColumn::make('created_at')
                   ->since()
                    ->label('منذ'),

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
        return 'الطلبات';
    }
}

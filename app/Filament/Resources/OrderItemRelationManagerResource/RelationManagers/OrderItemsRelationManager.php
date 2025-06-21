<?php

namespace App\Filament\Resources\OrderItemRelationManagerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderItems';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('product_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_id')
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('product.name')->label('اسم المنتج'),
                Tables\Columns\TextColumn::make('product.price')->label('سعر المنتج'),
                Tables\Columns\TextColumn::make('quantity')->label('الكميه'),
                Tables\Columns\TextColumn::make('export_type')
                ->label('نوع التصدير')
                ->formatStateUsing(function ($state) {
                    return [
                        1 => 'توريد فقط',
                        2 => 'توريد و تركيب بدون نحاس',
                        3 => 'عشره متر نحاس + توريد و تركيب',
                        ][$state] ?? 'غير معروف';
                    }),


            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

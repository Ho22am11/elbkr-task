<?php

namespace App\Filament\Resources\RatesRelationManagerResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RatesRelationManager extends RelationManager
{
    protected static string $relationship = 'rates';

    protected static ?string $title = 'التقيمات' ;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('rating')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('rating')
            ->columns([
                TextColumn::make('user.frist_name')->label('العميل'),
                TextColumn::make('rating')->label('التقيم'),
                TextColumn::make('content')->label('الراي'),
                TextColumn::make('created_at')->since()->label('منذ'),
            ])->defaultSort('created_at' , 'desc')
            ->filters([
                //
            ])
            ->headerActions([
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

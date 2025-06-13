<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\RatesRelationManagerResource\RelationManagers\RatesRelationManager;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use PhpParser\Node\Stmt\Label;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2'; // heroicon-s => icon solid in heroicon , m

    protected static ?string $recordTitleAttribute = 'name';




    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('name')->required()->label(__('Product Name')),
                TextInput::make('description')->required()->Label(__('Description')),
                TextInput::make('price')->numeric()->minValue(0)->required()->Label(__('Price')),
                Select::make('campany_id')->relationship('campany' , 'name')->required()->Label(__('Company Name')),
                Select::make('category_id')->relationship('category' , 'name')->required()->Label(__('Category')),



                Repeater::make('attachements')
                ->relationship('attachements')
                ->label(__('Product Image'))
                ->columns(1)
                ->minItems(1)
                ->schema([
                     FileUpload::make('img')
                        ->directory('product_attachments')
                        ->disk('public')
                        ->label(__('Image'))
                        ->helperText(__('Product Image'))
                        ->image()
                        ->imageEditor()
                        ->required()
                ]),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('Product Name'))->searchable(),
                TextColumn::make('description')->Label(__('Description')),
                TextColumn::make('price')->Label(__('Price'))->searchable(),
                TextColumn::make('campany.name')->Label(__('Company Name'))->searchable(),
                TextColumn::make('category.name')->Label(__('Category'))->searchable(),
                TextColumn::make('created_at')->since()->Label(__('since')),
            ])->defaultSort('created_at', 'desc')
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
                RatesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }


     public static function getLabel(): ?string
    {
        return __('Products');
    }

    public static function getNavigationLabel(): string
{
    return __('Products');
}



}

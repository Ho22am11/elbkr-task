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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'المنتجات' ;
    protected static ?string $pluralLabel = 'المنتجات' ;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('name')->required()->label('اسم المنتج'),
                TextInput::make('description')->required()->Label('الوصف'),
                TextInput::make('price')->numeric()->minValue(0)->required()->Label('السعر'),
                Select::make('campany_id')->relationship('campany' , 'name')->required()->Label('اسم الشركه'),
                Select::make('category_id')->relationship('category' , 'name')->required()->Label('الفئه'),



                Repeater::make('attachements')
                ->relationship('attachements')
                ->label('صور المنتج')
                ->columns(1)
                ->minItems(1)
                ->schema([
                     FileUpload::make('img')
                        ->directory('product_attachments')
                        ->disk('public')
                        ->label('صورة ')
                        ->helperText('صزره المنتج')
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
                TextColumn::make('name')->label('اسم المنتج'),
                TextColumn::make('description')->Label('الوصف'),
                TextColumn::make('price')->Label('السعر'),
                TextColumn::make('campany.name')->Label('اسم الشركه'),
                TextColumn::make('category.name')->Label('الفئه'),
                TextColumn::make('created_at')->since()->Label('منذ'),
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
        return 'المنتجات';
    }



}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemClassResource\Pages;
use App\Filament\Resources\ItemClassResource\RelationManagers;
use App\Models\ItemClass;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemClassResource extends Resource
{
    protected static ?string $model = ItemClass::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function getNavigationGroup(): ?string
    {
        return 'Inventory';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('Item Class')
                ->description('Add a new item class to the inventory.')
                ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
            ])
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItemClasses::route('/'),
            'create' => Pages\CreateItemClass::route('/create'),
            'edit' => Pages\EditItemClass::route('/{record}/edit'),
        ];
    }
}

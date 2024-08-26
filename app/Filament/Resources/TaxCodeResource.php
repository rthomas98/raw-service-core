<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaxCodeResource\Pages;
use App\Filament\Resources\TaxCodeResource\RelationManagers;
use App\Models\TaxCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaxCodeResource extends Resource
{
    protected static ?string $model = TaxCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tax_code_name')
                    ->label('Tax Code Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Checkbox::make('default_tax_code')
                    ->label('Default Tax Code'),
                Forms\Components\Repeater::make('components')
                    ->relationship('components')
                    ->schema([
                        Forms\Components\TextInput::make('component_name')
                            ->label('Component Name')
                            ->required(),
                        Forms\Components\TextInput::make('agency_name')
                            ->label('Agency Name')
                            ->required(),
                        Forms\Components\TextInput::make('rate')
                            ->label('Rate')
                            ->numeric()
                            ->required()
                            ->suffix('%'),
                    ])
                    ->createItemButtonLabel('Add Component')
                    ->columns(3),
                Forms\Components\TextInput::make('total_tax_rate')
                    ->label('Total Tax Rate')
                    ->numeric()
                    ->disabled() // Calculated automatically
                    ->suffix('%'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tax_code_name')->sortable()->searchable()->label('Tax Code Name'),
                Tables\Columns\BooleanColumn::make('default_tax_code')->label('Default Tax Code'),
                Tables\Columns\TextColumn::make('total_tax_rate')->sortable()->label('Total Tax Rate')->suffix('%'),
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
            'index' => Pages\ListTaxCodes::route('/'),
            'create' => Pages\CreateTaxCode::route('/create'),
            'edit' => Pages\EditTaxCode::route('/{record}/edit'),
        ];
    }
}

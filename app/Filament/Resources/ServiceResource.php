<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Filament\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function getNavigationGroup(): ?string
    {
        return 'Accounting';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535),
                Forms\Components\TextInput::make('short_code')
                    ->required()
                    ->maxLength(50),
                Forms\Components\Checkbox::make('is_taxable')
                    ->label('Taxable'),
                Forms\Components\Checkbox::make('is_surcharge')
                    ->label('Surcharge')
                    ->default(false),
                Forms\Components\Select::make('billing_period')
                    ->options([
                        'Days' => 'Days',
                        'Weeks' => 'Weeks',
                        'Months' => 'Months',
                        'Years' => 'Years',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('rate')
                    ->numeric()
                    ->required()
                    ->prefix('$'),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}

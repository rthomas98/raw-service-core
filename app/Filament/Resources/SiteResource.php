<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteResource\Pages;
use App\Filament\Resources\SiteResource\RelationManagers;
use App\Models\Site;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SiteResource extends Resource
{
    protected static ?string $model = Site::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->options([
                        'Commercial' => 'Commercial',
                        'Government' => 'Government',
                        'Residential' => 'Residential',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('site_name')
                    ->maxLength(255),
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'customer_name')
                    ->required(),
                Forms\Components\Select::make('country')
                    ->options([
                        'United States' => 'United States',
                        'Canada' => 'Canada',
                        'Jamaica' => 'Jamaica',
                        'Panama' => 'Panama',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('site_address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('site_address_2')
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('state_province')
                    ->options([
                        // Add states/provinces here
                        'Alaska' => 'Alaska',
                        'Alabama' => 'Alabama',
                        // Continue with other states/provinces...
                    ])
                    ->required(),
                Forms\Components\TextInput::make('zip_postal_code')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('county')
                    ->maxLength(255),
                Forms\Components\TextInput::make('latitude')
                    ->numeric()
                    ->maxLength(10),
                Forms\Components\TextInput::make('longitude')
                    ->numeric()
                    ->maxLength(10),
                Forms\Components\Textarea::make('notes'),
                Forms\Components\Textarea::make('internal_notes'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')->sortable(),
                Tables\Columns\TextColumn::make('site_name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('customer.customer_name')->label('Site Owner')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('country')->sortable(),
                Tables\Columns\TextColumn::make('site_address')->sortable(),
                Tables\Columns\TextColumn::make('city')->sortable(),
                Tables\Columns\TextColumn::make('state_province')->sortable(),
                Tables\Columns\TextColumn::make('zip_postal_code')->sortable(),
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
            'index' => Pages\ListSites::route('/'),
            'create' => Pages\CreateSite::route('/create'),
            'edit' => Pages\EditSite::route('/{record}/edit'),
        ];
    }
}

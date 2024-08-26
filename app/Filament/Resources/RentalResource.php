<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RentalResource\Pages;
use App\Filament\Resources\RentalResource\RelationManagers;
use App\Models\Rental;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RentalResource extends Resource
{
    protected static ?string $model = Rental::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('po_number')
                    ->label('PO Number')
                    ->maxLength(255)
                    ->nullable(),
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'customer_name')
                    ->required(),
                Forms\Components\Select::make('site_id')
                    ->relationship('site', 'site_name')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\TimePicker::make('start_time')
                    ->label('Start Time')
                    ->nullable(),
                Forms\Components\TimePicker::make('end_time')
                    ->label('End Time')
                    ->nullable(),
                Forms\Components\TextInput::make('duration_hours')
                    ->label('Duration (Hours)')
                    ->numeric()
                    ->nullable(),
                Forms\Components\TextInput::make('duration_minutes')
                    ->label('Duration (Minutes)')
                    ->numeric()
                    ->nullable(),
                Forms\Components\Textarea::make('driver_notes')
                    ->label('Driver Notes')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('po_number')->label('PO Number')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('customer.customer_name')->label('Customer')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('site.site_name')->label('Site')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('date')->sortable()->date(),
                Tables\Columns\TextColumn::make('start_time')->label('Start Time')->sortable(),
                Tables\Columns\TextColumn::make('end_time')->label('End Time')->sortable(),
                Tables\Columns\TextColumn::make('duration_hours')->label('Duration (Hours)')->sortable(),
                Tables\Columns\TextColumn::make('duration_minutes')->label('Duration (Minutes)')->sortable(),
                Tables\Columns\TextColumn::make('driver_notes')->label('Driver Notes')->sortable(),
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
            'index' => Pages\ListRentals::route('/'),
            'create' => Pages\CreateRental::route('/create'),
            'edit' => Pages\EditRental::route('/{record}/edit'),
        ];
    }
}

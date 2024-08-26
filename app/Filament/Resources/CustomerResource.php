<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('company_organization')
                    ->maxLength(255),
                Forms\Components\TextInput::make('first_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->maxLength(255),
                Forms\Components\Select::make('preferred_billing_communication')
                    ->options([
                        'Email' => 'Email',
                        'Print' => 'Print',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->maxLength(20),
                Forms\Components\TextInput::make('secondary_phone')
                    ->maxLength(20),
                Forms\Components\TextInput::make('fax')
                    ->maxLength(20),
                Forms\Components\Select::make('country')
                    ->options([
                        'United States' => 'United States',
                        'Canada' => 'Canada',
                        'Jamaica' => 'Jamaica',
                        'Panama' => 'Panama',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address_2')
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('state_province')
                    ->options([
                        // Add your states and provinces here
                        'Alaska' => 'Alaska',
                        'Alabama' => 'Alabama',
                        // Continue with other states and provinces...
                    ])
                    ->required(),
                Forms\Components\TextInput::make('zip_postal_code')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('county')
                    ->maxLength(255),
                Forms\Components\Select::make('customer_type')
                    ->options([
                        'Commercial' => 'Commercial',
                        'Government' => 'Government',
                        'Residential' => 'Residential',
                    ]),
                Forms\Components\DatePicker::make('customer_since'),
                Forms\Components\TextInput::make('heard_about_us')
                    ->maxLength(255),
                Forms\Components\Textarea::make('notes'),
                Forms\Components\Textarea::make('internal_notes'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer_name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('company_organization')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('first_name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('last_name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('preferred_billing_communication')->sortable(),
                Tables\Columns\TextColumn::make('phone')->sortable(),
                Tables\Columns\TextColumn::make('country')->sortable(),
                Tables\Columns\TextColumn::make('city')->sortable(),
                Tables\Columns\TextColumn::make('state_province')->sortable(),
                Tables\Columns\TextColumn::make('customer_type')->sortable(),
                Tables\Columns\TextColumn::make('customer_since')->date()->sortable(),
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

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}

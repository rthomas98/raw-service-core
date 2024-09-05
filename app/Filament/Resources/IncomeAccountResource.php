<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomeAccountResource\Pages;
use App\Filament\Resources\IncomeAccountResource\RelationManagers;
use App\Models\IncomeAccount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IncomeAccountResource extends Resource
{
    protected static ?string $model = IncomeAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

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
                    ->maxLength(31)
                    ->label('Name'),
                Forms\Components\Radio::make('account_type')
                    ->options([
                        'Income' => 'Income',
                        'Bank' => 'Bank',
                        'Other Current Assets' => 'Other Current Assets',
                    ])
                    ->required()
                    ->label('Account Type'),
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->unique(IncomeAccount::class, 'code')
                    ->label('Code'),
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
            'index' => Pages\ListIncomeAccounts::route('/'),
            'create' => Pages\CreateIncomeAccount::route('/create'),
            'edit' => Pages\EditIncomeAccount::route('/{record}/edit'),
        ];
    }
}

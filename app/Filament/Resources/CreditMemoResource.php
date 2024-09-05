<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CreditMemoResource\Pages;
use App\Filament\Resources\CreditMemoResource\RelationManagers;
use App\Models\CreditMemo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CreditMemoResource extends Resource
{
    protected static ?string $model = CreditMemo::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    public static function getNavigationGroup(): ?string
    {
        return 'Accounting';
    }



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'customer_name')
                    ->required()
                    ->label('Customer'),
                Forms\Components\TextInput::make('emails')
                    ->nullable()
                    ->label('Emails (Optional)'),
                Forms\Components\DatePicker::make('invoice_date')
                    ->required()
                    ->label('Invoice Date'),
                Forms\Components\Select::make('user_id')
                    ->relationship('clerk', 'name')
                    ->default(auth()->user()->id)
                    ->disabled()
                    ->label('Clerk'),
                Forms\Components\TextInput::make('po_number')
                    ->nullable()
                    ->label('P.O. Number'),
                Forms\Components\Textarea::make('message_displayed_on_credit_memo')
                    ->nullable()
                    ->label('Message Displayed on Credit Memo (Optional)'),
                Forms\Components\Textarea::make('internal_memo')
                    ->nullable()
                    ->label('Internal Memo (Optional)'),
                Forms\Components\FileUpload::make('attachments')
                    ->multiple()
                    ->label('Attachments (Optional)'),
                Forms\Components\Radio::make('preferred_communication')
                    ->options([
                        'Email' => 'Email',
                        'Print' => 'Print',
                    ])
                    ->default('Email')
                    ->label('Preferred Communication'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.customer_name')->sortable()->searchable()->label('Customer'),
                Tables\Columns\TextColumn::make('invoice_date')->sortable()->date()->label('Invoice Date'),
                Tables\Columns\TextColumn::make('po_number')->sortable()->label('P.O. Number'),
                Tables\Columns\TextColumn::make('preferred_communication')->label('Preferred Communication'),
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
            'index' => Pages\ListCreditMemos::route('/'),
            'create' => Pages\CreateCreditMemo::route('/create'),
            'edit' => Pages\EditCreditMemo::route('/{record}/edit'),
        ];
    }
}

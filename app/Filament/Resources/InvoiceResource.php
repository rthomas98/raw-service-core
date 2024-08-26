<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'customer_name')
                    ->required()
                    ->label('Customer'),
                Forms\Components\DatePicker::make('invoice_date')
                    ->required()
                    ->label('Invoice Date'),
                Forms\Components\Select::make('user_id')
                    ->relationship('clerk', 'name')
                    ->default(auth()->user()->id)
                    ->disabled()
                    ->label('Clerk'),
                Forms\Components\Select::make('service_location_id')
                    ->relationship('serviceLocation', 'site_name')
                    ->nullable()
                    ->label('Service Location (Optional)'),
                Forms\Components\Select::make('payment_term_id')
                    ->relationship('paymentTerm', 'payment_term_type')
                    ->required()
                    ->label('Payment Terms'),
                Forms\Components\DatePicker::make('due_date')
                    ->required()
                    ->label('Due Date'),
                Forms\Components\TextInput::make('po_number')
                    ->nullable()
                    ->label('P.O. Number'),
                Forms\Components\TextInput::make('address_name')
                    ->required()
                    ->label('Address Name'),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->label('Address'),
                Forms\Components\TextInput::make('address_2')
                    ->nullable()
                    ->label('Address 2 (Optional)'),
                Forms\Components\TextInput::make('city')
                    ->required()
                    ->label('City'),
                Forms\Components\TextInput::make('state_province')
                    ->required()
                    ->label('State / Province'),
                Forms\Components\TextInput::make('zip_postal_code')
                    ->required()
                    ->label('Zip / Postal Code'),

                Forms\Components\TextInput::make('invoice_subtotal')
                    ->disabled()
                    ->label('Invoice Subtotal'),
                Forms\Components\TextInput::make('discount_value')
                    ->numeric()
                    ->default(0)
                    ->label('Discount Value'),
                Forms\Components\Select::make('tax_code_id')
                    ->relationship('taxCode', 'tax_code_name')
                    ->required()
                    ->label('Tax Rate'),
                Forms\Components\Textarea::make('message_displayed_on_invoice')
                    ->nullable()
                    ->label('Message Displayed on Invoice (Optional)'),
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
                Forms\Components\Toggle::make('online_payment')
                    ->default(true)
                    ->label('Allow Online Payment by Credit Card'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.customer_name')->sortable()->searchable()->label('Customer'),
                Tables\Columns\TextColumn::make('invoice_date')->sortable()->date()->label('Invoice Date'),
                Tables\Columns\TextColumn::make('due_date')->sortable()->date()->label('Due Date'),
                Tables\Columns\TextColumn::make('invoice_subtotal')->sortable()->label('Subtotal'),
                Tables\Columns\TextColumn::make('discount_value')->sortable()->label('Discount'),
                Tables\Columns\TextColumn::make('taxCode.tax_code_name')->sortable()->label('Tax Rate'),
                Tables\Columns\BooleanColumn::make('online_payment')->label('Online Payment'),
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}

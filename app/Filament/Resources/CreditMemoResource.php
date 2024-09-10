<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CreditMemoResource\Pages;
use App\Filament\Resources\CreditMemoResource\RelationManagers;
use App\Models\CreditMemo;
use App\Models\Service;
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

                Forms\Components\Section::make('Credit Memo Details')
                    ->description('Create a new credit memo for a customer.')
                    ->columns(2)
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
                ]),

                Forms\Components\Section::make('Add Services')
                    ->description('Add services to the credit memo.')
                    ->schema([
                        Forms\Components\Repeater::make('services')
                            ->schema([
                                Forms\Components\Select::make('service_id')
                                    ->label('Service')
                                    ->options(Service::pluck('name', 'id'))
                                    ->required()
                                    ->searchable()
                                    ->reactive()
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('rate', Service::find($state)?->rate ?? 0)),
                                Forms\Components\TextInput::make('description')
                                    ->label('Description')
                                    ->required(),
                                Forms\Components\TextInput::make('rate')
                                    ->label('Rate')
                                    ->numeric()
                                    ->required(),
                                Forms\Components\TextInput::make('quantity')
                                    ->label('Quantity')
                                    ->numeric()
                                    ->required(),
                                Forms\Components\Toggle::make('is_taxable')
                                    ->label('Taxable')
                                    ->default(true),
                            ])
                            ->columns(5)
                            ->defaultItems(1)
                            ->addActionLabel('Add Service'),
                    ]),

                Forms\Components\Section::make('Credit Memo Summary')
                    ->description('Summary of the credit memo amounts.')
                    ->schema([
                        Forms\Components\Placeholder::make('subtotal')
                            ->label('Subtotal')
                            ->content(function (callable $get) {
                                $services = $get('services') ?? [];
                                $subtotal = collect($services)->sum(function ($service) {
                                    return $service['rate'] * $service['quantity'];
                                });
                                return '$' . number_format($subtotal, 2);
                            }),
                        
                        Forms\Components\Select::make('tax_rate')
                            ->label('Tax Rate')
                            ->options([
                                // You may want to populate this with actual tax rates from your database
                                '0' => '0%',
                                '5' => '5%',
                                '10' => '10%',
                                '15' => '15%',
                            ])
                            ->placeholder('-- Select Tax Rate --'),
                        
                        Forms\Components\Placeholder::make('tax_amount')
                            ->label('Tax Amount')
                            ->content(function (callable $get) {
                                $services = $get('services') ?? [];
                                $taxableTotal = collect($services)->sum(function ($service) {
                                    return $service['is_taxable'] ? ($service['rate'] * $service['quantity']) : 0;
                                });
                                $taxRate = $get('tax_rate') / 100;
                                return '$' . number_format($taxableTotal * $taxRate, 2);
                            }),
                        
                        Forms\Components\TextInput::make('discount_value')
                            ->label('Discount Value')
                            ->numeric()
                            ->default(0)
                            ->suffix('%'),
                        
                        Forms\Components\Placeholder::make('discount_amount')
                            ->label('Discount Amount')
                            ->content(function (callable $get) {
                                $services = $get('services') ?? [];
                                $subtotal = collect($services)->sum(function ($service) {
                                    return $service['rate'] * $service['quantity'];
                                });
                                $discountValue = $get('discount_value') / 100;
                                $discountAmount = $subtotal * $discountValue;
                                return '($' . number_format($discountAmount, 2) . ')';
                            }),
                        
                        Forms\Components\Placeholder::make('total')
                            ->label('Credit Memo Total')
                            ->content(function (callable $get) {
                                $services = $get('services') ?? [];
                                $subtotal = collect($services)->sum(function ($service) {
                                    return $service['rate'] * $service['quantity'];
                                });
                                $taxRate = $get('tax_rate') / 100;
                                $taxAmount = $subtotal * $taxRate;
                                $discountValue = $get('discount_value') / 100;
                                $discountAmount = $subtotal * $discountValue;
                                $total = $subtotal + $taxAmount - $discountAmount;
                                return '$' . number_format($total, 2);
                            })
                            ->extraAttributes(['class' => 'text-xl font-bold']),
                    ])
                    ->columns(2),


                Forms\Components\Section::make('PO Details')
                    ->description('Add the P.O. number if the credit memo is related to a purchase order.')
                    ->columns(2)
                    ->schema([
                Forms\Components\TextInput::make('po_number')
                    ->nullable()
                    ->label('P.O. Number')
                    ->columnSpanFull(),
                ]),



                Forms\Components\Section::make('Credit Memo Details')
                    ->description('Add details to the credit memo.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\RichEditor::make('message_displayed_on_credit_memo')
                            ->nullable()
                            ->label('Message Displayed on Credit Memo (Optional)')
                            ->columnSpanFull(),
                        ]),
                        
                        Forms\Components\Section::make('Add Internal Memo')
                            ->description('Add an internal memo to the credit memo.')
                            ->columns(2)
                            ->schema([
                Forms\Components\RichEditor::make('internal_memo')
                    ->nullable()
                    ->label('Internal Memo (Optional)')
                    ->columnSpanFull(),
                            ]),

                            Forms\Components\Section::make('Credit Memo Details')
                            ->description('Add details to the credit memo.')
                            ->columns(2)
                            ->schema([
                Forms\Components\FileUpload::make('attachments')
                    ->multiple()
                    ->label('Attachments (Optional)')
                    ->columnSpanFull(),
                
                    ]),
                    
                    Forms\Components\Section::make('Communication')
                    ->description('Select how the credit memo should be communicated to the customer.')
                    ->columns(2)
                    ->schema([
                Forms\Components\Radio::make('preferred_communication')
                    ->options([
                        'Email' => 'Email',
                        'Print' => 'Print',
                    ])
                    ->default('Email')
                    ->label('Preferred Communication'),
                    ]),
                    
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

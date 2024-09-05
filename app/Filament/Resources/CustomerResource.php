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

    protected static ?string $navigationIcon = 'heroicon-o-users';

    // page title
    public static function getTitle(): string
    {
        return 'Add New Customer';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Customers';
    }

    public static function form(Form $form): Form
    {
        return $form



            ->schema([
                

                Forms\Components\Section::make('Customer Details')
                ->description('Add the customers details below.')
                ->columns(2)
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
                Forms\Components\CheckboxList::make('preferred_billing_communication')
                    ->options([
                        'Email' => 'Email',
                        'Print' => 'Print',
                    ])
                    ->columns(2)
                    ->required(),
                ]),


                Forms\Components\Section::make('Phone Numbers')
                ->description('Add the customer phone numbers below.')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('phone')
                    ->maxLength(20),
                Forms\Components\TextInput::make('secondary_phone')
                    ->maxLength(20),
                Forms\Components\TextInput::make('fax')
                    ->maxLength(20),
                ]),


                Forms\Components\Section::make('Billing Address')
                ->description('Invoices and estimates will be mailed to the customer\'s billing address')
                ->columns(2)
                ->schema([
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
                        'Alabama' => 'Alabama',
                        'Alaska' => 'Alaska',
                        'Arizona' => 'Arizona',
                        'Arkansas' => 'Arkansas',
                        'California' => 'California',
                        'Colorado' => 'Colorado',
                        'Connecticut' => 'Connecticut',
                        'Delaware' => 'Delaware',
                        'Florida' => 'Florida',
                        'Georgia' => 'Georgia',
                        'Hawaii' => 'Hawaii',
                        'Idaho' => 'Idaho',
                        'Illinois' => 'Illinois',
                        'Indiana' => 'Indiana',
                        'Iowa' => 'Iowa',
                        'Kansas' => 'Kansas',
                        'Kentucky' => 'Kentucky',
                        'Louisiana' => 'Louisiana',
                        'Maine' => 'Maine',
                        'Maryland' => 'Maryland',
                        'Massachusetts' => 'Massachusetts',
                        'Michigan' => 'Michigan',
                        'Minnesota' => 'Minnesota',
                        'Mississippi' => 'Mississippi',
                        'Missouri' => 'Missouri',
                        'Montana' => 'Montana',
                        'Nebraska' => 'Nebraska',
                        'Nevada' => 'Nevada',
                        'New Hampshire' => 'New Hampshire',
                        'New Jersey' => 'New Jersey',
                        'New Mexico' => 'New Mexico',
                        'New York' => 'New York',
                        'North Carolina' => 'North Carolina',
                        'North Dakota' => 'North Dakota',
                        'Ohio' => 'Ohio',
                        'Oklahoma' => 'Oklahoma',
                        'Oregon' => 'Oregon',
                        'Pennsylvania' => 'Pennsylvania',
                        'Rhode Island' => 'Rhode Island',
                        'South Carolina' => 'South Carolina',
                        'South Dakota' => 'South Dakota',
                        'Tennessee' => 'Tennessee',
                        'Texas' => 'Texas',
                        'Utah' => 'Utah',
                        'Vermont' => 'Vermont',
                        'Virginia' => 'Virginia',
                        'Washington' => 'Washington',
                        'West Virginia' => 'West Virginia',
                        'Wisconsin' => 'Wisconsin',
                        'Wyoming' => 'Wyoming'
                    ])
                    ->required(),
                Forms\Components\TextInput::make('zip_postal_code')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('county')
                    ->maxLength(255),
                ]),


                Forms\Components\Section::make('Customer Type')
                ->description('Select the customer type below.')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('customer_type')
                    ->options([
                        'Commercial' => 'Commercial',
                        'Government' => 'Government',
                        'Residential' => 'Residential',
                    ]),
                Forms\Components\DatePicker::make('customer_since'),
                Forms\Components\Textarea::make('heard_about_us')
                ->columnSpanFull()
                    ->maxLength(255),
            ]),

            Forms\Components\Section::make('Additional Contacts (optional)')
            ->description('Add additional contacts for the customer below.')
            ->columns(2)
            ->schema([
            Forms\Components\Repeater::make('Additional Contacts')
                ->relationship('additionalContacts')
                ->columns(2)
                ->collapsed()
                ->schema([
                    Forms\Components\TextInput::make('first_name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('last_name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('title')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->maxLength(255),
                ])
                ->columnSpanFull()
                ->defaultItems(0)
                ->addActionLabel('Add An Additional Contact')

            ]),

            Forms\Components\Section::make('Billing')
            ->columns(2)
            ->schema([
                Forms\Components\Select::make('tax_code_id')
                    ->label('Tax Code')
                    ->relationship('taxCode', 'tax_code_name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('tax_code_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Toggle::make('default_tax_code')
                            ->label('Set as Default Tax Code'),
                    ])
                    ->required()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $taxCode = \App\Models\TaxCode::find($state);
                        if ($taxCode) {
                            $set('total_tax_rate', $taxCode->total_tax_rate);
                        }
                    }),
                Forms\Components\TextInput::make('total_tax_rate')
                    ->label('Total Tax Rate')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\Select::make('payment_term_id')
                    ->label('Payment Terms')
                    ->relationship('paymentTerm', 'payment_term_type')
                    ->searchable()
                    ->preload()
                    ->required(),
            ]),

            Forms\Components\Section::make('Notes (optional)')
               ->description('These notes will be printed to service tickets and route sheets, and will be viewable on each job.')
               ->columns(2)
               ->schema([
                Forms\Components\RichEditor::make('These notes are internal and can only be viewed here.')
                ->columnSpanFull()
                ->maxLength(65535),


               ]),

               Forms\Components\Section::make('Internal Notes (optional)')
               ->description('These notes are internal and can only be viewed here.')
               ->columns(2)
               ->schema([
                Forms\Components\RichEditor::make('Internal Notes (optional)')
                ->columnSpanFull()
                ->maxLength(65535),
               ])
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

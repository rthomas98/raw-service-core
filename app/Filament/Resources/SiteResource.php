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
use Illuminate\Database\Eloquent\Model;

class SiteResource extends Resource
{
    protected static ?string $model = Site::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';

    public static function getNavigationGroup(): ?string
    {
        return 'Customers';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([


                Forms\Components\Section::make('Basic Information')
                ->description('Add the site information below.')
                ->columns(2)
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

                ]),

                Forms\Components\Section::make('Address')
                ->description('This is the site address that will appear on jobs, rentals, service tickets, emails and PDFs.')
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
                    ]),

Forms\Components\Section::make('Location')
                ->description('Latitude and longitude coordinates are used for routing and directions. To use the site address to calculate coordinates, click the button below:')
                ->columns(2)
                ->schema([

                Forms\Components\TextInput::make('latitude')
                    ->numeric()
                    ->maxLength(10),
                Forms\Components\TextInput::make('longitude')
                    ->numeric()
                    ->maxLength(10),
            
                ]),

                Forms\Components\Section::make('Notes (optional)')
                ->description('Add any additional notes about the site here.')
                ->columns(2)
                ->schema([
                    Forms\Components\RichEditor::make('notes')
                    ->columnSpanFull(),
                ]),

                Forms\Components\Section::make('Internal Notes (optional)')
                ->description('Add any internal notes about the site here.')
                ->columns(2)
                ->schema([
                    Forms\Components\RichEditor::make('internal_notes')
                    ->columnSpanFull(),
                ]),
                

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

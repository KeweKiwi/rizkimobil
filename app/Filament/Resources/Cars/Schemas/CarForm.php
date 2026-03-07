<?php

namespace App\Filament\Resources\Cars\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // ── BASIC INFO ───────────────────────────────────────────────
                Section::make('Basic Information')
                    ->description('Core listing details visible to customers')
                    ->icon('heroicon-o-identification')
                    ->schema([
                        TextInput::make('title')
                            ->label('Listing Title')
                            ->placeholder('e.g., Toyota Avanza 1.5 Veloz AT 2022')
                            ->helperText('Auto-generated if left blank: Year Make Model Variant')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Select::make('make')
                            ->label('Brand / Make')
                            ->required()
                            ->searchable()
                            ->options([
                                'BMW'           => 'BMW',
                                'BYD'           => 'BYD',
                                'Chevrolet'     => 'Chevrolet',
                                'Daihatsu'      => 'Daihatsu',
                                'DFSK'          => 'DFSK',
                                'Ford'          => 'Ford',
                                'Honda'         => 'Honda',
                                'Hyundai'       => 'Hyundai',
                                'Isuzu'         => 'Isuzu',
                                'Kia'           => 'Kia',
                                'Mazda'         => 'Mazda',
                                'Mercedes-Benz' => 'Mercedes-Benz',
                                'Mitsubishi'    => 'Mitsubishi',
                                'Nissan'        => 'Nissan',
                                'Subaru'        => 'Subaru',
                                'Suzuki'        => 'Suzuki',
                                'Toyota'        => 'Toyota',
                                'Volkswagen'    => 'Volkswagen',
                                'Wuling'        => 'Wuling',
                            ]),

                        TextInput::make('model')
                            ->label('Model')
                            ->required()
                            ->placeholder('e.g., Avanza, Civic, Rush')
                            ->maxLength(255),

                        TextInput::make('variant')
                            ->label('Variant / Trim')
                            ->placeholder('e.g., GR Sport, Limited, 1.5 AT')
                            ->maxLength(255),

                        TextInput::make('year')
                            ->label('Year')
                            ->required()
                            ->numeric()
                            ->minValue(1990)
                            ->maxValue(date('Y') + 1)
                            ->default(date('Y')),
                    ])
                    ->columns(2),

                // ── SPECIFICATIONS ────────────────────────────────────────────
                Section::make('Specifications')
                    ->description('Technical details about the vehicle')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        TextInput::make('mileage_km')
                            ->label('Mileage')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->suffix('km')
                            ->placeholder('e.g., 45000'),

                        Select::make('transmission')
                            ->required()
                            ->options([
                                'automatic' => 'Automatic',
                                'manual'    => 'Manual',
                            ]),

                        Select::make('fuel_type')
                            ->label('Fuel Type')
                            ->required()
                            ->options([
                                'bensin'   => 'Bensin (Gasoline)',
                                'diesel'   => 'Diesel',
                                'hybrid'   => 'Hybrid',
                                'electric' => 'Electric',
                            ]),

                        Select::make('body_type')
                            ->label('Body Type')
                            ->required()
                            ->options([
                                'suv'         => 'SUV',
                                'mpv'         => 'MPV',
                                'sedan'       => 'Sedan',
                                'hatchback'   => 'Hatchback',
                                'pickup'      => 'Pickup Truck',
                                'van'         => 'Van',
                                'coupe'       => 'Coupe',
                                'convertible' => 'Convertible',
                                'wagon'       => 'Wagon',
                            ]),

                        TextInput::make('color')
                            ->label('Exterior Color')
                            ->required()
                            ->placeholder('e.g., Pearl White, Midnight Black')
                            ->maxLength(100),

                        TextInput::make('seats')
                            ->label('Seating Capacity')
                            ->numeric()
                            ->minValue(2)
                            ->maxValue(20)
                            ->suffix('seats')
                            ->placeholder('e.g., 5 or 7'),
                    ])
                    ->columns(3),

                // ── PRICING & LOCATION ────────────────────────────────────────
                Section::make('Pricing & Location')
                    ->description('Set the asking price and dealership branch')
                    ->icon('heroicon-o-banknotes')
                    ->schema([
                        TextInput::make('price')
                            ->label('Asking Price')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0)
                            ->placeholder('e.g., 285000000')
                            ->helperText('Enter full amount in Rupiah — no dots or commas'),

                        Select::make('location_id')
                            ->label('Branch / Location')
                            ->relationship('location', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('name')->required()->maxLength(255),
                                TextInput::make('city')->maxLength(100),
                                TextInput::make('address')->maxLength(255),
                            ])
                            ->helperText('Which branch has this car?'),
                    ])
                    ->columns(2),

                // ── VEHICLE DOCUMENTATION ─────────────────────────────────────
                Section::make('Vehicle Documentation')
                    ->description('Legal and registration details')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        TextInput::make('vin')
                            ->label('VIN / Chassis Number')
                            ->placeholder('e.g., MHRRD18501J007654')
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Select::make('plate_parity')
                            ->label('License Plate Parity')
                            ->options([
                                'ganjil' => 'Ganjil (Odd)',
                                'genap'  => 'Genap (Even)',
                            ])
                            ->helperText('Indonesian odd/even traffic restriction'),

                        DatePicker::make('stnk_valid_until')
                            ->label('STNK Valid Until')
                            ->displayFormat('d M Y')
                            ->helperText('Vehicle registration expiry date'),
                    ])
                    ->columns(3),

                // ── DESCRIPTION & FEATURES ────────────────────────────────────
                Section::make('Description & Features')
                    ->description('What makes this car stand out')
                    ->icon('heroicon-o-list-bullet')
                    ->schema([
                        Textarea::make('description')
                            ->label('Description')
                            ->rows(5)
                            ->maxLength(5000)
                            ->placeholder('Describe the car condition, history, modifications, etc.')
                            ->columnSpanFull(),

                        TagsInput::make('features')
                            ->label('Features & Equipment')
                            ->placeholder('Type a feature and press Enter')
                            ->helperText('e.g., Sunroof, 360 Camera, Android Auto, Leather Seats, ABS, Dual Airbags')
                            ->columnSpanFull(),
                    ]),

                // ── STATUS & VISIBILITY ───────────────────────────────────────
                Section::make('Status & Visibility')
                    ->description('Control how and where this listing appears')
                    ->icon('heroicon-o-eye')
                    ->schema([
                        Toggle::make('featured')
                            ->label('Featured on Homepage')
                            ->helperText('Shown in hero carousel and featured grid')
                            ->default(false),

                        Toggle::make('sold')
                            ->label('Mark as Sold')
                            ->helperText('Hides the car from the public inventory')
                            ->default(false),
                    ])
                    ->columns(2),

            ]);
    }
}

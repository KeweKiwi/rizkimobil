<?php

namespace App\Filament\Resources\Cars\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->schema([
                        TextInput::make('title')
                            ->label('Listing Title')
                            ->placeholder('e.g., Toyota Avanza 1.5 Veloz AT')
                            ->maxLength(255),
                        
                        Select::make('make')
                            ->label('Brand/Make')
                            ->required()
                            ->searchable()
                            ->options([
                                'Toyota' => 'Toyota',
                                'Honda' => 'Honda',
                                'Daihatsu' => 'Daihatsu',
                                'Suzuki' => 'Suzuki',
                                'Mitsubishi' => 'Mitsubishi',
                                'Nissan' => 'Nissan',
                                'Mazda' => 'Mazda',
                                'Isuzu' => 'Isuzu',
                                'BMW' => 'BMW',
                                'Mercedes-Benz' => 'Mercedes-Benz',
                                'Audi' => 'Audi',
                                'Volkswagen' => 'Volkswagen',
                                'Ford' => 'Ford',
                                'Chevrolet' => 'Chevrolet',
                                'Hyundai' => 'Hyundai',
                                'Kia' => 'Kia',
                                'Wuling' => 'Wuling',
                                'DFSK' => 'DFSK',
                            ])
                            ->preload(),
                        
                        TextInput::make('model')
                            ->required()
                            ->maxLength(255),
                        
                        TextInput::make('variant')
                            ->label('Variant/Trim')
                            ->maxLength(255),
                        
                        TextInput::make('year')
                            ->required()
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(date('Y') + 1)
                            ->default(date('Y')),
                    ])
                    ->columns(2),

                Section::make('Specifications')
                    ->schema([
                        TextInput::make('mileage_km')
                            ->label('Mileage (km)')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->suffix('km'),
                        
                        Select::make('transmission')
                            ->required()
                            ->options([
                                'manual' => 'Manual',
                                'automatic' => 'Automatic',
                            ]),
                        
                        Select::make('fuel_type')
                            ->label('Fuel Type')
                            ->required()
                            ->options([
                                'bensin' => 'Bensin (Gasoline)',
                                'diesel' => 'Diesel',
                                'electric' => 'Electric',
                                'hybrid' => 'Hybrid',
                            ]),
                        
                        Select::make('body_type')
                            ->required()
                            ->options([
                                'suv' => 'SUV',
                                'sedan' => 'Sedan',
                                'hatchback' => 'Hatchback',
                                'mpv' => 'MPV',
                                'pickup' => 'Pickup Truck',
                                'van' => 'Van',
                                'coupe' => 'Coupe',
                                'convertible' => 'Convertible',
                                'wagon' => 'Wagon',
                            ]),
                        
                        TextInput::make('color')
                            ->required()
                            ->maxLength(255),
                        
                        TextInput::make('seats')
                            ->label('Seating Capacity')
                            ->numeric()
                            ->minValue(2)
                            ->maxValue(20),
                    ])
                    ->columns(2),

                Section::make('Pricing & Location')
                    ->schema([
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0)
                            ->helperText('Price in Indonesian Rupiah (without decimals)'),
                        
                        Select::make('location_id')
                            ->label('Location/Branch')
                            ->relationship('location', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('name')->required(),
                                TextInput::make('address'),
                                TextInput::make('city'),
                            ]),
                    ])
                    ->columns(2),

                Section::make('Vehicle Documentation')
                    ->schema([
                        TextInput::make('vin')
                            ->label('VIN/Chassis Number')
                            ->maxLength(255),
                        
                        Select::make('plate_parity')
                            ->label('License Plate Parity')
                            ->options([
                                'ganjil' => 'Ganjil (Odd)',
                                'genap' => 'Genap (Even)',
                            ])
                            ->helperText('Indonesian odd/even traffic policy'),
                        
                        DatePicker::make('stnk_valid_until')
                            ->label('STNK Valid Until')
                            ->helperText('Vehicle registration expiration date'),
                    ])
                    ->columns(3),

                Section::make('Description & Features')
                    ->schema([
                        Textarea::make('description')
                            ->rows(4)
                            ->maxLength(5000)
                            ->columnSpanFull(),
                        
                        TagsInput::make('features')
                            ->label('Features & Equipment')
                            ->placeholder('Add feature and press Enter')
                            ->helperText('e.g., Airbags, ABS, Cruise Control')
                            ->columnSpanFull(),
                    ]),

                Section::make('Status & Visibility')
                    ->schema([
                        Toggle::make('featured')
                            ->label('Featured Listing')
                            ->default(false)
                            ->helperText('Show this car on homepage'),
                        
                        Toggle::make('sold')
                            ->label('Mark as Sold')
                            ->default(false),
                    ])
                    ->columns(2),
            ]);
    }
}

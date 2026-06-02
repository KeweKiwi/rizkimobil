<?php

namespace App\Filament\Resources\Locations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Cabang')
                    ->required()
                    ->maxLength(255),
                TextInput::make('address')
                    ->label('Alamat')
                    ->maxLength(255)
                    ->default(null),
                TextInput::make('city')
                    ->label('Kota')
                    ->maxLength(100)
                    ->default(null),
                TextInput::make('province')
                    ->label('Provinsi')
                    ->maxLength(100)
                    ->default(null),
                TextInput::make('postal_code')
                    ->label('Kode Pos')
                    ->maxLength(20)
                    ->default(null),
                TextInput::make('google_maps_url')
                    ->label('Google Maps URL')
                    ->url()
                    ->maxLength(255)
                    ->default(null),
                TextInput::make('phone')
                    ->label('Telepon')
                    ->tel()
                    ->maxLength(30)
                    ->default(null),
                TextInput::make('whatsapp')
                    ->label('WhatsApp')
                    ->tel()
                    ->maxLength(30)
                    ->default(null),
                Toggle::make('is_active')
                    ->label('Cabang aktif')
                    ->default(true),
            ]);
    }
}

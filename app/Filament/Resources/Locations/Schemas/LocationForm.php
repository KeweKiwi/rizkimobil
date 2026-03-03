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
                    ->required(),
                TextInput::make('address')
                    ->default(null),
                TextInput::make('city')
                    ->default(null),
                TextInput::make('province')
                    ->default(null),
                TextInput::make('postal_code')
                    ->default(null),
                TextInput::make('google_maps_url')
                    ->default(null),
                TextInput::make('phone')
                    ->tel()
                    ->default(null),
                TextInput::make('whatsapp')
                    ->default(null),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}

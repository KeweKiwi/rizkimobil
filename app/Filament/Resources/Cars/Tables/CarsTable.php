<?php

namespace App\Filament\Resources\Cars\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CarsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('')
                    ->getStateUsing(fn ($record) => $record->main_image)
                    ->height(52)
                    ->width(80)
                    ->extraImgAttributes(['class' => 'rounded object-cover']),

                TextColumn::make('make')
                    ->label('Brand')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('model')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => trim($record->variant . ' · ' . $record->year, ' · ')),

                TextColumn::make('price')
                    ->label('Price')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable()
                    ->weight('bold')
                    ->color('warning'),

                TextColumn::make('mileage_km')
                    ->label('Mileage')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', '.') . ' km')
                    ->sortable()
                    ->alignEnd(),

                TextColumn::make('transmission')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'automatic' => 'success',
                        'manual'    => 'info',
                        default     => 'gray',
                    }),

                TextColumn::make('fuel_type')
                    ->label('Fuel')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'bensin'   => 'gray',
                        'diesel'   => 'warning',
                        'electric' => 'success',
                        'hybrid'   => 'info',
                        default    => 'gray',
                    })
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('location.name')
                    ->label('Branch')
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('featured')
                    ->label('★')
                    ->boolean()
                    ->trueIcon('heroicon-s-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray')
                    ->alignCenter(),

                TextColumn::make('sold')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Sold' : 'Available')
                    ->color(fn ($state) => $state ? 'danger' : 'success'),

                TextColumn::make('stnk_valid_until')
                    ->label('STNK')
                    ->date('d M Y')
                    ->color(fn ($record) => $record->stnk_valid_until?->isPast() ? 'danger' : 'gray')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Listed')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('make')
                    ->label('Brand')
                    ->options([
                        'Toyota'        => 'Toyota',
                        'Honda'         => 'Honda',
                        'Daihatsu'      => 'Daihatsu',
                        'Suzuki'        => 'Suzuki',
                        'Mitsubishi'    => 'Mitsubishi',
                        'Nissan'        => 'Nissan',
                        'BMW'           => 'BMW',
                        'Mercedes-Benz' => 'Mercedes-Benz',
                        'Hyundai'       => 'Hyundai',
                        'Kia'           => 'Kia',
                    ])
                    ->multiple(),

                SelectFilter::make('transmission')
                    ->options([
                        'automatic' => 'Automatic',
                        'manual'    => 'Manual',
                    ]),

                SelectFilter::make('fuel_type')
                    ->label('Fuel Type')
                    ->options([
                        'bensin'   => 'Bensin',
                        'diesel'   => 'Diesel',
                        'electric' => 'Electric',
                        'hybrid'   => 'Hybrid',
                    ]),

                SelectFilter::make('body_type')
                    ->label('Body Type')
                    ->options([
                        'suv'       => 'SUV',
                        'mpv'       => 'MPV',
                        'sedan'     => 'Sedan',
                        'hatchback' => 'Hatchback',
                        'pickup'    => 'Pickup',
                        'van'       => 'Van',
                    ]),

                TernaryFilter::make('featured')
                    ->placeholder('All listings')
                    ->trueLabel('Featured only')
                    ->falseLabel('Not featured'),

                TernaryFilter::make('sold')
                    ->placeholder('All listings')
                    ->trueLabel('Sold')
                    ->falseLabel('Available'),

                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}

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
                ImageColumn::make('main_image')
                    ->label('Image')
                    ->defaultImageUrl(url('/images/placeholder-car.jpg'))
                    ->circular()
                    ->size(60),
                
                TextColumn::make('make')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                TextColumn::make('model')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->variant),
                
                TextColumn::make('year')
                    ->sortable()
                    ->alignCenter(),
                
                TextColumn::make('price')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->weight('bold')
                    ->color('success'),
                
                TextColumn::make('mileage_km')
                    ->label('Mileage')
                    ->numeric()
                    ->sortable()
                    ->suffix(' km')
                    ->alignEnd(),
                
                TextColumn::make('transmission')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'automatic' => 'success',
                        'manual' => 'info',
                        default => 'gray',
                    }),
                
                TextColumn::make('location.name')
                    ->label('Location')
                    ->sortable()
                    ->toggleable(),
                
                IconColumn::make('featured')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray')
                    ->alignCenter(),
                
                IconColumn::make('sold')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('warning')
                    ->alignCenter(),
                
                TextColumn::make('created_at')
                    ->label('Listed')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('make')
                    ->options([
                        'Toyota' => 'Toyota',
                        'Honda' => 'Honda',
                        'Daihatsu' => 'Daihatsu',
                        'Suzuki' => 'Suzuki',
                        'Mitsubishi' => 'Mitsubishi',
                        'Nissan' => 'Nissan',
                    ])
                    ->multiple(),
                
                SelectFilter::make('transmission')
                    ->options([
                        'manual' => 'Manual',
                        'automatic' => 'Automatic',
                    ]),
                
                SelectFilter::make('fuel_type')
                    ->options([
                        'bensin' => 'Bensin',
                        'diesel' => 'Diesel',
                        'electric' => 'Electric',
                        'hybrid' => 'Hybrid',
                    ]),
                
                TernaryFilter::make('featured')
                    ->label('Featured Only')
                    ->placeholder('All cars')
                    ->trueLabel('Featured')
                    ->falseLabel('Not featured'),
                
                TernaryFilter::make('sold')
                    ->placeholder('All cars')
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

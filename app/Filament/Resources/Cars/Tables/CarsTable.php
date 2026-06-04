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
use Illuminate\Database\Eloquent\Builder;

class CarsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['location', 'primaryImage', 'fallbackImage']))
            ->columns([
                ImageColumn::make('image')
                    ->label('')
                    ->getStateUsing(fn ($record) => $record->main_image)
                    ->height(52)
                    ->width(80)
                    ->extraImgAttributes(['class' => 'rounded object-cover']),

                TextColumn::make('make')
                    ->label('Merek')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('model')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => trim($record->variant . ' · ' . $record->year, ' · ')),

                TextColumn::make('price')
                    ->label('Harga')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable()
                    ->weight('bold')
                    ->color('warning'),

                TextColumn::make('mileage_km')
                    ->label('Kilometer')
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
                    ->label('BBM')
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
                    ->label('Cabang')
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
                    ->formatStateUsing(fn ($state) => $state ? 'Terjual' : 'Tersedia')
                    ->color(fn ($state) => $state ? 'danger' : 'success'),

                TextColumn::make('sold_at')
                    ->label('Tanggal Terjual')
                    ->date('d M Y')
                    ->placeholder('—')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('stnk_valid_until')
                    ->label('STNK')
                    ->date('d M Y')
                    ->color(fn ($record) => $record->stnk_valid_until?->isPast() ? 'danger' : 'gray')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Ditambahkan')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('make')
                    ->label('Merek')
                    ->options(fn (): array => config('rizki.car_makes'))
                    ->multiple(),

                SelectFilter::make('transmission')
                    ->label('Transmisi')
                    ->options([
                        'automatic' => 'Otomatis',
                        'manual'    => 'Manual',
                    ]),

                SelectFilter::make('fuel_type')
                    ->label('Bahan Bakar')
                    ->options([
                        'bensin'   => 'Bensin',
                        'diesel'   => 'Diesel',
                        'electric' => 'Electric',
                        'hybrid'   => 'Hybrid',
                    ]),

                SelectFilter::make('body_type')
                    ->label('Tipe Bodi')
                    ->options(fn (): array => config('rizki.car_body_types')),

                TernaryFilter::make('featured')
                    ->placeholder('Semua listing')
                    ->trueLabel('Hanya unggulan')
                    ->falseLabel('Bukan unggulan'),

                TernaryFilter::make('sold')
                    ->placeholder('Semua listing')
                    ->trueLabel('Terjual')
                    ->falseLabel('Tersedia'),

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

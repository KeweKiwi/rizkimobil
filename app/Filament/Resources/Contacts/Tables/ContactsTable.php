<?php

namespace App\Filament\Resources\Contacts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),
                
                TextColumn::make('phone')
                    ->searchable()
                    ->toggleable()
                    ->icon('heroicon-m-phone'),
                
                TextColumn::make('car.model')
                    ->label('Tertarik dengan')
                    ->sortable()
                    ->searchable()
                    ->description(fn ($record) => $record->car ? $record->car->make . ' ' . $record->car->year : 'Pertanyaan umum')
                    ->default('Pertanyaan umum'),
                
                TextColumn::make('message')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    })
                    ->toggleable(),
                
                TextColumn::make('created_at')
                    ->label('Diterima')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}

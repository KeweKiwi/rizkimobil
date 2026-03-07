<?php

namespace App\Filament\Widgets;

use App\Models\Car;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestCarsWidget extends TableWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('STNK Expiring Soon')
            ->description('Available cars with vehicle registration expiring within 30 days — take action')
            ->query(
                Car::query()
                    ->where('sold', false)
                    ->whereNotNull('stnk_valid_until')
                    ->where('stnk_valid_until', '<=', now()->addDays(30))
                    ->orderBy('stnk_valid_until', 'asc')
            )
            ->columns([
                ImageColumn::make('image')
                    ->label('')
                    ->getStateUsing(fn (Car $record) => $record->main_image)
                    ->height(48)
                    ->width(72)
                    ->extraImgAttributes(['class' => 'rounded object-cover']),

                TextColumn::make('title')
                    ->label('Car')
                    ->description(fn (Car $record) => $record->make . ' · ' . $record->year)
                    ->weight('bold'),

                TextColumn::make('price')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->color('gray'),

                TextColumn::make('stnk_valid_until')
                    ->label('STNK Expires')
                    ->date('d M Y')
                    ->color(fn (Car $record) => $record->stnk_valid_until->isPast()
                        ? 'danger'
                        : ($record->stnk_valid_until->diffInDays(now()) <= 7 ? 'warning' : 'gray')
                    )
                    ->weight(fn (Car $record) => $record->stnk_valid_until->isPast() ? 'bold' : null),

                TextColumn::make('stnk_status')
                    ->label('Status')
                    ->badge()
                    ->getStateUsing(fn (Car $record) => $record->stnk_valid_until->isPast()
                        ? 'Expired'
                        : 'Expiring in ' . $record->stnk_valid_until->diffForHumans()
                    )
                    ->color(fn (Car $record) => $record->stnk_valid_until->isPast() ? 'danger' : 'warning'),

                TextColumn::make('location.name')
                    ->label('Location')
                    ->color('gray')
                    ->placeholder('—'),
            ])
            ->emptyStateHeading('All good!')
            ->emptyStateDescription('No cars have STNK expiring in the next 30 days.')
            ->emptyStateIcon('heroicon-o-check-circle')
            ->paginated(false);
    }
}

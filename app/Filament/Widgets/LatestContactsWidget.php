<?php

namespace App\Filament\Widgets;

use App\Models\Contact;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestContactsWidget extends TableWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Lead Terbaru')
            ->description('Pertanyaan pelanggan terbaru — tindak lanjuti via WhatsApp atau email')
            ->query(
                Contact::query()
                    ->with('car')
                    ->latest()
                    ->limit(8)
            )
            ->columns([
                TextColumn::make('name')
                    ->weight('bold')
                    ->searchable(),

                TextColumn::make('phone')
                    ->icon('heroicon-m-phone')
                    ->color('gray')
                    ->placeholder('—')
                    ->url(fn (Contact $record) => $record->phone
                        ? 'https://wa.me/' . preg_replace('/\D/', '', $record->phone)
                        : null
                    )
                    ->openUrlInNewTab(),

                TextColumn::make('email')
                    ->icon('heroicon-m-envelope')
                    ->color('gray')
                    ->copyable(),

                TextColumn::make('car.title')
                    ->label('Tertarik dengan')
                    ->description(fn (Contact $record) => $record->car
                        ? 'Rp ' . number_format($record->car->price, 0, ',', '.')
                        : null
                    )
                    ->placeholder('Pertanyaan umum')
                    ->color('gray'),

                TextColumn::make('message')
                    ->limit(55)
                    ->tooltip(fn (TextColumn $column) => strlen((string) $column->getState()) > 55
                        ? $column->getState()
                        : null
                    )
                    ->color('gray'),

                TextColumn::make('created_at')
                    ->label('Diterima')
                    ->since()
                    ->color('gray'),
            ])
            ->paginated(false);
    }
}

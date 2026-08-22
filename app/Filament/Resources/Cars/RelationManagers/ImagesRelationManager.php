<?php

namespace App\Filament\Resources\Cars\RelationManagers;

use App\Models\CarImage;
use App\Support\CarImageUpload;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ImagesRelationManager extends RelationManager
{
    protected static bool $isLazy = false;

    protected static string $relationship = 'images';

    protected static ?string $title = 'Foto Mobil (maks. 13)';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image_path')
                    ->label('Foto')
                    ->image()
                    ->disk('public_root')
                    ->directory('images/cars')
                    ->visibility('public')
                    ->required()
                    ->imageEditor()
                    ->imageEditorAspectRatios(['16:9', '4:3', null])
                    ->maxSize(2048)
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->getUploadedFileNameForStorageUsing(CarImageUpload::storageName(...))
                    ->helperText('Maks. 2 MB · JPEG / PNG / WebP · Disarankan 1200×800 px')
                    ->columnSpanFull(),

                Toggle::make('is_primary')
                    ->label('Jadikan Foto Utama')
                    ->helperText('Ditampilkan sebagai thumbnail di listing dan hero di halaman detail')
                    ->default(false),

                TextInput::make('sort_order')
                    ->label('Urutan Tampil')
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->helperText('Angka lebih kecil = tampil lebih awal'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('image_path')
            ->reorderable('sort_order')
            ->defaultSort('sort_order', 'asc')
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Pratinjau')
                    ->disk('public_root')
                    ->height(72)
                    ->width(108)
                    ->extraImgAttributes(['class' => 'rounded object-cover']),

                IconColumn::make('is_primary')
                    ->label('Utama')
                    ->boolean()
                    ->trueIcon('heroicon-s-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray'),

                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Diunggah')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                TernaryFilter::make('is_primary')
                    ->label('Hanya Foto Utama'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Foto')
                    ->before(function (RelationManager $livewire) {
                        $count = $livewire->getOwnerRecord()->images()->count();
                        if ($count >= 13) {
                            Notification::make()
                                ->title('Batas foto tercapai')
                                ->body('Satu mobil maksimal 13 foto. Hapus foto lama sebelum menambah yang baru.')
                                ->danger()
                                ->send();
                            $this->halt();
                        }
                    })
                    ->after(function (CarImage $record) {
                        // If this is the first image, auto-set as primary
                        $car = $record->car;
                        if ($car->images()->count() === 1) {
                            $record->update(['is_primary' => true]);
                        }
                    }),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

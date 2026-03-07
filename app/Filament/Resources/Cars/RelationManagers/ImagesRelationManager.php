<?php

namespace App\Filament\Resources\Cars\RelationManagers;

use App\Models\CarImage;
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
    protected static string $relationship = 'images';

    protected static ?string $title = 'Car Images (max 13)';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image_path')
                    ->label('Image')
                    ->image()
                    ->disk('public_root')
                    ->directory('images/cars')
                    ->visibility('public')
                    ->required()
                    ->imageEditor()
                    ->imageEditorAspectRatios(['16:9', '4:3', null])
                    ->maxSize(5120) // 5 MB
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->helperText('Max 5 MB · JPEG / PNG / WebP · Recommended 1200×800 px')
                    ->columnSpanFull(),

                Toggle::make('is_primary')
                    ->label('Set as Primary Image')
                    ->helperText('Shown as thumbnail in listings and the hero on the detail page')
                    ->default(false),

                TextInput::make('sort_order')
                    ->label('Display Order')
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->helperText('Lower number = shown first'),
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
                    ->label('Preview')
                    ->disk('public_root')
                    ->height(72)
                    ->width(108)
                    ->extraImgAttributes(['class' => 'rounded object-cover']),

                IconColumn::make('is_primary')
                    ->label('Primary')
                    ->boolean()
                    ->trueIcon('heroicon-s-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray'),

                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                TernaryFilter::make('is_primary')
                    ->label('Primary Image Only'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add Image')
                    ->before(function (RelationManager $livewire) {
                        $count = $livewire->getOwnerRecord()->images()->count();
                        if ($count >= 13) {
                            Notification::make()
                                ->title('Image limit reached')
                                ->body('A car can have a maximum of 13 images. Please delete one before adding more.')
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

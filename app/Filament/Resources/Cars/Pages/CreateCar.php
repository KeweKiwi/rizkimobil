<?php

namespace App\Filament\Resources\Cars\Pages;

use App\Filament\Resources\Cars\CarResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Arr;

class CreateCar extends CreateRecord
{
    protected static string $resource = CarResource::class;

    /**
     * @var array<int, string>
     */
    protected array $uploadedImagePaths = [];

    protected function getHeaderActions(): array
    {
        return [
            Action::make('backToIndex')
                ->label('Kembali ke Daftar')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url(static::getResource()::getUrl('index')),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->uploadedImagePaths = array_values(array_filter(
            Arr::wrap($data['initial_images'] ?? []),
            fn ($path): bool => filled($path),
        ));

        unset($data['initial_images']);

        return $data;
    }

    protected function afterCreate(): void
    {
        if ((! $this->record) || blank($this->uploadedImagePaths)) {
            return;
        }

        foreach ($this->uploadedImagePaths as $index => $path) {
            $this->record->images()->create([
                'image_path' => $path,
                'is_primary' => $index === 0,
                'sort_order' => $index,
            ]);
        }
    }
}

<?php

namespace App\Support;

use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class CarImageUpload
{
    /** @var array<string, string> */
    private const EXTENSIONS_BY_MIME = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    public static function storageName(TemporaryUploadedFile $file): string
    {
        return Str::ulid().'.'.self::extensionForMime($file->getMimeType());
    }

    public static function extensionForMime(?string $mimeType): string
    {
        return self::EXTENSIONS_BY_MIME[$mimeType]
            ?? throw ValidationException::withMessages([
                'image' => 'Foto harus berformat JPEG, PNG, atau WebP.',
            ]);
    }
}

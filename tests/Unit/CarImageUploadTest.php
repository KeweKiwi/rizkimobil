<?php

namespace Tests\Unit;

use App\Support\CarImageUpload;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CarImageUploadTest extends TestCase
{
    /** @return array<string, array{string, string}> */
    public static function allowedMimeTypes(): array
    {
        return [
            'jpeg' => ['image/jpeg', 'jpg'],
            'png' => ['image/png', 'png'],
            'webp' => ['image/webp', 'webp'],
        ];
    }

    #[DataProvider('allowedMimeTypes')]
    public function test_it_derives_a_safe_extension_from_server_detected_mime(
        string $mimeType,
        string $extension,
    ): void {
        $this->assertSame($extension, CarImageUpload::extensionForMime($mimeType));
    }

    public function test_it_rejects_an_unsupported_mime_type(): void
    {
        $this->expectException(ValidationException::class);

        CarImageUpload::extensionForMime('application/x-php');
    }
}

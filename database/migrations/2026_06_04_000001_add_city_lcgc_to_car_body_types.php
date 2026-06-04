<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const CURRENT_TYPES = [
        'suv',
        'sedan',
        'hatchback',
        'mpv',
        'pickup',
        'van',
        'coupe',
        'convertible',
        'wagon',
    ];

    private const NEW_TYPES = [
        'suv',
        'sedan',
        'hatchback',
        'city',
        'lcgc',
        'mpv',
        'pickup',
        'van',
        'coupe',
        'convertible',
        'wagon',
    ];

    public function up(): void
    {
        $this->modifyBodyTypeEnum(self::NEW_TYPES);
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::table('cars')
                ->whereIn('body_type', ['city', 'lcgc'])
                ->update(['body_type' => 'hatchback']);
        }

        $this->modifyBodyTypeEnum(self::CURRENT_TYPES);
    }

    /**
     * @param array<int, string> $types
     */
    private function modifyBodyTypeEnum(array $types): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        $enumValues = collect($types)
            ->map(fn (string $type): string => "'" . str_replace("'", "''", $type) . "'")
            ->implode(',');

        DB::statement("ALTER TABLE cars MODIFY body_type ENUM({$enumValues}) NULL");
    }
};

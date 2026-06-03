<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Akun')
                    ->description('Gunakan role admin hanya untuk tim yang boleh masuk ke panel admin.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Telepon / WhatsApp')
                            ->tel()
                            ->required()
                            ->maxLength(30)
                            ->helperText('Dipakai untuk follow-up pelanggan atau koordinasi akun admin.'),
                        Toggle::make('is_admin')
                            ->label('Akun admin')
                            ->helperText('Aktifkan agar akun ini bisa masuk ke panel admin.')
                            ->default(false)
                            ->disabled(fn (?User $record): bool => $record?->getKey() === auth()->id())
                            ->dehydrated(true),
                    ])
                    ->columns(2),

                Section::make('Password')
                    ->description('Wajib saat membuat akun. Saat edit, gunakan aksi Reset Password agar perubahan lebih terkontrol.')
                    ->schema([
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->revealable()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->confirmed(fn (?string $state): bool => filled($state))
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->minLength(8)
                            ->maxLength(255),
                        TextInput::make('password_confirmation')
                            ->label('Konfirmasi password')
                            ->password()
                            ->revealable()
                            ->required(fn (Get $get, string $operation): bool => $operation === 'create' || filled($get('password')))
                            ->dehydrated(false),
                    ])
                    ->columns(2),

                Section::make('Konteks Akun')
                    ->description('Informasi ini membantu admin memahami akun tanpa membuka data sensitif.')
                    ->visible(fn (string $operation): bool => $operation === 'edit')
                    ->schema([
                        Text::make(fn (?User $record): string => 'Akses: ' . ($record?->isAdmin() ? 'Admin panel' : 'Pelanggan')),
                        Text::make(fn (?User $record): string => 'Mobil tersimpan: ' . number_format($record?->favorites()->count() ?? 0)),
                        Text::make(fn (?User $record): string => 'Dibuat: ' . ($record?->created_at?->format('d M Y H:i') ?? '-')),
                        Text::make(fn (?User $record): string => 'Terakhir diubah: ' . ($record?->updated_at?->format('d M Y H:i') ?? '-')),
                    ]),
            ]);
    }
}

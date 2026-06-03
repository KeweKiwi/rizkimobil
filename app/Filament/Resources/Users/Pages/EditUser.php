<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('resetPassword')
                ->label('Reset Password')
                ->modalHeading('Reset password akun')
                ->modalDescription('Gunakan password baru minimal 8 karakter. Password lama tidak akan ditampilkan.')
                ->schema([
                    TextInput::make('password')
                        ->label('Password baru')
                        ->password()
                        ->revealable()
                        ->required()
                        ->confirmed()
                        ->minLength(8)
                        ->maxLength(255),
                    TextInput::make('password_confirmation')
                        ->label('Konfirmasi password baru')
                        ->password()
                        ->revealable()
                        ->required()
                        ->dehydrated(false),
                ])
                ->action(function (array $data): void {
                    $this->getRecord()->update([
                        'password' => $data['password'],
                    ]);
                })
                ->successNotificationTitle('Password akun berhasil direset'),
            DeleteAction::make()
                ->hidden(fn (): bool => $this->isProtectedAdminRecord($this->getRecord())),
        ];
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $record = $this->getRecord();
        $willRemoveAdminAccess = $record->isAdmin() && ! (bool) ($data['is_admin'] ?? false);

        if ($willRemoveAdminAccess && $record->getKey() === auth()->id()) {
            Notification::make()
                ->title('Akses admin sendiri tidak bisa dicabut')
                ->body('Gunakan akun admin lain untuk mengubah akses akun ini.')
                ->warning()
                ->send();

            $this->halt();
        }

        if ($willRemoveAdminAccess && $this->isLastAdmin($record)) {
            Notification::make()
                ->title('Minimal harus ada satu akun admin')
                ->body('Buat atau aktifkan admin lain sebelum mencabut akses admin akun ini.')
                ->warning()
                ->send();

            $this->halt();
        }

        return $data;
    }

    private function isProtectedAdminRecord(User $record): bool
    {
        return $record->getKey() === auth()->id()
            || ($record->isAdmin() && $this->isLastAdmin($record));
    }

    private function isLastAdmin(User $record): bool
    {
        return ! User::query()
            ->where('is_admin', true)
            ->whereKeyNot($record->getKey())
            ->exists();
    }
}

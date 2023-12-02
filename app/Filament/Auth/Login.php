<?php

namespace App\Filament\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;

class Login extends \Filament\Pages\Auth\Login
{
    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('username')
            ->label('Username')
            ->required()
            ->autocomplete()
            ->autofocus();
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'username' => $data['username'],
            'password' => $data['password'],
        ];
    }
}

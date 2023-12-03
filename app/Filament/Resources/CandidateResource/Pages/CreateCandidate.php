<?php

namespace App\Filament\Resources\CandidateResource\Pages;

use App\Filament\Resources\CandidateResource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;

class CreateCandidate extends CreateRecord
{
    protected static string $resource = CandidateResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCancelFormAction(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getActions(): array
    {
        return [

        ];
    }
}

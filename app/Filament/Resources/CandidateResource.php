<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CandidateResource\Pages;
use App\Models\Candidate;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CandidateResource extends Resource
{
    protected static ?string $model = Candidate::class;

    protected static ?string $label = 'Kandidat';
    protected static ?string $navigationLabel = 'Kandidat';
    protected static ?string $slug = 'candidates';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $recordTitleAttribute = 'id';

    public static function getNavigationUrl(): string
    {
        if (!auth()->user()->is_admin) {
            return Pages\CreateCandidate::getNavigationUrl();
        }
        return parent::getNavigationUrl();
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->label('Nama Kandidat'),
            TextColumn::make('votes')->label('Suara yang Didapat')
        ])->deferLoading();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCandidates::route('/'),
            'create' => Pages\CreateCandidate::route('/create'),
            'edit' => Pages\EditCandidate::route('/{record}/edit'),
            'vote' => Pages\VoteCandidate::route('/vote'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CandidateResource\Pages;
use App\Models\Candidate;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class CandidateResource extends Resource
{
    protected static ?string $model = Candidate::class;

    protected static ?string $label = 'Kandidat';
    protected static ?string $navigationLabel = 'Kandidat';
    protected static ?string $slug = 'candidates';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Placeholder::make('created_at')
                ->label('Created Date')
                ->content(fn(?Candidate $record): string => $record?->created_at?->diffForHumans() ?? '-'),

            Placeholder::make('updated_at')
                ->label('Last Modified Date')
                ->content(fn(?Candidate $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->label('Nama'),
            TextColumn::make('votes')->label('suara')
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCandidates::route('/'),
            'create' => Pages\CreateCandidate::route('/create'),
            'edit' => Pages\EditCandidate::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CandidateResource\Pages;
use App\Models\Candidate;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CandidateResource extends Resource
{
    protected static ?string $model = Candidate::class;

    protected static ?string $label = 'Formatur';
    protected static ?string $navigationLabel = 'Formatur';
    protected static ?string $slug = 'candidates';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $recordTitleAttribute = 'id';

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->username === 'admin';
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->username === 'admin';
    }

    public static function getNavigationUrl(): string
    {
        if (!auth()->user()->is_admin) {
            return Pages\VoteCandidate::getNavigationUrl();
        }
        return parent::getNavigationUrl();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Nama')
                ->required(),
            TextInput::make('votes')
                ->label('suara')
                ->numeric()
                ->default(0)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')
                ->label('Nama Kandidat')
                ->searchable(query: function (Builder $query, string $search): Builder {
                    return $query
                        ->whereFullText('name', $search . '*', ['mode' => 'boolean']);
                }),
            TextColumn::make('votes')->label('Suara yang Didapat')
        ])
            ->actions([
                Action::make('hapus_perolehan_suara_performatur')
                    ->label('Hapus Suara')
                    ->requiresConfirmation()
                    ->visible(auth()->user()->username === 'admin')
                    ->color('warning')
                    ->action(fn(Model $record) => $record->update(['votes' => 0])),
                EditAction::make('edit'),
                DeleteAction::make('delete')
            ])
            ->filters([
                Filter::make('voted')
                    ->label('Memiliki suara')
                    ->query(fn(Builder $query): Builder => $query->where('votes', '>', 0)),
                Filter::make('unvoted')
                    ->label('Tidak memiliki suara')
                    ->query(fn(Builder $query): Builder => $query->where('votes', 0)),
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query->orderByDesc('votes'))
            ->paginated([9, 24, 49, 100, 'all'])
            ->headerActions([
                Action::make('hapus_semua_formatur')
                    ->requiresConfirmation()
                    ->visible(auth()->user()->username === 'admin')
                    ->action(function () {
                        self::getModel()::truncate();
                    }),
                Action::make('hapus_perolehan_suara')
                    ->requiresConfirmation()
                    ->visible(auth()->user()->username === 'admin')
                    ->action(function () {
                        \DB::table('candidates')->update(['votes' => 0]);
                    })
                    ->outlined()
            ])
            ->deferLoading();
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

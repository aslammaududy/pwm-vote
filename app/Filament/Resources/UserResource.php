<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Pengguna';
    protected static ?string $modelLabel = 'Pengguna';

    public static function canViewAny(): bool
    {
        return auth()->user()->is_admin;
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->username === 'admin';
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()->username === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make([
                    'default' => 1
                ])->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama')
                        ->required(),
                    Forms\Components\TextInput::make('username')->required(),
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->hidden(function (Request $request, Forms\Set $set) {
                            return self::getRouteBaseName() === 'filament.admin.resources.users';
                        }),
                    Forms\Components\Toggle::make('is_admin')
                        ->onColor('success')
                        ->offColor('danger'),
                    Forms\Components\Toggle::make('has_chosen')
                        ->label('Telah Memilih')
                        ->onColor('success')
                        ->offColor('danger'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->whereFullText('name', $search . '*', ['mode' => 'boolean']);
                    }),
                Tables\Columns\TextColumn::make('username')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->whereFullText('username', $search . '*', ['mode' => 'boolean']);
                    }),
                Tables\Columns\TextColumn::make('is_admin')
                    ->label('Admin')
                    ->formatStateUsing(fn(string $state): string => $state == 1 ? 'Ya' : 'Tidak'),
                Tables\Columns\TextColumn::make('has_chosen')
                    ->label('Telah Memilih')
                    ->formatStateUsing(fn(string $state): string => $state == 1 ? 'Ya' : 'Tidak')
            ])->actions([
                EditAction::make('edit'),
                DeleteAction::make('delete')
            ])->filters([
                Tables\Filters\Filter::make('is_admin')
                    ->label('Admin')
                    ->query(fn(Builder $query): Builder => $query->where('is_admin', true)),
                Tables\Filters\Filter::make('has_chosen')
                    ->label('Telah memilih')
                    ->query(fn(Builder $query): Builder => $query->where('has_chosen', true))
            ])
            ->deferLoading();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

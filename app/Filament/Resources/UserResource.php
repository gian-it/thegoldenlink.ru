<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\Enums\Sex;
use App\Models\Role;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?int $navigationSort = 4900;

    protected static function getNavigationGroup(): ?string
    {
        return __('Users');
    }

    public static function getLabel(): string
    {
        return __('Site User');
    }

    public static function getPluralLabel(): string
    {
        return __('Users');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Toggle::make('is_subscribed')
                            ->label(__('Is Subscribed'))
                            ->default(true)
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('name')
                            ->label(__('User Name'))
                            ->required(),

                        Forms\Components\TextInput::make('spiritual_name')
                            ->label(__('Spiritual Name')),

                        Forms\Components\TextInput::make('email')
                            ->unique(ignorable: fn (?Model $record): ?Model => $record)
                            ->label(__('Email'))
                            ->required()
                            ->email(),

                        Forms\Components\TextInput::make('password')
                            ->disableAutocomplete()
                            ->required(
                                fn (
                                    $component,
                                    $get,
                                    $livewire,
                                    $model,
                                    $record,
                                    $set,
                                    $state
                                ) => $record === null
                            )
                            ->dehydrateStateUsing(fn ($state) => !empty($state) ? Hash::make($state) : '')
                            ->password()
                            ->label(__('Password')),

                        Forms\Components\TextInput::make('phone')
                            ->label(__('Phone'))
                            ->tel(),

                        Forms\Components\Select::make('sex')
                            ->label(__('Sex'))
                            ->options(Sex::options()),

                        Forms\Components\MultiSelect::make('roles')
                            ->preload()
                            ->relationship('roles', 'display_name')
                            ->label(__('Roles')),

                        Forms\Components\SpatieMediaLibraryFileUpload::make('avatar')
                            ->collection('avatar')
                            ->label(__('Avatar'))
                            ->image(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('ID'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('User Name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('spiritual_name')
                    ->label(__('Spiritual Name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label(__('Phone'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BooleanColumn::make('is_subscribed')
                    ->label(__('Is Subscribed'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->sortable()
                    ->dateTime()
            ])
            ->filters([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [

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

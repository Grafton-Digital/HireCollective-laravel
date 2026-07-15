<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\Boutique;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make()->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->maxLength(255),
                Select::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'boutique_owner' => 'Boutique Owner',
                    ])
                    ->required()
                    ->native(false),
                Select::make('boutique_id')
                    ->label('Boutique')
                    ->options(Boutique::pluck('name', 'id'))
                    ->searchable()
                    ->visible(fn (Get $get): bool => $get('role') === 'boutique_owner'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->colors([
                        'danger' => 'admin',
                        'primary' => 'boutique_owner',
                    ]),
                Tables\Columns\TextColumn::make('boutique.name')
                    ->label('Boutique')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'boutique_owner' => 'Boutique Owner',
                    ]),
                Tables\Filters\SelectFilter::make('boutique')
                    ->relationship('boutique', 'name'),
            ])
            ->actions([
                Actions\EditAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
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

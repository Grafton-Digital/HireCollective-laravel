<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoutiqueResource\Pages;
use App\Models\Boutique;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BoutiqueResource extends Resource
{
    protected static ?string $model = Boutique::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingStorefront;

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Details')->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\MarkdownEditor::make('description')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->visible(fn () => auth()->user()?->isAdmin() ?? false),
            ])->columns(2),

            Section::make('Images')->schema([
                Forms\Components\FileUpload::make('logo')
                    ->image()
                    ->disk('public')
                    ->directory('boutiques/logos')
                    ->visibility('public'),
                Forms\Components\FileUpload::make('cover_image')
                    ->image()
                    ->disk('public')
                    ->directory('boutiques/covers')
                    ->visibility('public'),
            ])->columns(2),

            Section::make('Location & Contact')->schema([
                Forms\Components\TextInput::make('address')
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->maxLength(100),
                Forms\Components\TextInput::make('county')
                    ->maxLength(100),
                Forms\Components\TextInput::make('contact_email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(50),
            ])->columns(2),

            Section::make('Opening Hours & Social')->schema([
                Forms\Components\KeyValue::make('opening_hours')
                    ->keyLabel('Day')
                    ->valueLabel('Hours')
                    ->addActionLabel('Add day'),
                Forms\Components\KeyValue::make('social_links')
                    ->keyLabel('Platform')
                    ->valueLabel('URL')
                    ->addActionLabel('Add link'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => static::scopeToUserBoutiques($query))
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->disk('public')
                    ->circular()
                    ->imageHeight(40),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('city'),
                Tables\Columns\TextColumn::make('county'),
                Tables\Columns\TextColumn::make('products_count')
                    ->counts('products')
                    ->label('Products'),
                Tables\Columns\TextColumn::make('users_count')
                    ->counts('users')
                    ->label('Staff'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBoutiques::route('/'),
            'create' => Pages\CreateBoutique::route('/create'),
            'edit' => Pages\EditBoutique::route('/{record}/edit'),
        ];
    }

    protected static function scopeToUserBoutiques($query)
    {
        $user = auth()->user();

        if ($user && $user->isBoutiqueOwner()) {
            if ($user->boutique_id) {
                return $query->where('id', $user->boutique_id)
                    ->where('status', Boutique::STATUS_APPROVED);
            }

            return $query->whereRaw('1 = 0');
        }

        if ($user && $user->isAdmin()) {
            return $query->where('status', Boutique::STATUS_APPROVED);
        }

        return $query;
    }
}

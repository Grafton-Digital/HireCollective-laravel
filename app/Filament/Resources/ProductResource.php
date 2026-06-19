<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Boutique;
use App\Models\Product;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingBag;

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Product Details')->schema([
                Forms\Components\Select::make('boutique_id')
                    ->label('Boutique')
                    ->options(Boutique::where('is_active', true)->pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->native(false),
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
            ])->columns(2),

            Section::make('Pricing & Type')->schema([
                Forms\Components\Toggle::make('is_variable')
                    ->label('Has size variants')
                    ->live(),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('€')
                    ->visible(fn (Get $get): bool => ! $get('is_variable')),
                Forms\Components\Toggle::make('is_available')
                    ->default(true),
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
            ])->columns(2),

            Section::make('Variants')
                ->schema([
                    Forms\Components\Repeater::make('variants')
                        ->relationship()
                        ->schema([
                            Forms\Components\TextInput::make('size')
                                ->required()
                                ->maxLength(10),
                            Forms\Components\TextInput::make('price')
                                ->numeric()
                                ->required()
                                ->prefix('€'),
                            Forms\Components\Toggle::make('is_available')
                                ->default(true),
                        ])
                        ->columns(3)
                        ->addActionLabel('Add variant'),
                ])
                ->visible(fn (Get $get): bool => (bool) $get('is_variable')),

            Section::make('Images')->schema([
                Forms\Components\FileUpload::make('featured_image')
                    ->image()
                    ->directory('products/featured'),
                Forms\Components\Repeater::make('images')
                    ->relationship()
                    ->schema([
                        Forms\Components\FileUpload::make('path')
                            ->image()
                            ->required()
                            ->directory('products/gallery'),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_featured')
                            ->default(false),
                    ])
                    ->columns(3)
                    ->addActionLabel('Add image')
                    ->columnSpanFull(),
            ]),

            Section::make('Categorisation')->schema([
                Forms\Components\Select::make('categories')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->preload(),
                Forms\Components\Select::make('colours')
                    ->relationship('colours', 'name')
                    ->multiple()
                    ->preload(),
                Forms\Components\Select::make('occasions')
                    ->relationship('occasions', 'name')
                    ->multiple()
                    ->preload(),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->imageHeight(50)
                    ->square(),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('boutique.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('EUR')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_variable')
                    ->boolean()
                    ->label('Variants'),
                Tables\Columns\IconColumn::make('is_available')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('boutique')
                    ->relationship('boutique', 'name'),
                Tables\Filters\TernaryFilter::make('is_active'),
                Tables\Filters\TernaryFilter::make('is_available'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}

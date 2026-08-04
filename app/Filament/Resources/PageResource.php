<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Category;
use App\Models\Occasion;
use App\Models\Page;
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

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            // Homepage template sections
            Section::make('Hero Section')
                ->schema([
                    Section::make('Hero Left (Main)')
                        ->schema([
                            Forms\Components\FileUpload::make('content.hero.left.image')
                                ->label('Background Image')
                                ->image()
                                ->disk('public')
                                ->directory('pages/homepage'),
                            Forms\Components\TextInput::make('content.hero.left.heading')
                                ->label('Heading')
                                ->required(),
                            Forms\Components\Textarea::make('content.hero.left.subtitle')
                                ->label('Subtitle')
                                ->rows(2),
                            Forms\Components\TextInput::make('content.hero.left.button_text')
                                ->label('Button Text'),
                            Forms\Components\TextInput::make('content.hero.left.button_link')
                                ->label('Button Link')
                                ->helperText('e.g. /products'),
                        ]),
                    Section::make('Hero Right')
                        ->schema([
                            Forms\Components\FileUpload::make('content.hero.right.image')
                                ->label('Background Image')
                                ->image()
                                ->disk('public')
                                ->directory('pages/homepage'),
                            Forms\Components\TextInput::make('content.hero.right.text')
                                ->label('Text'),
                        ]),
                ])
                ->visible(fn (Get $get): bool => $get('template') === 'homepage')
                ->columnSpanFull(),

            Section::make('Featured Edit of the Week')
                ->schema([
                    Forms\Components\TextInput::make('content.featured.heading')
                        ->label('Heading')
                        ->required(),
                    Forms\Components\Select::make('content.featured.occasion_id')
                        ->label('Event Tag (Occasion)')
                        ->options(fn () => Occasion::pluck('name', 'id'))
                        ->placeholder('All Products')
                        ->helperText('Filter featured products by occasion'),
                    Forms\Components\TextInput::make('content.featured.count')
                        ->label('Number of Products')
                        ->numeric()
                        ->default(3)
                        ->minValue(1)
                        ->maxValue(12),
                ])
                ->visible(fn (Get $get): bool => $get('template') === 'homepage')
                ->columnSpanFull(),

            Section::make('Product Categories')
                ->schema([
                    Forms\Components\Repeater::make('content.categories')
                        ->label('Categories')
                        ->schema([
                            Forms\Components\FileUpload::make('image')
                                ->label('Image')
                                ->image()
                                ->disk('public')
                                ->directory('pages/homepage/categories'),
                            Forms\Components\TextInput::make('text')
                                ->label('Label')
                                ->required(),
                            Forms\Components\Select::make('link')
                                ->label('Category')
                                ->options(fn () => Category::pluck('name', 'slug')
                                    ->mapWithKeys(fn ($name, $slug) => ["/products?category={$slug}" => $name])
                                    ->prepend('All Products', '/products'))
                                ->required(),
                        ])
                        ->collapsible()
                        ->reorderable()
                        ->columns(2),
                ])
                ->visible(fn (Get $get): bool => $get('template') === 'homepage')
                ->columnSpanFull(),

            Section::make('New Arrivals')
                ->schema([
                    Forms\Components\TextInput::make('content.new_arrivals.heading')
                        ->label('Heading')
                        ->required(),
                ])
                ->visible(fn (Get $get): bool => $get('template') === 'homepage')
                ->columnSpanFull(),

            Section::make('For Collaboration')
                ->schema([
                    Forms\Components\FileUpload::make('content.collaboration.image')
                        ->label('Background Image')
                        ->image()
                        ->disk('public')
                        ->directory('pages/homepage'),
                    Forms\Components\TextInput::make('content.collaboration.heading')
                        ->label('Heading')
                        ->required(),
                    Forms\Components\Textarea::make('content.collaboration.text')
                        ->label('Text')
                        ->rows(3),
                    Forms\Components\TextInput::make('content.collaboration.button_text')
                        ->label('Button Text'),
                    Forms\Components\TextInput::make('content.collaboration.button_link')
                        ->label('Button Link')
                        ->helperText('e.g. /products'),
                ])
                ->visible(fn (Get $get): bool => $get('template') === 'homepage')
                ->columnSpanFull(),

            Section::make('Brands We Represent')
                ->schema([
                    Forms\Components\TextInput::make('content.brands.count')
                        ->label('Number of Boutiques')
                        ->numeric()
                        ->default(6)
                        ->minValue(1)
                        ->maxValue(20),
                    Forms\Components\TextInput::make('content.brands.button_text')
                        ->label('Button Text'),
                    Forms\Components\TextInput::make('content.brands.button_link')
                        ->label('Button Link')
                        ->helperText('e.g. /boutiques'),
                ])
                ->visible(fn (Get $get): bool => $get('template') === 'homepage')
                ->columnSpanFull(),

            Section::make('Register Your Boutique')
                ->schema([
                    Forms\Components\FileUpload::make('content.register.image')
                        ->label('Background Image')
                        ->image()
                        ->disk('public')
                        ->directory('pages/homepage'),
                    Forms\Components\TextInput::make('content.register.heading')
                        ->label('Heading')
                        ->required(),
                    Forms\Components\TextInput::make('content.register.button_text')
                        ->label('Button Text'),
                    Forms\Components\TextInput::make('content.register.button_link')
                        ->label('Button Link')
                        ->helperText('e.g. /boutique/apply'),
                ])
                ->visible(fn (Get $get): bool => $get('template') === 'homepage')
                ->columnSpanFull(),

            // How It Works template
            Section::make('Page Content')
                ->schema([
                    Forms\Components\TextInput::make('content.heading')
                        ->label('Heading')
                        ->required(),
                    Forms\Components\Textarea::make('content.subtitle')
                        ->label('Subtitle')
                        ->rows(2),
                    Forms\Components\Repeater::make('content.faq')
                        ->label('FAQ Items')
                        ->schema([
                            Forms\Components\TextInput::make('question')
                                ->required(),
                            Forms\Components\Textarea::make('answer')
                                ->required()
                                ->rows(3),
                        ])
                        ->collapsible()
                        ->cloneable()
                        ->reorderable()
                        ->columns(1),
                ])
                ->visible(fn (Get $get): bool => $get('template') === 'how-it-works')
                ->columnSpanFull(),

            // Default markdown template
            Section::make('Content')
                ->schema([
                    Forms\Components\MarkdownEditor::make('content.body')
                        ->label('Content')
                        ->columnSpanFull(),
                ])
                ->visible(fn (Get $get): bool => ! $get('template'))
                ->columnSpanFull(),

            // General settings (always visible, at bottom)
            Section::make('General')->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\Select::make('template')
                    ->options([
                        'homepage' => 'Homepage',
                        'how-it-works' => 'How It Works (FAQ)',
                    ])
                    ->placeholder('Default (Markdown)')
                    ->live(),
                Forms\Components\Toggle::make('is_published')
                    ->default(true),
            ])->columns(2)->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('template')
                    ->badge()
                    ->placeholder('Default'),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}

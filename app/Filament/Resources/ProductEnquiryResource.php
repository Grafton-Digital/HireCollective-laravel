<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductEnquiryResource\Pages;
use App\Models\Product;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;

class ProductEnquiryResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingBag;

    protected static ?string $navigationLabel = 'Product Enquiries';

    protected static ?string $modelLabel = 'Product Enquiry';

    protected static ?string $pluralModelLabel = 'Product Enquiries';

    protected static ?int $navigationSort = 3;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Product Details')->schema([
                Forms\Components\Select::make('boutique_id')
                    ->label('Boutique')
                    ->relationship('boutique', 'name')
                    ->required()
                    ->searchable()
                    ->native(false),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('designer')
                    ->label('Designer/Brand')
                    ->maxLength(255),
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
                    ->visible(fn ($get): bool => ! $get('is_variable')),
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
                        ->defaultItems(0)
                        ->addActionLabel('Add variant'),
                ])
                ->visible(fn ($get): bool => (bool) $get('is_variable')),

            Section::make('Images')->schema([
                Forms\Components\FileUpload::make('featured_image')
                    ->image()
                    ->disk('public')
                    ->directory('products/featured')
                    ->visibility('public'),
                Forms\Components\Repeater::make('images')
                    ->relationship()
                    ->schema([
                        Forms\Components\FileUpload::make('path')
                            ->image()
                            ->required()
                            ->disk('public')
                            ->directory('products/gallery')
                            ->visibility('public'),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_featured')
                            ->default(false),
                    ])
                    ->columns(3)
                    ->defaultItems(0)
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

            Section::make('Approval')->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        Product::STATUS_PENDING => 'Pending',
                        Product::STATUS_APPROVED => 'Approved',
                        Product::STATUS_REJECTED => 'Rejected',
                    ])
                    ->required(),
            ]),

            Section::make('Submission Info')->schema([
                Forms\Components\TextInput::make('submittedBy.name')
                    ->label('Submitted By')
                    ->disabled(),
                Forms\Components\TextInput::make('submittedBy.email')
                    ->label('Submitter Email')
                    ->disabled(),
                Forms\Components\TextInput::make('created_at')
                    ->label('Submitted At')
                    ->disabled(),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->where('status', Product::STATUS_PENDING)->with(['submittedBy', 'boutique']))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Product name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('designer')
                    ->label('Designer/Brand')
                    ->searchable(),
                Tables\Columns\TextColumn::make('boutique.name')
                    ->label('Boutique')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('GBP')
                    ->sortable(),
                Tables\Columns\TextColumn::make('submittedBy.name')
                    ->label('Submitted By')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\Action::make('approve')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Product $record) {
                        $record->approve();

                        Notification::make()
                            ->success()
                            ->title('Product Approved')
                            ->body("The product '{$record->name}' has been approved.")
                            ->send();
                    }),
                Actions\Action::make('reject')
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (Product $record) {
                        $record->reject();

                        Notification::make()
                            ->warning()
                            ->title('Product Rejected')
                            ->body("The product '{$record->name}' has been rejected.")
                            ->send();
                    }),
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
            'index' => Pages\ListProductEnquiries::route('/'),
            'edit' => Pages\EditProductEnquiry::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    public static function getNavigationBadge(): ?string
    {
        if (! auth()->user()?->isAdmin()) {
            return null;
        }

        $count = Product::where('status', Product::STATUS_PENDING)->count();

        return $count > 0 ? (string) $count : null;
    }
}

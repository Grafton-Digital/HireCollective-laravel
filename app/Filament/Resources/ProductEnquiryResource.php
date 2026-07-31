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
                Forms\Components\TextInput::make('name')
                    ->disabled()
                    ->columnSpan(1),
                Forms\Components\TextInput::make('slug')
                    ->disabled()
                    ->columnSpan(1),
                Forms\Components\TextInput::make('designer')
                    ->disabled()
                    ->columnSpan(1),
                Forms\Components\TextInput::make('price_per_day')
                    ->disabled()
                    ->prefix('€')
                    ->columnSpan(1),
                Forms\Components\MarkdownEditor::make('description')
                    ->disabled()
                    ->columnSpanFull(),
            ])->columns(2),

            Section::make('Images')->schema([
                Forms\Components\FileUpload::make('featured_image')
                    ->image()
                    ->disk('public')
                    ->directory('products')
                    ->visibility('public')
                    ->disabled(),
            ]),

            Section::make('Categorisation')->schema([
                Forms\Components\TextInput::make('size')
                    ->disabled(),
                Forms\Components\TextInput::make('county')
                    ->disabled(),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->disabled(),
            ])->columns(3),

            Section::make('Status')->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        Product::STATUS_PENDING => 'Pending',
                        Product::STATUS_APPROVED => 'Approved',
                        Product::STATUS_REJECTED => 'Rejected',
                    ])
                    ->disabled()
                    ->columnSpan(1),
                Forms\Components\Toggle::make('is_active')
                    ->disabled()
                    ->columnSpan(1),
            ])->columns(2),

            Section::make('Submission Info')->schema([
                Forms\Components\TextInput::make('boutique.name')
                    ->label('Boutique')
                    ->disabled(),
                Forms\Components\TextInput::make('submittedBy.name')
                    ->label('Submitted By')
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
            ->modifyQueryUsing(fn ($query) => $query->where('status', Product::STATUS_PENDING)->with(['boutique', 'submittedBy']))
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image')
                    ->disk('public')
                    ->square()
                    ->imageHeight(40),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('boutique.name')
                    ->label('Boutique')
                    ->sortable(),
                Tables\Columns\TextColumn::make('designer')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_per_day')
                    ->money('eur')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->dateTime()
                    ->sortable(),
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
                    ->schema([
                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Reason for rejection')
                            ->placeholder('Explain what needs to be changed...')
                            ->required()
                            ->rows(4),
                    ])
                    ->action(function (Product $record, array $data) {
                        $record->reject($data['rejection_reason']);

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

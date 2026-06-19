<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnquiryResource\Pages;
use App\Models\Enquiry;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;

class EnquiryResource extends Resource
{
    protected static ?string $model = Enquiry::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Enquiry Details')->schema([
                Forms\Components\TextInput::make('customer_name')
                    ->disabled(),
                Forms\Components\TextInput::make('customer_email')
                    ->disabled(),
                Forms\Components\TextInput::make('customer_phone')
                    ->disabled(),
                Forms\Components\TextInput::make('desired_dates')
                    ->disabled(),
                Forms\Components\Textarea::make('message')
                    ->disabled()
                    ->columnSpanFull(),
            ])->columns(2),

            Section::make('Product Info')->schema([
                Forms\Components\Placeholder::make('product_name')
                    ->label('Product')
                    ->content(fn (Enquiry $record): string => $record->product?->name ?? '—'),
                Forms\Components\Placeholder::make('boutique_name')
                    ->label('Boutique')
                    ->content(fn (Enquiry $record): string => $record->boutique?->name ?? '—'),
                Forms\Components\Placeholder::make('variant_size')
                    ->label('Size')
                    ->content(fn (Enquiry $record): string => $record->variant?->size ?? '—'),
            ])->columns(3),

            Section::make('Status')->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'new' => 'New',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required()
                    ->native(false),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('customer_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->limit(25),
                Tables\Columns\TextColumn::make('boutique.name'),
                Tables\Columns\TextColumn::make('desired_dates'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'new',
                        'primary' => 'in_progress',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                Tables\Filters\SelectFilter::make('boutique')
                    ->relationship('boutique', 'name'),
            ])
            ->actions([
                Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEnquiries::route('/'),
            'edit' => Pages\EditEnquiry::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoutiqueEnquiryResource\Pages;
use App\Models\Boutique;
use Filament\Actions;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;

class BoutiqueEnquiryResource extends Resource
{
    protected static ?string $model = Boutique::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelopeOpen;

    protected static ?string $navigationLabel = 'Boutique Enquiries';

    protected static ?string $modelLabel = 'Boutique Enquiry';

    protected static ?string $pluralModelLabel = 'Boutique Enquiries';

    protected static ?int $navigationSort = 2;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Details')->schema([
                Forms\Components\TextInput::make('name')
                    ->disabled()
                    ->columnSpan(1),
                Forms\Components\TextInput::make('slug')
                    ->disabled()
                    ->columnSpan(1),
                Forms\Components\MarkdownEditor::make('description')
                    ->disabled()
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->options([
                        Boutique::STATUS_PENDING => 'Pending',
                        Boutique::STATUS_APPROVED => 'Approved',
                        Boutique::STATUS_REJECTED => 'Rejected',
                    ])
                    ->required()
                    ->columnSpan(1),
                Forms\Components\Toggle::make('is_active')
                    ->columnSpan(1),
            ])->columns(2),

            Section::make('Images')->schema([
                Forms\Components\FileUpload::make('logo')
                    ->image()
                    ->disk('public')
                    ->directory('boutiques/logos')
                    ->visibility('public')
                    ->disabled(),
                Forms\Components\FileUpload::make('cover_image')
                    ->image()
                    ->disk('public')
                    ->directory('boutiques/covers')
                    ->visibility('public')
                    ->disabled(),
            ])->columns(2),

            Section::make('Location & Contact')->schema([
                Forms\Components\TextInput::make('address')
                    ->disabled(),
                Forms\Components\TextInput::make('city')
                    ->disabled(),
                Forms\Components\TextInput::make('county')
                    ->disabled(),
                Forms\Components\TextInput::make('contact_email')
                    ->email()
                    ->disabled(),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->disabled(),
            ])->columns(2),

            Section::make('Opening Hours & Social')->schema([
                Forms\Components\KeyValue::make('opening_hours')
                    ->keyLabel('Day')
                    ->valueLabel('Hours')
                    ->disabled(),
                Forms\Components\KeyValue::make('social_links')
                    ->keyLabel('Platform')
                    ->valueLabel('URL')
                    ->disabled(),
            ])->columns(2),

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
            ->modifyQueryUsing(fn ($query) => $query->where('status', Boutique::STATUS_PENDING)->with('submittedBy'))
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
                    ->action(function (Boutique $record) {
                        $record->approve();

                        Notification::make()
                            ->success()
                            ->title('Boutique Approved')
                            ->body("The boutique '{$record->name}' has been approved.")
                            ->send();
                    }),
                Actions\Action::make('reject')
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (Boutique $record) {
                        $record->reject();

                        Notification::make()
                            ->warning()
                            ->title('Boutique Rejected')
                            ->body("The boutique '{$record->name}' has been rejected.")
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
            'index' => Pages\ListBoutiqueEnquiries::route('/'),
            'edit' => Pages\EditBoutiqueEnquiry::route('/{record}/edit'),
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

        $count = Boutique::where('status', Boutique::STATUS_PENDING)->count();

        return $count > 0 ? (string) $count : null;
    }
}

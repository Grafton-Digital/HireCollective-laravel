<?php

namespace App\Filament\Resources\Trainings\Schemas;

use Filament\Forms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TrainingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(10)
            ->components([
                Section::make()->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\RichEditor::make('description')
                        ->extraAttributes(['style' => 'min-height: 300px']),
                ])->columnSpan(7),

                Section::make()->schema([
                    Forms\Components\FileUpload::make('video_path')
                        ->label('Video (MP4)')
                        ->disk('public')
                        ->directory('trainings/videos')
                        ->visibility('public')
                        ->maxSize(256000)
                        ->required(),
                    Forms\Components\FileUpload::make('thumbnail_path')
                        ->label('Thumbnail')
                        ->image()
                        ->disk('public')
                        ->directory('trainings/thumbnails'),
                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()
                        ->default(0),
                    Forms\Components\Toggle::make('is_published')
                        ->default(true),
                ])->columnSpan(3),
            ]);
    }
}

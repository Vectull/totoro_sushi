<?php

namespace App\Filament\Admin\Resources\Categories\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('parent_id')
                    ->relationship('parent', 'name')
                    ->label('Родительская категория')
                    ->placeholder('Без родительской категории')
                    ->default(null),
                TextInput::make('name')
                    ->label('Название')
                    ->required(),
                TextInput::make('slug')
                    ->label('URL-имя')
                    ->helperText('Латиницей. Используется в адресе страницы категории.')
                    ->required(),
                Textarea::make('description')
                    ->label('Описание')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->label('Фото категории')
                    ->image()
                    ->disk('public')
                    ->directory('categories')
                    ->visibility('public')
                    ->imagePreviewHeight('250')
                    ->maxSize(5120),
                Toggle::make('is_active')
                    ->label('Активна')
                    ->required(),
                TextInput::make('sort_order')
                    ->label('Порядок сортировки')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}

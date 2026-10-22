<?php

namespace App\Filament\Admin\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('parent.name')
                    ->label('Родительская категория')
                    ->placeholder('-'),
                TextEntry::make('name')->label('Название'),
                TextEntry::make('slug')->label('URL-имя'),
                TextEntry::make('description')
                    ->label('Описание')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('is_active')
                    ->label('Активна')
                    ->boolean(),
                TextEntry::make('sort_order')
                    ->label('Порядок сортировки')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->label('Создана')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('Обновлена')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->label('Удалена')
                    ->dateTime()
                    ->visible(fn (Category $record): bool => $record->trashed()),
            ]);
    }
}

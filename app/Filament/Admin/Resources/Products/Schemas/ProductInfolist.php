<?php

namespace App\Filament\Admin\Resources\Products\Schemas;

use App\Models\Product;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('category.name')
                    ->label('Категория'),
                TextEntry::make('name')->label('Название'),
                TextEntry::make('slug')->label('URL-имя'),
                TextEntry::make('description')
                    ->label('Описание')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('composition')
                    ->label('Состав')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('price')
                    ->label('Цена')
                    ->money(),
                TextEntry::make('old_price')
                    ->label('Старая цена')
                    ->money()
                    ->placeholder('-'),
                TextEntry::make('discount_percent')
                    ->label('Скидка, %')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('weight')
                    ->label('Вес, г')
                    ->placeholder('-'),
                TextEntry::make('pieces')
                    ->label('Количество, шт.')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('product_modifiers_summary')
                    ->label('Добавки')
                    ->state(fn (Product $record): array => $record->productModifiers()
                        ->with('modifier')
                        ->get()
                        ->filter(fn ($item) => $item->modifier)
                        ->map(fn ($item) => $item->modifier->name
                            . ' — '
                            . number_format((float) $item->modifier->price, 2, ',', ' ')
                            . ' ₽'
                            . ($item->is_required ? ' · обязательно' : ''))
                        ->values()
                        ->all())
                    ->listWithLineBreaks()
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('is_active')
                    ->label('Активен')
                    ->boolean(),
                IconEntry::make('is_popular')
                    ->label('Популярный')
                    ->boolean(),
                IconEntry::make('is_new')
                    ->label('Новинка')
                    ->boolean(),
                IconEntry::make('is_promotion')
                    ->label('Акция')
                    ->boolean(),
                TextEntry::make('labels')
                    ->label('Метки')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('characteristics')
                    ->label('Характеристики')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('allergens')
                    ->label('Аллергены')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->label('Создан')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('Обновлён')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->label('Удалён')
                    ->dateTime()
                    ->visible(fn (Product $record): bool => $record->trashed()),
            ]);
    }
}

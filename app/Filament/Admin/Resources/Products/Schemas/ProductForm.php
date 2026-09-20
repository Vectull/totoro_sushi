<?php

namespace App\Filament\Admin\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->label('Категория')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Описание')
                    ->columnSpanFull(),

                Textarea::make('composition')
                    ->label('Состав')
                    ->columnSpanFull(),

                TextInput::make('price')
                    ->label('Цена')
                    ->numeric()
                    ->prefix('₽')
                    ->required(),

                TextInput::make('old_price')
                    ->label('Старая цена')
                    ->numeric()
                    ->prefix('₽'),

                TextInput::make('discount_percent')
                    ->label('Скидка, %')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100),

                TextInput::make('weight')
                    ->label('Вес, г')
                    ->numeric()
                    ->minValue(0),

                TextInput::make('pieces')
                    ->label('Количество, шт.')
                    ->numeric()
                    ->minValue(0),

                Toggle::make('is_active')
                    ->label('Активен')
                    ->default(true),

                Toggle::make('is_popular')
                    ->label('Популярный'),

                Toggle::make('is_new')
                    ->label('Новинка'),

                Toggle::make('is_promotion')
                    ->label('Акция'),

                TagsInput::make('labels')
                    ->label('Метки')
                    ->placeholder('Добавить метку')
                    ->columnSpanFull(),

                TagsInput::make('characteristics')
                    ->label('Характеристики')
                    ->placeholder('Добавить характеристику')
                    ->columnSpanFull(),

                TagsInput::make('allergens')
                    ->label('Аллергены')
                    ->placeholder('Добавить аллерген')
                    ->columnSpanFull(),
            ]);
    }
}
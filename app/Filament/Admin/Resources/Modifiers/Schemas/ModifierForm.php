<?php

namespace App\Filament\Admin\Resources\Modifiers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ModifierForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Название')
                ->required()
                ->maxLength(255),

            TextInput::make('slug')
                ->label('Системный код')
                ->helperText('Латиницей. Используется для настройки добавки.')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),

            TextInput::make('price')
                ->label('Цена')
                ->numeric()
                ->minValue(0)
                ->prefix('₽')
                ->required(),

            Toggle::make('is_active')
                ->label('Активна')
                ->default(true),
        ]);
    }
}

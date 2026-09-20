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
                    ->label('Category'),
                TextEntry::make('name'),
                TextEntry::make('slug'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('composition')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('price')
                    ->money(),
                TextEntry::make('old_price')
                    ->money()
                    ->placeholder('-'),
                TextEntry::make('discount_percent')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('weight')
                    ->placeholder('-'),
                TextEntry::make('pieces')
                    ->numeric()
                    ->placeholder('-'),
                IconEntry::make('is_active')
                    ->boolean(),
                IconEntry::make('is_popular')
                    ->boolean(),
                IconEntry::make('is_new')
                    ->boolean(),
                IconEntry::make('is_promotion')
                    ->boolean(),
                TextEntry::make('labels')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('characteristics')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('allergens')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Product $record): bool => $record->trashed()),
            ]);
    }
}

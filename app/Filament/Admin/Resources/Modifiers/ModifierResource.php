<?php

namespace App\Filament\Admin\Resources\Modifiers;

use App\Filament\Admin\Resources\Modifiers\Pages\CreateModifier;
use App\Filament\Admin\Resources\Modifiers\Pages\EditModifier;
use App\Filament\Admin\Resources\Modifiers\Pages\ListModifiers;
use App\Filament\Admin\Resources\Modifiers\Schemas\ModifierForm;
use App\Filament\Admin\Resources\Modifiers\Tables\ModifiersTable;
use App\Models\Modifier;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ModifierResource extends Resource
{
    protected static ?string $model = Modifier::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Каталог';

    protected static ?int $navigationSort = 3;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?string $navigationLabel = 'Добавки';

    protected static ?string $modelLabel = 'добавка';

    protected static ?string $pluralModelLabel = 'Добавки';

    public static function form(Schema $schema): Schema
    {
        return ModifierForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ModifiersTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('slug', '!=', 'chopsticks');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListModifiers::route('/'),
            'create' => CreateModifier::route('/create'),
            'edit' => EditModifier::route('/{record}/edit'),
        ];
    }
}

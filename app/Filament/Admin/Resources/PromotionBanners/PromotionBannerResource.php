<?php

namespace App\Filament\Admin\Resources\PromotionBanners;

use App\Filament\Admin\Resources\PromotionBanners\Pages\CreatePromotionBanner;
use App\Filament\Admin\Resources\PromotionBanners\Pages\EditPromotionBanner;
use App\Filament\Admin\Resources\PromotionBanners\Pages\ListPromotionBanners;
use App\Models\PromotionBanner;
use BackedEnum;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PromotionBannerResource extends Resource
{
    protected static ?string $model = PromotionBanner::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Продвижение';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Карусель';

    protected static ?string $modelLabel = 'слайд карусели';

    protected static ?string $pluralModelLabel = 'Слайды карусели';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Содержимое слайда')
                ->description('Баннер появится в каталоге, если он включён. Порядок определяет позицию в карусели.')
                ->columns(2)
                ->schema([
                    TextInput::make('title')
                        ->label('Заголовок')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('sort_order')
                        ->label('Порядок показа')
                        ->numeric()
                        ->integer()
                        ->minValue(0)
                        ->default(0)
                        ->required(),
                    Textarea::make('description')
                        ->label('Текст баннера')
                        ->rows(3)
                        ->columnSpanFull(),
                    SpatieMediaLibraryFileUpload::make('image_path')
                        ->label('Изображение')
                        ->image()
                        ->disk('public')
                        ->collection('banner-image')
                        ->conversion('catalog')
                        ->imageEditor()
                        ->columnSpanFull(),
                    TextInput::make('button_label')
                        ->label('Текст кнопки')
                        ->maxLength(80),
                    TextInput::make('button_url')
                        ->label('Ссылка кнопки')
                        ->url()
                        ->maxLength(2048)
                        ->helperText('Укажите полный адрес, например https://example.ru/catalog.'),
                    Toggle::make('is_active')
                        ->label('Показывать в каталоге')
                        ->default(true),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('image_path')
                    ->label('Изображение')
                    ->collection('banner-image')
                    ->conversion('catalog'),
                TextColumn::make('title')->label('Заголовок')->searchable()->sortable(),
                TextColumn::make('sort_order')->label('Порядок')->sortable(),
                IconColumn::make('is_active')->label('Показывается')->boolean(),
                TextColumn::make('updated_at')->label('Изменён')->dateTime()->sortable(),
            ])
            ->defaultSort('sort_order')
            ->recordActions([
                \Filament\Actions\EditAction::make()->label('Изменить'),
                \Filament\Actions\DeleteAction::make()->label('Удалить'),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make()->label('Удалить выбранные'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPromotionBanners::route('/'),
            'create' => CreatePromotionBanner::route('/create'),
            'edit' => EditPromotionBanner::route('/{record}/edit'),
        ];
    }
}

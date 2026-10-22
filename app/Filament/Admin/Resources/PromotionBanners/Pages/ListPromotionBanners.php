<?php

namespace App\Filament\Admin\Resources\PromotionBanners\Pages;

use App\Filament\Admin\Resources\PromotionBanners\PromotionBannerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPromotionBanners extends ListRecords
{
    protected static string $resource = PromotionBannerResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()->label('Добавить слайд')];
    }
}

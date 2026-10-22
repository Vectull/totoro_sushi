<?php

namespace App\Filament\Admin\Resources\PromotionBanners\Pages;

use App\Filament\Admin\Resources\PromotionBanners\PromotionBannerResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPromotionBanner extends EditRecord
{
    protected static string $resource = PromotionBannerResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()->label('Удалить')];
    }
}

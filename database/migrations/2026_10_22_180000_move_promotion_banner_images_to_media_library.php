<?php

use App\Models\PromotionBanner;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    public function up(): void
    {
        PromotionBanner::query()
            ->whereNotNull('image_path')
            ->orderBy('id')
            ->each(function (PromotionBanner $banner): void {
                $path = ltrim($banner->image_path, '/');

                if ($path === '' || ! Storage::disk('public')->exists($path)) {
                    return;
                }

                $banner->addMediaFromDisk($path, 'public')
                    ->toMediaCollection('banner-image');
            });
    }

    public function down(): void
    {
        // The original image_path and public files are retained for rollback.
    }
};

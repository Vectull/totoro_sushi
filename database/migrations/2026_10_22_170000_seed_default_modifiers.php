<?php

use App\Models\Modifier;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        foreach ([
            ['name' => 'Соевый соус', 'slug' => 'soy-sauce', 'price' => 35],
            ['name' => 'Васаби', 'slug' => 'wasabi', 'price' => 30],
            ['name' => 'Имбирь', 'slug' => 'ginger', 'price' => 20],
            ['name' => 'Дополнительный соус', 'slug' => 'extra-sauce', 'price' => 45],
        ] as $modifier) {
            Modifier::query()->firstOrCreate(
                ['slug' => $modifier['slug']],
                [
                    'name' => $modifier['name'],
                    'price' => $modifier['price'],
                    'is_active' => true,
                ],
            );
        }
    }

    public function down(): void
    {
        // Do not remove modifier records: admins may have edited or assigned them.
    }
};

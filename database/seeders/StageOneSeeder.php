<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Modifier;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductImage;
use App\Models\ProductModifier;
use Illuminate\Database\Seeder;

class StageOneSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Роллы', 'slug' => 'rolls', 'description' => 'Классические и фирменные роллы.'],
            ['name' => 'Суши', 'slug' => 'sushi', 'description' => 'Классические суши и нигири.'],
            ['name' => 'Наборы', 'slug' => 'sets', 'description' => 'Готовые наборы для компании и семьи.'],
            ['name' => 'Сашими', 'slug' => 'sashimi', 'description' => 'Свежая рыба и деликатесы.'],
            ['name' => 'WOK', 'slug' => 'wok', 'description' => 'Тёплые блюда и лапша WOK.'],
            ['name' => 'Закуски', 'slug' => 'snacks', 'description' => 'Лёгкие закуски и салаты.'],
            ['name' => 'Напитки', 'slug' => 'drinks', 'description' => 'Напитки и освежающие выборки.'],
            ['name' => 'Соусы и дополнения', 'slug' => 'sauces', 'description' => 'Соусы, дополнения и базовые элементы.'],
        ];

        $createdCategories = [];

        foreach ($categories as $categoryData) {
            $createdCategories[] = Category::query()->firstOrCreate(
                ['slug' => $categoryData['slug']],
                [
                    'name' => $categoryData['name'],
                    'description' => $categoryData['description'],
                    'is_active' => true,
                    'sort_order' => count($createdCategories),
                ]
            );
        }

        $attributesConfig = [
            'type' => ['values' => ['Классический', 'Фирменный', 'Горячий', 'Запечённый']],
            'spicy' => ['values' => ['Без остроты', 'Средне', 'Остро']],
            'baked' => ['values' => ['Нет', 'Да']],
            'vegetarian' => ['values' => ['Нет', 'Да']],
            'vegan' => ['values' => ['Нет', 'Да']],
            'size' => ['values' => ['Маленький', 'Средний', 'Большой']],
        ];

        $attributeMap = [];

        foreach ($attributesConfig as $slug => $config) {
            $attribute = Attribute::query()->firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => ucfirst($slug),
                    'type' => 'select',
                    'is_filterable' => true,
                ]
            );

            $attributeMap[$slug] = $attribute;

            foreach ($config['values'] as $valueLabel) {
                $valueSlug = str($valueLabel)->slug()->toString();

                $attributeValue = AttributeValue::query()->firstOrCreate(
                    ['attribute_id' => $attribute->id, 'slug' => $valueSlug],
                    [
                        'value' => $valueLabel,
                    ]
                );

                $attributeMap[$slug . ':' . $valueLabel] = $attributeValue;
            }
        }

        $modifiers = [
            ['name' => 'Соевый соус', 'slug' => 'soy-sauce', 'price' => 35.00],
            ['name' => 'Васаби', 'slug' => 'wasabi', 'price' => 30.00],
            ['name' => 'Имбирь', 'slug' => 'ginger', 'price' => 20.00],
            ['name' => 'Палочки', 'slug' => 'chopsticks', 'price' => 40.00],
            ['name' => 'Доп. соус', 'slug' => 'extra-sauce', 'price' => 45.00],
        ];

        $modifierMap = [];

        foreach ($modifiers as $modifierData) {
            $modifier = Modifier::query()->firstOrCreate(
                ['slug' => $modifierData['slug']],
                [
                    'name' => $modifierData['name'],
                    'price' => $modifierData['price'],
                    'is_active' => true,
                ]
            );

            $modifierMap[$modifierData['slug']] = $modifier;
        }

        $productsData = [
            [
                'category_slug' => 'rolls',
                'name' => 'Филадельфия Классик',
                'slug' => 'philadelphia-classic',
                'description' => 'Классический ролл с лососем и сливочным сыром.',
                'composition' => 'Лосось, сливочный сыр, рис, нори.',
                'price' => 399.00,
                'old_price' => 459.00,
                'discount_percent' => 13,
                'weight' => '240 г',
                'pieces' => 8,
                'labels' => ['hit', 'new'],
                'characteristics' => ['Классический', 'Средне'],
                'allergens' => ['рыба', 'молоко'],
            ],
            [
                'category_slug' => 'rolls',
                'name' => 'Калифорния Спайси',
                'slug' => 'california-spicy',
                'description' => 'Сливочно-острый ролл с креветкой и авокадо.',
                'composition' => 'Креветка, авокадо, огурец, сливочный сыр.',
                'price' => 429.00,
                'old_price' => null,
                'discount_percent' => null,
                'weight' => '260 г',
                'pieces' => 8,
                'labels' => ['promo'],
                'characteristics' => ['Фирменный', 'Остро'],
                'allergens' => ['морепродукты', 'молоко'],
            ],
            [
                'category_slug' => 'sushi',
                'name' => 'Лосось Нигири',
                'slug' => 'salmon-nigiri',
                'description' => 'Свежий лосось на рисе с лёгким уксусом.',
                'composition' => 'Лосось, рис, васаби.',
                'price' => 189.00,
                'old_price' => null,
                'discount_percent' => null,
                'weight' => '120 г',
                'pieces' => 4,
                'labels' => ['popular'],
                'characteristics' => ['Классический'],
                'allergens' => ['рыба'],
            ],
            [
                'category_slug' => 'sets',
                'name' => 'Семейный сет',
                'slug' => 'family-set',
                'description' => 'Набор для компании и семейного ужина.',
                'composition' => 'Роллы, суши, соусы, закуски.',
                'price' => 1490.00,
                'old_price' => 1690.00,
                'discount_percent' => 12,
                'weight' => '1.2 кг',
                'pieces' => 28,
                'labels' => ['new'],
                'characteristics' => ['Большой'],
                'allergens' => ['рыба', 'молоко'],
            ],
            [
                'category_slug' => 'sashimi',
                'name' => 'Сашими микс',
                'slug' => 'sashimi-mix',
                'description' => 'Набор свежего сашими с тунцом, лососем и окунем.',
                'composition' => 'Свежая рыба, соевый соус, имбирь.',
                'price' => 620.00,
                'old_price' => null,
                'discount_percent' => null,
                'weight' => '220 г',
                'pieces' => 12,
                'labels' => ['popular'],
                'characteristics' => ['Средний'],
                'allergens' => ['рыба'],
            ],
            [
                'category_slug' => 'wok',
                'name' => 'Лапша WOK с курицей',
                'slug' => 'wok-chicken',
                'description' => 'Горячее блюдо с курицей, овощами и ароматным соусом.',
                'composition' => 'Курица, овощи, лапша, соус.',
                'price' => 480.00,
                'old_price' => null,
                'discount_percent' => null,
                'weight' => '320 г',
                'pieces' => null,
                'labels' => ['new'],
                'characteristics' => ['Горячий'],
                'allergens' => ['глютен', 'соевый соус'],
            ],
            [
                'category_slug' => 'snacks',
                'name' => 'Салат с крабом',
                'slug' => 'crab-salad',
                'description' => 'Нежный салат с крабовым мясом и овощами.',
                'composition' => 'Краб, овощи, соус.',
                'price' => 280.00,
                'old_price' => 320.00,
                'discount_percent' => 12,
                'weight' => '180 г',
                'pieces' => null,
                'labels' => ['promo'],
                'characteristics' => ['Средний'],
                'allergens' => ['морепродукты'],
            ],
            [
                'category_slug' => 'drinks',
                'name' => 'Японский чай',
                'slug' => 'japanese-tea',
                'description' => 'Освежающий горячий напиток с лёгкой травяной нотой.',
                'composition' => 'Чай, вода.',
                'price' => 120.00,
                'old_price' => null,
                'discount_percent' => null,
                'weight' => '300 мл',
                'pieces' => null,
                'labels' => [],
                'characteristics' => ['Средний'],
                'allergens' => [],
            ],
        ];

        foreach ($productsData as $productData) {
            $category = Category::query()->where('slug', $productData['category_slug'])->firstOrFail();

            $product = Product::query()->firstOrCreate(
                ['slug' => $productData['slug']],
                [
                    'category_id' => $category->id,
                    'name' => $productData['name'],
                    'description' => $productData['description'],
                    'composition' => $productData['composition'],
                    'price' => $productData['price'],
                    'old_price' => $productData['old_price'],
                    'discount_percent' => $productData['discount_percent'],
                    'weight' => $productData['weight'],
                    'pieces' => $productData['pieces'],
                    'is_active' => true,
                    'is_popular' => in_array('popular', $productData['labels'], true),
                    'is_new' => in_array('new', $productData['labels'], true),
                    'is_promotion' => in_array('promo', $productData['labels'], true),
                    'labels' => $productData['labels'],
                    'characteristics' => $productData['characteristics'],
                    'allergens' => $productData['allergens'],
                ]
            );

            ProductImage::query()->firstOrCreate(
                ['product_id' => $product->id, 'path' => '/images/products/' . $product->slug . '.jpg'],
                [
                    'alt' => $product->name,
                    'sort_order' => 1,
                    'is_main' => true,
                ]
            );

            foreach ($productData['characteristics'] as $characteristicName) {
                $attributeValue = AttributeValue::query()
                    ->where('value', $characteristicName)
                    ->first();

                if ($attributeValue) {
                    ProductAttributeValue::query()->firstOrCreate(
                        [
                            'product_id' => $product->id,
                            'attribute_id' => $attributeValue->attribute_id,
                            'attribute_value_id' => $attributeValue->id,
                        ]
                    );
                }
            }

            foreach ($modifierMap as $modifier) {
                ProductModifier::query()->firstOrCreate(
                    [
                        'product_id' => $product->id,
                        'modifier_id' => $modifier->id,
                    ],
                    [
                        'is_required' => false,
                        'sort_order' => 0,
                    ]
                );
            }
        }
    }
}

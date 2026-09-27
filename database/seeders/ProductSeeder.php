<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Seed the application's product catalog.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Sunset Bloom Bangle',
                'description' => 'Warm coral and amber tones with a smooth polished finish.',
                'price' => 499.00,
                'color' => 'Coral',
                'sizes' => ['2/2' => 6, '2/4' => 6, '2/6' => 6],
                'image' => null,
            ],
            [
                'name' => 'Emerald Mist Stack',
                'description' => 'Soft green translucent bangles designed for daily wear.',
                'price' => 599.00,
                'color' => 'Emerald',
                'sizes' => ['2/4' => 5, '2/6' => 5, '2/8' => 4],
                'image' => null,
            ],
            [
                'name' => 'Royal Ivory Set',
                'description' => 'Minimal ivory-tone set with subtle gold accents.',
                'price' => 799.00,
                'color' => 'Ivory',
                'sizes' => ['2/6' => 3, '2/8' => 3, '2/10' => 3],
                'image' => null,
            ],
            [
                'name' => 'Midnight Sparkle Pair',
                'description' => 'Deep midnight blue with a reflective glitter touch.',
                'price' => 699.00,
                'color' => 'Navy',
                'sizes' => ['2/8' => 2, '2/10' => 2, '2/12' => 2],
                'image' => null,
            ],
        ];

        foreach ($products as $data) {
            Product::updateOrCreate(
                ['name' => $data['name']],
                $data,
            );
        }
    }
}

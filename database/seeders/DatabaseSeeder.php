<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $rootCategories = Category::factory(5)->create();

        foreach ($rootCategories as $rootCategory) {
            $subCategories = Category::factory(4)->create(['parent_id' => $rootCategory->id]);

            foreach ($subCategories as $subCategory) {
                $childCategories = Category::factory(4)->create(['parent_id' => $subCategory->id]);

                foreach ($childCategories as $child) {
                    Category::factory(3)->create(['parent_id' => $child->id]);
                }
            }
        }

        Tag::factory(20)->create();
        Product::factory(100)->create()->each(function ($product) {
            $product->categories()->attach(Category::inRandomOrder()->take(rand(1, 5))->pluck('id'));
            $product->tags()->attach(Tag::inRandomOrder()->take(rand(1, 5))->pluck('id'));
        });
    }
}

<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Models\Size;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategorySeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(ColorSeeder::class);
        $this->call(SizeSeeder::class);

        User::factory(10)->create();
        User::factory()->create([
            'email' => 'admin@gmail.com',
            'role_id' => '0'
        ]);

        $customer = User::factory(['role_id' => 1])->create();
        $categories = Category::all();
        $brands = Brand::all();
        $colors = Color::all();
        $sizes = Size::all();

        $products = [];

        // READ PRODUCTS.JSON
        $contents = file_get_contents(__DIR__ . "/products.json");
        $productsData = json_decode($contents, true);

        foreach ($productsData as $productData) {
            $products[] = Product::factory(['name' => $productData['name']])
                ->has(
                    ProductVariant::factory()
                        ->for($sizes->random())
                        ->for($colors->random())
                        ->has(ProductImage::factory(), 'image'),
                    'variants'
                )
                ->has(
                    ProductVariant::factory()
                        ->for($sizes->random())
                        ->for($colors->random())
                        ->has(ProductImage::factory(), 'image'),
                    'variants'
                )
                ->has(
                    ProductVariant::factory()
                        ->for($sizes->random())
                        ->for($colors->random())
                        ->has(ProductImage::factory(), 'image'),
                    'variants'
                )
                ->has(ProductImage::factory(3), 'images')
                ->has(ProductImage::factory([
                    'image' => $productData['image'],
                    'type' => 'cover'
                ]), 'images')
                ->has(
                    Review::factory(5)
                        ->for($customer)
                )
                ->for($categories->random())
                ->for($brands->random())
                ->create();
        }
    }
}

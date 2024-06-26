<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Review;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(1)->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin'
        ]);
        
        User::factory(3)->create();
        Company::factory(5)->create();
        Category::factory(5)->create();
        Tag::factory(10)->create();
        Product::factory(5)->create()->each(function ($product) {
            Review::factory(rand(1,3))->create(['product_id' => $product->id]);
            $product->tags()->attach([rand(1,10)]);
            $ratings = Rating::factory(rand(0,10))->create(['product_id' => $product->id]);
            $product->update(['rate' => $ratings->avg('rate') ?? 0]);
        });

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

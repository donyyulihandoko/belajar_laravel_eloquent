<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = new Product();
        $product->id = '1';
        $product->name = 'product1';
        $product->description = 'description product1';
        $product->price = 2_000_000;
        $product->stok = 100;
        $product->category_id = 'FOOD';
        $product->save();

        $product = new Product();
        $product->id = '2';
        $product->name = 'product2';
        $product->description = 'description product2';
        $product->price = 3_000_000;
        $product->stok = 100;
        $product->category_id = 'FOOD';
        $product->save();

        $product = new Product();
        $product->id = '3';
        $product->name = 'product3';
        $product->description = 'description product3';
        $product->price = 4_000_000;
        $product->stok = 100;
        $product->category_id = 'FOOD';
        $product->save();

        $product = new Product();
        $product->id = '4';
        $product->name = 'product4';
        $product->description = 'description product4';
        $product->price = 5_000_000;
        // $product->stok = 100;
        $product->category_id = 'FOOD';
        $product->save();
    }
}

<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Voucher;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tag = new Tag();
        $tag->id = 'pzn';
        $tag->name = 'programmer zaman now';
        $tag->save();

        $product = Product::query()->find('1');
        $product->tags()->attach($tag);

        $voucher = Voucher::query()->first('id');
        $voucher->tags()->attach($tag);
    }
}

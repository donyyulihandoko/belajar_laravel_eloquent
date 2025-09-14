<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;

use Database\Seeders\CategorySeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\TagSeeder;
use Database\Seeders\VoucherSeeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function testOneToMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
        $product = Product::query()->find('1');
        self::assertNotNull($product);

        $category = $product->category;
        self::assertNotNull($category);
        self::assertEquals('FOOD', $category->id);

        $category->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testRelationshipQuery()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
        $category = Category::query()->find('FOOD');
        $products = $category->products;
        self::assertCount(4, $products);

        $outOfStockProduct = $category->products()->where('stok', '<=', 0)->get();
        self::assertCount(1, $outOfStockProduct);
    }

    public function testHasOfMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
        $category = Category::query()->find('FOOD');
        self::assertNotNull($category);

        $cheapestProduct = $category->cheapestProduct;
        self::assertNotNull($cheapestProduct);
        self::assertEquals(1, $cheapestProduct->id);

        $mostExpensiveProduct = $category->mostExpensiveProduct;
        self::assertNotNull($mostExpensiveProduct);
        self::assertEquals(4, $mostExpensiveProduct->id);
    }

    public function testOneToOnePolymorphic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, ImageSeeder::class]);
        $product = Product::query()->find('1');
        self::assertNotNull($product);

        $image = $product->image;
        self::assertNotNull($image);
        self::assertEquals("https://www.programmerzamannow.com/image/2.jpg", $image->url);
    }

    public function testOneToManyPolymorphic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, CommentSeeder::class]);
        $product = Product::query()->first();
        self::assertNotNull($product);

        $comments = $product->comments;
        self::assertNotNull($comments);
        self::assertCount(1, $comments);

        $comments->each(function ($item) {
            self::assertEquals('1', $item->commentable_id);
            self::assertEquals(Product::class, $item->commentable_type);
            Log::info(json_encode($item));
        });
    }

    public function testOneOfManyPolymorphicCondition()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, CommentSeeder::class]);
        $product = Product::query()->first();
        self::assertNotNull($product);

        $latestComment = $product->latestComment;
        self::assertNotNull($latestComment);

        $oldestComment = $product->oldestComment;
        self::assertNotNull($oldestComment);
    }

    public function testManyToManyPolymorphic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, TagSeeder::class]);
        $product = Product::query()->find('1');
        $tags = $product->tags;
        self::assertNotNull($tags);
        self::assertCount(1, $tags);

        $tags->each(function ($item) {
            self::assertNotNull($item);
            self::assertNotNull($item->id);
            self::assertNotNull($item->name);

            $voucher = $item->vouchers;
            self::assertNotNull($voucher);

            Log::info(json_encode($item));
        });
    }
}

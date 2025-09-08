<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;

use App\Models\Scopes\IsActiveScope;
use App\Models\Voucher;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PhpParser\Node\Stmt\Catch_;
use Illuminate\Support\Facades\Log;

class CategoryTest extends TestCase
{
    public function testInsert()
    {
        $category = new Category();
        $category->id = 'GADGET';
        $category->name = 'Gadget';
        $result = $category->save();
        self::assertTrue($result);
    }

    public function testInsertMany()
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                'id' => "ID $i",
                'name' => "Category $i"
            ];
        }

        $result = Category::query()->insert($categories);
        self::assertTrue($result);

        $total = Category::query()->count();
        self::assertEquals(10, $total);
    }

    public function testFind()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::query()->find('FOOD');

        self::assertNotNull($category);
        self::assertEquals('FOOD', $category->id);
        self::assertEquals('food', $category->name);
        self::assertEquals('Food Description', $category->description);
    }

    public function testUpdate()
    {
        $this->seed(CategorySeeder::class);

        $category = Category::query()->find('FOOD');
        $category->name = 'Food Update';
        $result = $category->update();

        self::assertTrue($result);
    }

    public function testSelect()
    {
        for ($i = 0; $i < 5; $i++) {
            $category = new Category();
            $category->id = "ID $i";
            $category->name = "Category $i";
            $category->save();
        }

        $category = Category::whereNull('description')->get();
        self::assertEquals(5, $category->count());

        $category->each(function ($item) {
            self::assertNull($item->description);


            $item->description = 'Update';
            $item->update();
        });
    }

    public function testUpdateMany()
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                'id' => "ID $i",
                'name' => "Category $i"
            ];
        }

        $result = Category::insert($categories);
        self::assertTrue($result);

        Category::whereNull('description')->update([
            'description' => 'Updated'
        ]);

        $total = Category::where('description', 'Updated')->count();
        self::assertEquals(10, $total);
    }

    public function testDelete()
    {
        $this->seed(CategorySeeder::class);

        $result = Category::find('FOOD')->delete();
        self::assertTrue($result);

        $category = Category::where('id', 'FOOD')->count();
        self::assertEquals(0, $category);
    }

    public function testDeleteMany()
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                'id' => "ID $i",
                'name' => "Category $i"
            ];
        }

        $result = Category::query()->insert($categories);
        self::assertTrue($result);

        Category::whereNull('description')->delete();

        self::assertEquals(0, Category::count());
    }

    public function testCreate()
    {
        $request = [
            'id' => 'category1',
            'name' => 'Category1',
            'description' => 'category description'
        ];

        $category = new Category($request);
        $category->save();

        self::assertNotNull($category->id);
    }

    public function testCreateMethod()
    {
        $request = [
            'id' => 'ID 10',
            'name' => 'Category 10',
            'description' => 'Category Description'
        ];

        $category = Category::query()->create($request);
        self::assertNotNull($category->id);
        self::assertNotNull($category->name);
        self::assertNotNull($category->description);
    }

    public function testUpdateMass()
    {
        $this->seed(CategorySeeder::class);

        $request = [
            'id' => 'id updated',
            'name' => 'name updated',
            'description' => 'description update'
        ];

        $category = Category::query()->find('FOOD');
        $category->fill($request);
        $category->save();

        self::assertNotNull($category->id);
    }

    public function testGlobalScopeNotFound()
    {
        Category::query()->create([
            'id' => 'sample',
            'name' => 'sample global scope'
        ]);

        $result = Category::query()->find('sample');
        self::assertNull($result);

        $result = Category::query()->withoutGlobalScopes([IsActiveScope::class])->find('sample');
        self::assertNotNull($result);
    }

    public function testGlobalScope()
    {
        Category::query()->create([
            'id' => 'sample2',
            'name' => 'sample global scope',
            'is_active' => true
        ]);


        $result = Category::query()->find('sample2');
        self::assertNotNull($result);

        // $result = Category::query()->withoutGlobalScopes([IsActiveScope::class])->find('sample');
        // self::assertNotNull($result);
    }

    public function testOneToMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
        $category = Category::query()->find('FOOD');
        self::assertNotNull($category);

        $products = $category->products;
        self::assertNotNull($products);
        self::assertCount(4, $products);
        self::assertEquals('product1', $products[0]->name);
        $products->each(function ($item) {
            Log::info(json_encode($item->id));
        });
    }

    public function testOneToManyQuery()
    {
        $category = new Category();
        $category->id = 'FOOD';
        $category->name = 'food';
        $category->description = 'Food Description';
        $category->is_active = true;
        $category->save();

        $product = new Product();
        $product->id = '1';
        $product->name = 'product1';
        $product->description = 'description product1';
        $product->price = 1_000_000;
        $product->stok = 100;

        $category->products()->save($product);

        self::assertNotNull($product->category_id);
    }
}

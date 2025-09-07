<?php

namespace Tests\Feature;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PhpParser\Node\Stmt\Catch_;

class EloquentTest extends TestCase
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
}

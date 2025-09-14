<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Log;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\WalletSeeder;
use Database\Seeders\ProductSeeder;
use App\Models\Customer;
use App\Models\Wallet;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ImageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    public function testOneToOne()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class]);
        $customer = Customer::query()->find('DONY');
        self::assertNotNull($customer);

        // query wallet menggunakan onetoone relationship
        $wallet = $customer->wallet;
        self::assertNotNull($wallet);

        self::assertEquals(1_000_000, $wallet->amount);
    }

    public function testOneToOneQuery()
    {
        $customer = new Customer();
        $customer->id = 'DONY';
        $customer->name = 'Dony Yuli Handoko';
        $customer->email = 'donyyulihandoko@gmail.com';
        $customer->save();

        $wallet = new Wallet();
        $wallet->amount = 1_000_000;
        $customer->wallet()->save($wallet);

        self::assertNotNull($wallet->customer_id);
        $wallet->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testManyToMany()
    {
        $this->seed([CustomerSeeder::class, CategorySeeder::class, ProductSeeder::class]);
        $customer = Customer::find('DONY');
        self::assertNotNull($customer);

        $customer->likeProducts()->attach('1');

        $products = $customer->likeProducts;

        self::assertNotNull($products);
        self::assertEquals(1, $products[0]->id);

        $products->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testRemoveManyToMany()
    {
        $this->testManyToMany();
        $customer = Customer::find('DONY');
        self::assertNotNull($customer);

        $customer->likeProducts()->detach('1');

        $products = $customer->likeProducts;
        self::assertNotNull($products);
        self::assertCount(0, $products);
    }

    public function testPivotAttribute()
    {
        $this->testManyToMany();
        $customer = Customer::query()->find('DONY');
        self::assertNotNull($customer);

        $products = $customer->likeProducts();

        $products->each(function ($item) {
            $pivot =  $item->pivot;
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);
        });
    }

    public function testPivotAttributeWithCondition()
    {
        $this->testManyToMany();
        $customer = Customer::query()->find('DONY');
        self::assertNotNull($customer);

        $products = $customer->likeProductsLastWeek();

        $products->each(function ($item) {
            $pivot =  $item->pivot;
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);
        });
    }

    public function testPivotModel()
    {
        $this->testManyToMany();
        $customer = Customer::query()->find('DONY');
        self::assertNotNull($customer);

        $products = $customer->likeProductsLastWeek();

        $products->each(function ($item) {
            $pivot =  $item->pivot;
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);

            self::assertNotNull($pivot->customer);
            self::assertNotNull($pivot->product);
        });
    }

    public function testOneToOnePolymorphic()
    {
        $this->seed([CustomerSeeder::class, ImageSeeder::class]);
        $customer = Customer::query()->find('DONY');
        self::assertNotNull($customer);

        $image = $customer->image;
        self::assertNotNull($image);
        self::assertEquals("https://www.programmerzamannow.com/image/1.jpg", $image->url);
    }

    public function testEager()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class, ImageSeeder::class]);
        $customer = Customer::query()->with(['wallet', 'image'])->find('DONY');
        self::assertNotNull($customer);

        $customer->each(function ($item) {
            Log::info(json_encode($item));
            Log::info(json_encode($item->wallet->amount));
            Log::info(json_encode($item->image->id));
        });
    }

    public function testEagerModel()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class, ImageSeeder::class]);
        $customer = Customer::query()->find('DONY');
        self::assertNotNull($customer);

        $customer->each(function ($item) {
            Log::info(json_encode($item));
            Log::info(json_encode($item->wallet->amount));
            Log::info(json_encode($item->image->id));
        });
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Log;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\WalletSeeder;
use App\Models\Customer;
use App\Models\Wallet;
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
}

<?php

namespace Tests\Feature;

use App\Models\Customer;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\VirtualAccountSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VirtualAccountTest extends TestCase
{
    public function testHasOneTrough()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class, VirtualAccountSeeder::class]);

        $customer = Customer::query()->find('DONY');
        self::assertNotNull($customer);

        $virtualAccount = $customer->virtualAccount;
        self::assertEquals('BCA', $virtualAccount->bank);
    }
}

<?php

namespace Database\Seeders;

use App\Models\VirtualAccount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Wallet;

class VirtualAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wallet = Wallet::query()->where('customer_id', 'DONY')->firstOrFail();

        $virtualAccount = new VirtualAccount();
        $virtualAccount->bank = 'BCA';
        $virtualAccount->va_number = '12345';
        $virtualAccount->wallet_id = $wallet->id;
        $virtualAccount->save();
    }
}

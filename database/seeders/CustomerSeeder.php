<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = new Customer();
        $customer->id = 'DONY';
        $customer->name = 'Dony Yuli Handoko';
        $customer->email = 'donyyulihandoko@gmail.com';
        $customer->save();
    }
}

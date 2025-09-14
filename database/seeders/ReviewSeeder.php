<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $review = new Review();
        $review->product_id = '1';
        $review->rating = 5;
        $review->customer_id = 'DONY';
        $review->comment = 'Bagus Banget';
        $review->save();

        $review = new Review();
        $review->product_id = '2';
        $review->rating = 4;
        $review->customer_id = 'DONY';
        $review->comment = 'Bagus';
        $review->save();
    }
}

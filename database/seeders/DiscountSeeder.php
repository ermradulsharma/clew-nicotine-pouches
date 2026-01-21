<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Discount::create([
            'base_discount' => 20.00,
            'incremental_discount' => 5.00,
            'max_discount' => 30.00,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class ProductReviewsSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get(database_path('data/product_reviews.json'));
        $data = json_decode($json, true);

        if (empty($data)) {
            return;
        }

        Schema::disableForeignKeyConstraints();
        DB::table('product_reviews')->delete();

        foreach (array_chunk($data, 500) as $chunk) {
            DB::table('product_reviews')->insert($chunk);
        }
        
        Schema::enableForeignKeyConstraints();
    }
}

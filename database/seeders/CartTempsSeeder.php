<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class CartTempsSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get(database_path('data/cart_temps.json'));
        $data = json_decode($json, true);

        if (empty($data)) {
            return;
        }

        Schema::disableForeignKeyConstraints();
        DB::table('cart_temps')->delete();

        foreach (array_chunk($data, 500) as $chunk) {
            DB::table('cart_temps')->insert($chunk);
        }
        
        Schema::enableForeignKeyConstraints();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class WpOptionsSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get(database_path('data/wp_options.json'));
        $data = json_decode($json, true);

        if (empty($data)) {
            return;
        }

        Schema::disableForeignKeyConstraints();
        DB::table('wp_options')->delete();

        foreach (array_chunk($data, 500) as $chunk) {
            DB::table('wp_options')->insert($chunk);
        }
        
        Schema::enableForeignKeyConstraints();
    }
}

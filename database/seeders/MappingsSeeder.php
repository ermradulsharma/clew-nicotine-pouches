<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class MappingsSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get(database_path('data/mappings.json'));
        $data = json_decode($json, true);

        if (empty($data)) {
            return;
        }

        Schema::disableForeignKeyConstraints();
        DB::table('mappings')->delete();

        foreach (array_chunk($data, 500) as $chunk) {
            DB::table('mappings')->insert($chunk);
        }
        
        Schema::enableForeignKeyConstraints();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class AdminsSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get(database_path('data/admins.json'));
        $data = json_decode($json, true);

        if (empty($data)) {
            return;
        }

        Schema::disableForeignKeyConstraints();
        DB::table('admins')->delete();

        foreach (array_chunk($data, 500) as $chunk) {
            DB::table('admins')->insert($chunk);
        }
        
        Schema::enableForeignKeyConstraints();
    }
}

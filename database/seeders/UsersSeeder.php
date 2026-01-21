<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get(database_path('data/users.json'));
        $data = json_decode($json, true);

        if (empty($data)) {
            return;
        }

        Schema::disableForeignKeyConstraints();
        DB::table('users')->delete();

        foreach (array_chunk($data, 500) as $chunk) {
            DB::table('users')->insert($chunk);
        }
        
        Schema::enableForeignKeyConstraints();
    }
}

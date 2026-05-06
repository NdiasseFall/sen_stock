<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['nom' => 'Informatique'],
            ['nom' => 'Bureau'],
            ['nom' => 'Accessoires'],
            ['nom' => 'Téléphonie'],
            ['nom' => 'Électroménager'],
        ]);
    }
}

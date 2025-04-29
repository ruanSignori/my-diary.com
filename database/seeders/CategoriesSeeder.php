<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        ['name' => 'Linux', 'is_default' => true ,'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Git', 'is_default' => true , 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Redes', 'is_default' => true , 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Programação', 'is_default' => true , 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Banco de Dados', 'is_default' => true , 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'DevOps', 'is_default' => true , 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Segurança', 'is_default' => true , 'created_at' => now(), 'updated_at' => now()],
    ]);
    }
}

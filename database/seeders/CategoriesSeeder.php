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
        ['name' => 'Linux', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Git', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Redes', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Programação', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Banco de Dados', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'DevOps', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Segurança', 'created_at' => now(), 'updated_at' => now()],
    ]);
    }
}

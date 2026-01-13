<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            ['title' => 'Laravel untuk Pemula', 'author' => 'A. Dev', 'stock' => 3],
            ['title' => 'PHP Dasar', 'author' => 'B. Programmer', 'stock' => 5],
            ['title' => 'Desain Database', 'author' => 'C. Architect', 'stock' => 2],
        ];

        foreach ($books as $b) {
            DB::table('books')->insert(array_merge($b, ['created_at' => now(), 'updated_at' => now()]));
        }
    }
}

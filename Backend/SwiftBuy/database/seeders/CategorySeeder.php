<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'Electronics',
                'description' => 'All kinds of electronic items',
                'status' => '1', 
                'cover_image' => 'electronics.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Books',
                'description' => 'A variety of books and literature',
                'status' => '1',
                'cover_image' => 'books.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Clothing',
                'description' => 'Apparel and clothing items',
                'status' => '1',
                'cover_image' => 'clothing.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

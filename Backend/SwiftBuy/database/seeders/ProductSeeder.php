<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'title' => ' Ray-Ban',
                'description' => 'Latest model Ray-Ban with advanced features',
                'stock' => '50',
                'price' => '100',
                'rating' => '5',
                'status' => '1',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'image' => 'prod1.jpg',
                'promotion'=> '10',
                'final_price'=>'90'

            ],
            [
                'title' => 'Gucci',
                'description' => 'Latest model Gucci with advanced features',
                'stock' => '50',
                'price' => '200',
                'rating' => '5',
                'status' => '1',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'image' => 'prod2.jpg',
                'promotion'=> '20',
                'final_price'=>'180'

            ],
            [
                'title' => 'Prada',
                'description' => 'A best-selling Prada ',
                'stock' => '50',
                'price' => '200',
                'rating' => '5',
                'status' => '0',
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'image' => 'prod3.jpg',
                'promotion'=> '20',
                'final_price'=>'180'

            ],
            [
                'title' => 'Versace',
                'description' => 'A best-selling Versace is Store',
                'stock' => '50',
                'price' => '200',
                'rating' => '5',
                'status' => '0',
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'image' => 'prod4.jpg',
                'promotion'=> '20',
                'final_price'=>'180'

            ],
            [
                'title' => 'Oakley',
                'description' => 'Comfortable Oakley available in various sizes',
                'stock' => '50',
                'price' => '200',
                'rating' => '5',
                'status' => '1',
                'category_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'image' => 'prod1.jpg',
                'promotion'=> '20',
                'final_price'=>'180'

            ],
            [
                'title' => ' Dolce & Gabbana',
                'description' => 'Comfortable  Dolce & Gabbana suitavailable in various sizes',
                'stock' => '50',
                'price' => '200',
                'rating' => '5',
                'status' => '1',
                'category_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'image' => 'prod3.jpg',
                'promotion'=> '20',
                'final_price'=>'180'
            ],
        ]);
    }
}

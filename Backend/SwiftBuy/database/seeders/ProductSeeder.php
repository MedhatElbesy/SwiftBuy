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
                'title' => 'Smartphone',
                'description' => 'Latest model smartphone with advanced features',
                'stock' => '50',
                'price' => '100',
                'rating' => '5',
                'status' => 'accepted',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'image' => 'Smartphone.jpg',
                'promotion'=> '10',
                'final_price'=>'90'

            ],
            [
                'title' => 'TVs',
                'description' => 'Latest model TVs with advanced features',
                'stock' => '50',
                'price' => '200',
                'rating' => '5',
                'status' => 'accepted',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'image' => 'Smartphone.jpg',
                'promotion'=> '20',
                'final_price'=>'180'

            ],
            [
                'title' => 'Novel',
                'description' => 'A best-selling novel by a renowned author',
                'stock' => '50',
                'price' => '200',
                'rating' => '5',
                'status' => 'accepted',
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'image' => 'Novel.jpg',
                'promotion'=> '20',
                'final_price'=>'180'

            ],
            [
                'title' => 'Magazine',
                'description' => 'A best-selling Magazine by a renowned author',
                'stock' => '50',
                'price' => '200',
                'rating' => '5',
                'status' => 'rejected',
                'category_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'image' => 'Magazine.jpg',
                'promotion'=> '20',
                'final_price'=>'180'

            ],
            [
                'title' => 'T-shirt',
                'description' => 'Comfortable cotton t-shirt available in various sizes',
                'stock' => '50',
                'price' => '200',
                'rating' => '5',
                'status' => 'accepted',
                'category_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'image' => 'T-shirt.jpg',
                'promotion'=> '20',
                'final_price'=>'180'

            ],
            [
                'title' => 'suit',
                'description' => 'Comfortable cotton suitavailable in various sizes',
                'stock' => '50',
                'price' => '200',
                'rating' => '5',
                'status' => 'pending',
                'category_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'image' => 'suit.jpg',
                'promotion'=> '20',
                'final_price'=>'180'
            ],
        ]);
    }
}

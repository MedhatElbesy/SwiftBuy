<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;



class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('carts')->insert([
            [
                'user_id' => 1,
                'product_id' => 1,
                'price' => '50.00',
                'quantity' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}


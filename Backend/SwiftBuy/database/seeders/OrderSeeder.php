<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert([
            [
                'user_id' => 1,
                'date' => now(),
                'total_price' => '1000.00',
                'status' => 'accepted',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'date' => now(),
                'total_price' => '2000.00',
                'status' => 'rejected',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'date' => now(),
                'total_price' => '3000.00',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],


        ]);
    }
}

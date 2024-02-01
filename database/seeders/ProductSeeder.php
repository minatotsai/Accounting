<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert(
        [
            [
                'p_name'=>'小雞腿',
                'p_price'=>'30',
                'p_type'=>0,
                'status'=>1,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()

            ],
            [
                'p_name'=>'大雞腿',
                'p_price'=>'60',
                'p_type'=>0,
                'status'=>1,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'p_name'=>'雞',
                'p_price'=>'100',
                'p_type'=>1,
                'status'=>1,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ],
            [
                'p_name'=>'雞翅',
                'p_price'=>'80',
                'p_type'=>1,
                'status'=>1,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ]

        ]);
        
    }
}

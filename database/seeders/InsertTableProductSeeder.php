<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class InsertTableProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       //$faker = Faker\Factory::create();
    	//php artisan db:seed --class=InsertTableProductSeeder
        $limit = 30;

        for ($i = 0; $i < $limit; $i++) {
            DB::table('tbl_product')->insert([
                'product_name' => Str::random(10),
                'category_id' => 1,
                'category_details_id' => 0,
                'brand_id'=>rand(1,3),
                'product_content'=>Str::random(10),
                'product_desc'=>Str::random(10),
                'product_price'=>rand(1000000,30000000),
                'product_image'=>'dt.PNG',
                'product_status'=>rand(1,3),
            ]);
        }
    }
}

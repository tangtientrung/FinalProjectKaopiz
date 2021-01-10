<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        //$this->call(InsertTableProductSeeder::class);
        //$this->call(a::class);
        $limit = 30;

        for ($i = 0; $i < $limit; $i++) {
            DB::table('product')->insert([
                // 'product_name' => Str::random(10),
                // 'category_id' => 3,
                // 'sub_category_id' => rand(1,3),
                // 'brand_id'=>rand(1,3),
                // 'product_content'=>Str::random(10),
                // 'slug_product'=>Str::random(10),
                // 'product_desc'=>Str::random(10),
                // 'product_price'=>rand(1000000,30000000),
                // 'product_image'=>'pk.PNG',
                // 'product_status'=>rand(1,3),


                // 'product_name' => Str::random(10),
                // 'category_id' => 1,
                // 'sub_category_id' => 0,
                // 'brand_id'=>rand(1,3),
                // 'product_content'=>Str::random(10),
                // 'slug_product'=>Str::random(10),
                // 'product_desc'=>Str::random(10),
                // 'product_price'=>rand(1000000,30000000),
                // 'product_image'=>'dt.PNG',
                // 'product_status'=>rand(1,3),

                'product_name' => Str::random(10),
                'category_id' => 3,
                'sub_category_id' => rand(1,3),
                'brand_id'=>rand(1,3),
                'product_content'=>Str::random(10),
                'product_desc'=>Str::random(10),
                'slug_product'=>Str::random(10),
                'product_price'=>rand(1000000,30000000),
                'product_image'=>'dt.PNG',
                'product_status'=>rand(1,3),
            ]);
        }
    }
}

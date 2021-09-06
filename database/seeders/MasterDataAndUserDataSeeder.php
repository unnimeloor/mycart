<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class MasterDataAndUserDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            ['brand_name' => 'HP'],
            ['brand_name' => 'Lenovo'],
            ['brand_name' => 'DELL'],
            ['brand_name' => 'ASUS'],
            ['brand_name' => 'Apple'],
        ];
        $processors = [
            ['processor_type' => 'Core i3'],
            ['processor_type' => 'Core i5'],
            ['processor_type' => 'Core i7'],
            ['processor_type' => 'Core i9'],
            ['processor_type' => 'Athlon'],
            ['processor_type' => 'Ryzen'],
        ];
        DB::table('brand')->insert($brands);
        DB::table('processor_type')->insert($processors);
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        DB::table('product')->insert([
            'name' => 'Lenovo Ideapad 3',
            'price' => 9000,
            'id_brand' => 2,
            'id_processor_type' => 1,
            'screen_size' => 12,
            'is_touch_screen' => 1,
            'out_of_stock' => 0,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StadiumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [['Ahmad Bin Ali','Al Rayyan'],['Al Bayt','Al Khor'],['Al Janoub','Al Wakrah'],
            ['Al Thumama','Doha'],['Education City','Doha'],['Khalifa International','Al Waab'],
            ['Lusail Iconic','Lusail'],['Stadium 974','Doha']];

        for ($i=0; $i < 8 ; $i++) {

            \App\Models\Stadiums::create([
                'name' => $data[$i][0],
                'place' => $data[$i][1],
                'url_image' => 'images\\'
            ]);
        }
        //
    }
}

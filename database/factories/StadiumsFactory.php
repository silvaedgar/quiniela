<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StadiumsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $indice = $this->faker->unique()->randomElement([0,1,2,3,4,5,6,7]);
        $data = [['Ahmad Bin Ali','Al Rayyan'],['Al Bayt','Al Khor'],['Al Janoub','Al Wakrah'],
            ['Al Thumama','Doha'],['Education City','Doha'],['Khalifa International','Al Waab'],
            ['Lusail Iconic','Lusail'],['Stadium 974','Doha']];

        return [
            'name' => $data[$indice][0],
            'place' => $data[$indice][1],
            'url_image' => 'images\\'
        ];

    }
}

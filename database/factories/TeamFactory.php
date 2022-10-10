<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $indice = $this->faker->unique()->randomElement([0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31]);

        $data = [['Alemania','E'],['Arabia Saudi','C'],['Argentina','C'],['Australia','D'],['Belgica','F'],
            ['Brasil','G'],['Camerun','G'],['Canada','F'],['Corea del Sur','H'],['Costa Rica','E'],
            ['Croacia','F'],['Dinamarca','D'],['Ecuador','A'],['España','E'],['Estados Unidos','B'],
            ['Francia','D'],['Gales','B'],['Ghana','H'],['Inglaterra','B'],['Iran','B'],['Japon','E'],
            ['Marruecos','F'],['Mexico','C'],['Holanda','A'],['Polonia','C'],['Portugal','H'],['Qatar','A'],
            ['Senegal','A'],['Serbia','G'],['Suiza','G'],['Tunez','D'],['Uruguay','H']];

        return [
            'name' => $data[$indice][0],
            'group' => $data[$indice][1],
            'url_flag' => "images\\".$data[$indice][0].".jpeg",
        ];
    }
}

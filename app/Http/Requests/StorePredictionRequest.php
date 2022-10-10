<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePredictionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'goals_team_a.*' => ['required','gt:-1'],
            'goals_team_b.*' => ['required','gt: -1'],
        ];
    }

    public function messages() {

        return [
            'goals_team_a.*.required' => 'Ingrese los Goles',
            'goals_team_a.*.gt' => 'Pronostico de Gol Invalido',
            'goals_team_b.*.required' => 'Ingrese los Goles',
            'goals_team_b.*.gt' => 'Pronostico de Gol Invalido',
        ];
    }
}

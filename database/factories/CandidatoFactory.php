<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Candidato;

class CandidatoFactory extends Factory
{
    protected $model = Candidato::class;

    public function definition(): array
    {
        return [
            'nome' => fake()->name(),

            'email' => fake()->unique()->safeEmail(),

            'telefone' => fake()->numerify('869########'),

            'cpf' => fake()->unique()->numerify('###########'),
        ];
    }
}

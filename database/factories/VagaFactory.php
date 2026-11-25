<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Vaga;

class VagaFactory extends Factory
{
    protected $model = Vaga::class;

    public function definition(): array
    {
        return [
            'titulo' => fake()->randomElement([
                'Desenvolvedor Back-end',
                'Desenvolvedor Front-end',
                'Analista de Sistemas',
                'Desenvolvedor Full Stack',
                'Designer UI/UX',
                'Analista de Dados',
                'Engenheiro de Software',
                'Suporte Técnico',
            ]),

            'descricao' => fake()->paragraph(),

            'tipo_contrato' => fake()->randomElement([
                'CLT',
                'PJ',
                'Freelancer',
            ]),

            'salario' => fake()->numberBetween(1500, 12000),

            'ativa' => true,
        ];
    }

    public function pausada(): static
    {
        return $this->state(fn () => [
            'ativa' => false,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Vaga;
use App\Models\Candidato;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $vagasAtivas = Vaga::factory()
            ->count(25)
            ->create();

        Vaga::factory()
            ->count(5)
            ->pausada()
            ->create();

        $candidatos = Candidato::factory()
            ->count(25)
            ->create();

        foreach ($candidatos as $candidato) {
            $vagas = $vagasAtivas->random(2);

            $candidato->vagas()->attach(
                $vagas->pluck('id')->all()
            );
        }
    }
}

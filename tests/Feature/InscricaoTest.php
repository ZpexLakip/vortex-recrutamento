<?php

namespace Tests\Feature;

use App\Models\Vaga;
use App\Models\Candidato;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InscricaoTest extends TestCase
{
    use RefreshDatabase;

    public function test_inscrever_candidato_em_vaga(): void
    {
        $candidato = Candidato::factory()->create();
        $vaga = Vaga::factory()->create();

        $this->post(route('inscricoes.store', $candidato), [
            'vaga_id' => $vaga->id,
        ])->assertRedirect(
            route('inscricoes.index', $candidato)
        );

        $this->assertDatabaseHas('inscricoes', [
            'candidato_id' => $candidato->id,
            'vaga_id' => $vaga->id,
        ]);
    }

    public function test_candidato_pode_se_inscrever_em_varias_vagas(): void
    {
        $candidato = Candidato::factory()->create();
        $vagas = Vaga::factory()->count(2)->create();

        foreach ($vagas as $vaga) {
            $this->post(route('inscricoes.store', $candidato), [
                'vaga_id' => $vaga->id,
            ])->assertRedirect(
                route('inscricoes.index', $candidato)
            );
        }

        $this->assertCount(2, $candidato->vagas()->get());
    }

    public function test_impedir_inscricao_em_vaga_pausada(): void
    {
        $candidato = Candidato::factory()->create();
        $vaga = Vaga::factory()->pausada()->create();

        $this->post(route('inscricoes.store', $candidato), [
            'vaga_id' => $vaga->id,
        ])->assertSessionHasErrors('vaga_id');

        $this->assertDatabaseCount('inscricoes', 0);
    }

    public function test_impedir_inscricao_duplicada(): void
    {
        $candidato = Candidato::factory()->create();
        $vaga = Vaga::factory()->create();

        $candidato->vagas()->attach($vaga->id);

        $this->post(route('inscricoes.store', $candidato), [
            'vaga_id' => $vaga->id,
        ])->assertSessionHasErrors('vaga_id');

        $this->assertDatabaseCount('inscricoes', 1);
    }

    public function test_cancelar_inscricao(): void
    {
        $candidato = Candidato::factory()->create();
        $vaga = Vaga::factory()->create();

        $candidato->vagas()->attach($vaga->id);

        $this->delete(route('inscricoes.destroy', [
            $candidato,
            $vaga,
        ]))->assertRedirect(
            route('inscricoes.index', $candidato)
        );

        $this->assertDatabaseCount('inscricoes', 0);
    }

    public function test_excluir_vaga_remove_inscricoes(): void
    {
        $candidato = Candidato::factory()->create();
        $vaga = Vaga::factory()->create();

        $candidato->vagas()->attach($vaga->id);

        $this->delete(route('vagas.destroy', $vaga))
            ->assertRedirect(route('vagas.index'));

        $this->assertDatabaseCount('inscricoes', 0);
    }
}

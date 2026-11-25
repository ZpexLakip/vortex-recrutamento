<?php

namespace Tests\Feature;

use App\Models\Vaga;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VagaCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_listar_vagas(): void
    {
        $vaga = Vaga::factory()->create();

        $this->get(route('vagas.index'))
            ->assertOk()
            ->assertSee($vaga->titulo);
    }

    public function test_criar_vaga(): void
    {
        $dados = Vaga::factory()->raw();

        $this->post(route('vagas.store'), $dados)
            ->assertRedirect(route('vagas.index'));

        $this->assertDatabaseHas('vagas', [
            'titulo' => $dados['titulo'],
        ]);
    }

    public function test_validar_campos_obrigatorios(): void
    {
        $this->post(route('vagas.store'), [])
            ->assertSessionHasErrors([
                'titulo',
                'descricao',
                'tipo_contrato',
                'ativa',
            ]);

        $this->assertDatabaseCount('vagas', 0);
    }

    public function test_editar_vaga(): void
    {
        $vaga = Vaga::factory()->create();

        $dados = Vaga::factory()->raw([
            'titulo' => 'Desenvolvedor PHP',
        ]);

        $this->put(route('vagas.update', $vaga), $dados)
            ->assertRedirect(route('vagas.index'));

        $this->assertDatabaseHas('vagas', [
            'id' => $vaga->id,
            'titulo' => 'Desenvolvedor PHP',
        ]);
    }

    public function test_excluir_vaga(): void
    {
        $vaga = Vaga::factory()->create();

        $this->delete(route('vagas.destroy', $vaga))
            ->assertRedirect(route('vagas.index'));

        $this->assertDatabaseMissing('vagas', [
            'id' => $vaga->id,
        ]);
    }

    public function test_pausar_e_reativar_vaga(): void
    {
        $vaga = Vaga::factory()->create();

        $this->patch(route('vagas.toggle', $vaga))
            ->assertRedirect(route('vagas.index'));

        $this->assertFalse($vaga->fresh()->ativa);

        $this->patch(route('vagas.toggle', $vaga))
            ->assertRedirect(route('vagas.index'));

        $this->assertTrue($vaga->fresh()->ativa);
    }

    public function test_filtrar_vagas(): void
    {
        Vaga::factory()->create([
            'titulo' => 'Programador PHP',
        ]);

        Vaga::factory()->create([
            'titulo' => 'Designer Grafico',
        ]);

        $this->get(route('vagas.index', [
            'titulo' => 'Programador',
        ]))
            ->assertOk()
            ->assertSee('Programador PHP')
            ->assertDontSee('Designer Grafico');
    }

    public function test_paginar_vagas(): void
    {
        Vaga::factory()->count(25)->create();

        $this->get(route('vagas.index'))
            ->assertOk()
            ->assertViewHas('vagas', function ($vagas) {
                return $vagas->count() === 20
                    && $vagas->total() === 25;
            });
    }
}

<?php

namespace Tests\Feature;

use App\Models\Candidato;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CandidatoCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_listar_candidatos(): void
    {
        $candidato = Candidato::factory()->create();

        $this->get(route('candidatos.index'))
            ->assertOk()
            ->assertSee($candidato->nome);
    }

    public function test_criar_candidato(): void
    {
        $dados = Candidato::factory()->raw();

        $this->post(route('candidatos.store'), $dados)
            ->assertRedirect(route('candidatos.index'));

        $this->assertDatabaseHas('candidatos', [
            'email' => $dados['email'],
        ]);
    }

    public function test_validar_campos_obrigatorios(): void
    {
        $this->post(route('candidatos.store'), [])
            ->assertSessionHasErrors([
                'nome',
                'email',
                'telefone',
                'cpf',
            ]);
    }

    public function test_impedir_cadastro_duplicado(): void
    {
        $candidato = Candidato::factory()->create();

        $dados = Candidato::factory()->raw([
            'email' => $candidato->email,
            'cpf' => $candidato->cpf,
        ]);

        $this->post(route('candidatos.store'), $dados)
            ->assertSessionHasErrors(['email', 'cpf']);

        $this->assertDatabaseCount('candidatos', 1);
    }

    public function test_editar_candidato(): void
    {
        $candidato = Candidato::factory()->create();

        $dados = [
            'nome' => 'Nome Atualizado',
            'email' => $candidato->email,
            'telefone' => $candidato->telefone,
            'cpf' => $candidato->cpf,
        ];

        $this->put(route('candidatos.update', $candidato), $dados)
            ->assertRedirect(route('candidatos.index'));

        $this->assertDatabaseHas('candidatos', [
            'id' => $candidato->id,
            'nome' => 'Nome Atualizado',
        ]);
    }

    public function test_excluir_candidato(): void
    {
        $candidato = Candidato::factory()->create();

        $this->delete(route('candidatos.destroy', $candidato))
            ->assertRedirect(route('candidatos.index'));

        $this->assertDatabaseMissing('candidatos', [
            'id' => $candidato->id,
        ]);
    }

    public function test_filtrar_candidatos(): void
    {
        Candidato::factory()->create([
            'nome' => 'Joao Teste',
        ]);

        Candidato::factory()->create([
            'nome' => 'Maria Teste',
        ]);

        $this->get(route('candidatos.index', [
            'nome' => 'Joao',
        ]))
            ->assertOk()
            ->assertSee('Joao Teste')
            ->assertDontSee('Maria Teste');
    }

    public function test_paginar_candidatos(): void
    {
        Candidato::factory()->count(25)->create();

        $this->get(route('candidatos.index'))
            ->assertOk()
            ->assertViewHas('candidatos', function ($candidatos) {
                return $candidatos->count() === 20
                    && $candidatos->total() === 25;
            });
    }
}

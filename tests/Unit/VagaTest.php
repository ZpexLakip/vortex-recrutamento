<?php

namespace Tests\Unit;

use App\Models\Vaga;
use PHPUnit\Framework\TestCase;

class VagaTest extends TestCase
{
    public function test_vaga_ativa_aceita_inscricoes(): void
    {
        $vaga = new Vaga(['ativa' => true]);

        $this->assertTrue($vaga->aceitaInscricoes());
    }

    public function test_vaga_pausada_nao_aceita_inscricoes(): void
    {
        $vaga = new Vaga(['ativa' => false]);

        $this->assertFalse($vaga->aceitaInscricoes());
    }
}

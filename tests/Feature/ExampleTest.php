<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_pagina_inicial_redireciona_para_vagas(): void
    {
        $this->get('/')
            ->assertRedirect('/vagas');
    }
}
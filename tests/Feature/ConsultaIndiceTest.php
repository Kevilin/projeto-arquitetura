<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConsultaIndiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testConsultaInvalidaDeIndice(): void
    {
        $response = $this->get('/api/getIndiceMeses/XYZ?meses=6');
        $response->assertStatus(500);
        $response->assertJsonCount(1);
        $response->assertJson(['Erro:' => 'Indice incorreto']);
    }
}

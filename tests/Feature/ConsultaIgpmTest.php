<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConsultaIgpmTest extends TestCase
{
    
    public function testConsultaValidaDeIgpm()
    {
        $response = $this->get('/api/getIndiceMeses/igpm?meses=6');
        $response->assertStatus(200);
        $response->assertJsonCount(6, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'data',
                    'valor',
                ],
            ],
        ]);
    }

    public function testConsultaDeIgpmComMesesNegativo()
    {
        $response = $this->get('/api/getIndiceMeses/igpm?meses=-1');
        $response->assertStatus(500);
        $response->assertJsonCount(1);
        $response->assertJson(['Erro:' => 'O campo Meses deve ser um número positivo.']);
    }
}

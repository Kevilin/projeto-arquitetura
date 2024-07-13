<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CalculoAjusteDePrecoIgpmTest extends TestCase
{

    public function testCalculoDeAjusteDePrecoIgpm()
    {
        $response = $this->get('/api/ajusteDePrecoPeriodo/igpm/200/?de=30/01/2022&ate=30/01/2023');
        $response->assertStatus(200);
        $response->assertJson([
            'data' => '200,86',
        ]);
    }

    public function testCalculoDeAjusteDePrecoIgpmComDataInicialMaiorQueDataFinal()
    {
        $response = $this->get('/api/ajusteDePrecoPeriodo/igpm/250/?de=30/01/2023&ate=30/01/2022');
        $response->assertStatus(500);
        $response->assertJsonCount(1);
        $response->assertJson(['Erro:' => 'A data "de" não pode ser maior do que a data "ate".']);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CalculoAjusteDePrecoIpcaTest extends TestCase
{

    public function testCalculoDeAjusteDePrecoIpca()
    {
        $response = $this->get('/api/ajusteDePrecoPeriodo/ipca/150/?de=15/02/2022&ate=15/02/2023');
        $response->assertStatus(200);
        $response->assertJson([
            'data' => '150,75',
        ]);
    }
}

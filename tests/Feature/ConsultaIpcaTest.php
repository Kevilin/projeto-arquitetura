<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConsultaIpcaTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testConsultaValidaDeIpca()
    {
        $response = $this->get('/api/getIndiceMeses/ipca?meses=3');
        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'data',
                    'valor',
                ],
            ],
        ]);
    }
}

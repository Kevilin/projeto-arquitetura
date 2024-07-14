<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Http;

class DataController extends Controller
{
    public function addProduct(Request $request)
    {
        try {
            $name = $request->input("name");
            $code = $request->input("code");
            $unit = $request->input("unit");

            $productData = [
                'name' => $name, // Nome do produto
                'code' => $code,
                'unit' => $unit
            ];

            $company_domain = 'seu_domain_aqui'; // Substitua pelo domínio da sua empresa no Pipedrive
            $api_token = env('PIPEDRIVE_API_TOKEN');
            $url = 'https://' . $company_domain . '.pipedrive.com/api/v1/products?api_token=' . $api_token;

            $response = Http::post($url, $productData);

            $data = $response->json();

            Product::create([
                'idPipedrive' => $data['data']['id'],
                'name' => $data['data']['name'],
                'code' => $data['data']['code'],
                'unit' => $data['data']['unit']
            ]);

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao adicionar produto',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function getProduct($id)
    {
        try {
            $company_domain = 'seu_domain_aqui'; // Substitua pelo domínio da sua empresa no Pipedrive
            $api_token = env('PIPEDRIVE_API_TOKEN');
            $url = 'https://' . $company_domain . '.pipedrive.com/api/v1/products/' . $id . '?api_token=' . $api_token;

            // Envio da requisição GET utilizando o HTTP Client do Laravel
            $response = Http::get($url);

            // Recebendo e retornando a resposta da API do Pipedrive
            $data = $response->json();

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao buscar produto',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}

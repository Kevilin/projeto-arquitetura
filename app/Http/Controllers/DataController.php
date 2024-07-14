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
            $category = $request->input("category");

            $productData = [
                'name' => $name,
                'code' => $code,
                'unit' => $unit
            ];

            $company_domain = 'ska';
            $api_token = env('PIPEDRIVE_API_TOKEN');
            $url = 'https://' . $company_domain . '.pipedrive.com/api/v1/products?api_token=' . $api_token;

            $response = Http::post($url, $productData);

            // Recebendo e retornando a resposta da API do Pipedrive
            $data = $response->json();

            // Criando produto no banco de dados
            Product::create([
                'idPipedrive' => $data['data']['id'],
                'name' => $data['data']['name'],
                'code' => $data['data']['code'],
                'unit' => $data['data']['unit'],
                'category' => $category,
            ]);

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao adicionar produto',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function getProductById($id)
    {
        try {
            $company_domain = 'ska';
            $api_token = env('PIPEDRIVE_API_TOKEN');
            $url = 'https://' . $company_domain . '.pipedrive.com/api/v1/products/' . $id . '?api_token=' . $api_token;

            // Envio da requisição GET utilizando o HTTP Client do Laravel
            $response = Http::get($url);

            // Recebendo e retornando a resposta da API do Pipedrive
            $data = $response->json();

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao buscar produto por id',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function getProductByCategory($category)
    {
        try {
            $productsByCategory = Product::where('category', $category)->get();
            $data = $productsByCategory->toarray();

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao buscar produtos por categoria',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function getAllProducts()
    {
        try {
            $products = Product::get();
            $data = $products->toarray();

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao buscar produtos',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\AjusteDePrecoModel;
use App\Models\IndiceModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AjusteDePrecoController extends Controller
{

    private $model;
    private $indiceModel;

    public function __construct()
    {
        $this->model = new AjusteDePrecoModel();
        $this->indiceModel = new IndiceModel();
    }

    public function ajusteDePrecoPeriodo(Request $request)
    {
        $request->merge([
            'indice' => $request->route('indice'),
            'preco'  => $request->route('preco'),
            'de'     => $request->get('de'),
            'ate'    => $request->get('ate')
        ]);

        $request->validate([
            'indice' => ['required'],
            'preco'  => ['required'],
            'de'     => ['required'],
            'ate'    => ['required'],
        ]);

        $dataDeCarbon = Carbon::createFromFormat('d/m/Y', $request->get('de'));
        $dataAteCarbon = Carbon::createFromFormat('d/m/Y', $request->get('ate'));

        if ($dataDeCarbon->greaterThan($dataAteCarbon)) {
            throw new \Exception('A data "de" não pode ser maior do que a data "ate".');
        }

        $indice = $request->route('indice');
        $preco = $request->route('preco');
        $de = $request->get('de');
        $ate = $request->get('ate');

        // Chave única para esta combinação de parâmetros
        $cacheKey = "ajuste_{$indice}_preco_{$preco}_periodo_{$de}_to_{$ate}";

        $data = Cache::remember($cacheKey, 1, function() use ($indice, $de, $ate, $preco) {
            $indiceHistorico = $this->indiceModel->getIndicePeriodo($indice, $de, $ate);
            return $this->model->ajusteDePrecoPeriodo($indiceHistorico, $preco);
        });

        return response()->json(['data' => $data]);
    }
}

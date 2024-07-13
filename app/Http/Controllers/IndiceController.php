<?php

namespace App\Http\Controllers;

use App\Models\IndiceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class IndiceController extends Controller
{
    /**
     * Undocumented variable
     *
     * @var IndiceModel
     */
    private $model;

    public function __construct()
    {
        $this->model = new IndiceModel();
    }

    public function getIndiceMeses(Request $request)
    {
        $request->merge([
            'indice' => $request->route('indice'),
            'meses'  => $request->get('meses')
        ]);

        $request->validate([
            'indice' => ['required'],
            'meses'  => ['required','numeric', 'gt:0']
        ], [
            'meses.gt' => 'O campo Meses deve ser um número positivo.',
        ]);

        $indice = $request->route('indice');
        $meses = $request->get('meses');

        // Chave única para este índice e meses
        $cacheKey = "indice_{$indice}_meses_{$meses}";

        $data = Cache::remember($cacheKey, 100, function() use ($indice, $meses) {
            return $this->model->getIndiceMeses($indice, $meses);
        });

        dd($data);

        return response()->json(['data' => $data]);
    }

    public function getIndicePeriodo(Request $request)
    {
        $request->merge([
            'indice' => $request->route('indice'),
            'de'     => $request->get('de'),
            'ate'    => $request->get('ate')
        ]);

        $request->validate([
            'indice' => ['required'],
            'de'     => ['required'],
            'ate'    => ['required']
        ]);

        $indice = $request->route('indice');
        $de = $request->get('de');
        $ate = $request->get('ate');

        // Chave única para este índice, data inicial e data final
        $cacheKey = "indice_{$indice}_periodo_{$de}_to_{$ate}";

        $data = Cache::remember($cacheKey, 1, function() use ($indice, $de, $ate) {
            return $this->model->getIndicePeriodo($indice, $de, $ate);
        });

        return response()->json(['data' => $data]);
    }
}
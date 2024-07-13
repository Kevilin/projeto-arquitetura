<?php

namespace App\Models;

class AjusteDePrecoModel
{

    public function ajusteDePrecoPeriodo($historicoIndice, $preco)
    {
        $meses = $this->getMeses($historicoIndice);
        $taxa = $this->getTaxa($historicoIndice, $meses);
        $precoComAjuste = $this->calculaPrecoComAjuste($preco, $taxa);
        return $this->formatarPreco($precoComAjuste);
    }

    private function getMeses($historicoIndice)
    {
        return count($historicoIndice);
    }

    private function getTaxa($historicoIndice, $meses)
    {
        $taxaTotal = 0;

        foreach ($historicoIndice as $dataMes) {
            $taxaTotal += $dataMes->valor;
        }
        return $taxaTotal / $meses;
    }

    private function calculaPrecoComAjuste($preco, $taxa)
    {   
        return $preco + (($preco * $taxa) /100);
    }

    private function formatarPreco($preco)
    {
        return number_format($preco, 2, ',', '.');
    }
}

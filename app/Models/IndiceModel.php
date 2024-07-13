<?php

namespace App\Models;

use App\Repository\IndiceRepository;

class IndiceModel
{
    private $repository;

    public function __construct()
    {
        $this->repository = new IndiceRepository;
    }

    public function getIndiceMeses($indice,$meses)
    {   
        return $this->repository->getIndiceMeses($indice,$meses);
    }

    public function getIndicePeriodo($indice,$de,$ate)
    {   
        return $this->repository->getIndicePeriodo($indice,$de,$ate);
    }
}

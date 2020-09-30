<?php

namespace App\Http\Services;

use App\Http\Resources\StoreResource;
use App\Repositories\StoreRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class StoreService
{
    protected $repository;

    public function __construct(StoreRepository $repository){
        $this->repository = $repository;
    }

    public function importarDadosCsv(){
        Log::info('Entrou na função ' . __FUNCTION__);

        return [
            'success'   => true,
            'message'   => 'Dados importados com sucesso.',
            'data'      => []
        ];
    }
}

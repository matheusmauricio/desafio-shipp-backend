<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\StoreService;

class StoreController extends Controller
{
    protected $service;

    public function __construct(StoreService $service){
        $this->service = $service;
    }

    public function importarDadosCsv(){
        return $this->service->importarDadosCsv();
    }

    public function inserirLoja(Request $request){
        $dados = $request->all();

        return $this->service->inserirLoja($dados);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StoreService;

class StoreController extends Controller
{
    protected $service;

    public function __construct(StoreService $service){
        $this->service = $service;
    }

    public function inserirLoja(Request $request){
        $dados = $request->all();

        return $this->service->inserirLoja($dados);
    }

    public function buscarLojas($latitude = null, $longitude = null){
        return $this->service->buscarLojas($latitude, $longitude);
    }
}

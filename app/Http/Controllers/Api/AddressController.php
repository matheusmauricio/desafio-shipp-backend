<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AddressService;

class AddressController extends Controller
{
    protected $service;

    public function __construct(AddressService $service){
        $this->service = $service;
    }

    public function inserirEndereco(Request $request){
        $dados = $request->all();

        return $this->service->inserirEndereco($dados);
    }
}

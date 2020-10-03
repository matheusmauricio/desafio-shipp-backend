<?php

namespace App\Repositories;

use App\Models\StoreModel;

class StoreRepository
{
	private $model;

	public function __construct(StoreModel $model)
	{
		$this->model = $model;
	}

    public function listarTodasLojas(){
        return $this->model
        ->select('store.*', 'address.latitude', 'address.longitude')
        ->join('address', 'store.id_address', '=', 'address.id')
        ->where('latitude', '<>', '')
        ->where('longitude', '<>', '')
        ->get();
    }

    public function detalharLoja($idLoja){
        return $this->model
        ->where('id', '=', $idLoja)
        ->first();
    }

    public function inserirLoja($dados){
        return $this->model
        ->insertGetId([
            'id_address'            => $dados['idAddress'],
            'license_number'        => $dados['licenseNumber'],
            'operation_type'        => $dados['operationType'],
            'establishment_type'    => $dados['establishmentType'],
            'entity_name'           => $dados['entityName'],
            'dba_name'              => $dados['dbaName'],
        ]);
    }
}

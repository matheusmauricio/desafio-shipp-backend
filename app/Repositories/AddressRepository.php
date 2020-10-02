<?php

namespace App\Repositories;

use App\Models\AddressModel;

class AddressRepository
{
	private $model;

	public function __construct(AddressModel $model)
	{
		$this->model = $model;
	}

    public function detalharEndereco($idEndereco){
        return $this->model
        ->where('id', '=', $idEndereco)
        ->first();
    }

    public function inserirEndereco($dados){
        return $this->model
        ->insertGetId([
            'county'            => $dados['county'],
            'street_number'     => $dados['streetNumber'],
            'street_name'       => $dados['streetName'],
            'address_line2'     => $dados['addressLine2'],
            'address_line3'     => $dados['addressLine3'],
            'city'              => $dados['city'],
            'state'             => $dados['state'],
            'zip_code'          => $dados['zipCode'],
            'square_footage'    => $dados['squareFootage'],
            'location'          => $dados['location'],
            'latitude'          => $dados['latitude'],
            'longitude'         => $dados['longitude'],
            'needs_recoding'    => $dados['needsRecoding'],
        ]);
    }
}

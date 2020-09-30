<?php

namespace App\Http\Services;

use App\Http\Resources\AddressResource;
use App\Repositories\AddressRepository;
use Exception;

class AddressService
{
    protected $repository;

    public function __construct(AddressRepository $repository){
        $this->repository = $repository;
    }


}

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

}

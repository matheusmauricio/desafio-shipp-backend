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

}

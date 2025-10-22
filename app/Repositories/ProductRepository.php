<?php
namespace App\Repositories;

use App\Models\Product;


class ProductRepository extends BaseRepository
{

	public function __construct(Product $model)
	{
		parent::__construct($model);
	}


	public function customQuery($params)
	{
		if (empty($params)) {
			return [];
		}

		if (!empty($params['id'])) {
			$query = $this->model->where(['id' => $params['id']]);
		}

		if (!empty($params['name'])) {
			$query = $this->model->where(['LIKE', 'name', $params['name']]);
		}

		$result = $query->get();

		return $result;
	}


}

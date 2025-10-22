<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;


class BaseRepository
{
	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function all($filters = [])
	{
		$query = $this->model;

		if (!empty($filters)) {
			$query->where($filters);
		}

		$result = $query->get();

		return $result;
	}

	public function get(int $id)
	{
		return $this->model->findOrFail($id);
	}

	public function save(Model $model)
	{
		$model->save();

		return $model;
	}

	public function delete(Model $model)
	{
		$model->delete();

		return $model;
	}


}

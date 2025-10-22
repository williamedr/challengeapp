<?php
namespace App\Repositories;

use App\Models\Product;
use App\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    public function all(array $filters = [])
    {
        $q = $this->model->newQuery();

        if (!empty($filters['search'])) {
            $q->where('name', 'like', '%' . $filters['search'] . '%');
        }

        return $q->paginate($filters['per_page'] ?? 15);
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $p = $this->find($id);
        $p->update($data);
        return $p;
    }

    public function delete(int $id): bool
    {
        $p = $this->find($id);
        return $p->delete();
    }
}

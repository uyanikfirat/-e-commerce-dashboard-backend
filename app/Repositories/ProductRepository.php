<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class ProductRepository extends BaseRepository
{
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function find(int $id)
    {
        try{
            return $this->model->find($id);
        }catch(ModelNotFoundException $e){
            return response()->json(['error' => 'Product not found'],404);
        }
    }

}

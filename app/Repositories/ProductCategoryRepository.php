<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class ProductCategoryRepository extends BaseRepository
{
    protected $model;

    public function __construct(ProductCategory $model)
    {
        $this->model = $model;
    }
}

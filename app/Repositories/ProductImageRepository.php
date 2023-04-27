<?php

namespace App\Repositories;

use App\Models\ProductImage;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class ProductImageRepository extends BaseRepository
{
    protected $model;

    public function __construct(ProductImage $model)
    {
        $this->model = $model;
    }


}

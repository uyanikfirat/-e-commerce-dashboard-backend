<?php

namespace App\Repositories;

use App\Models\Discount;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class DiscountRepository extends BaseRepository
{
    protected $model;

    public function __construct(Discount $model)
    {
        $this->model = $model;
    }
}

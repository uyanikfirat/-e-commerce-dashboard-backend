<?php

namespace App\Repositories;

use App\Models\Shipping;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class ShippingRepository extends BaseRepository
{
    protected $model;

    public function __construct(Shipping $model)
    {
        $this->model = $model;
    }
}

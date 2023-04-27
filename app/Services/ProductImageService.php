<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Repositories\ProductImageRepository;

class ProductImageService extends BaseService
{
    protected $productImagerepository;

    public function __construct(ProductImageRepository $productImagerepository)
    {
       $this->productImagerepository = $productImagerepository;
    }

    public function getAll()
    {
       return $this->productImagerepository->all();
    }

    public function find(int $id)
    {
       return $this->productImagerepository->find($id);
    }

    public function create(Request $request)
    {
        $createdPost = $this->productImagerepository->create($request->all());
        return $createdPost;
    }

    public function update(int $id, Request $request)
    {
       return $this->productImagerepository->update($id, $request->all());
    }

    public function delete(int $id)
    {
       return $this->productImagerepository->delete($id);
    }

}

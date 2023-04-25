<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\ApiController;
use App\Services\ProductCategoryService;

class ProductCategoryController extends ApiController
{
    protected $productCategoryService;
    public function __construct(ProductCategoryService $productCategoryService)
    {
        $this->productCategoryService = $productCategoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->productCategoryService->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return response()->json($this->productCategoryService->create($request));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try{
            return response()->json($this->productCategoryService->find($id));
        }catch(\Exception $e) {
            return $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $id, Request $request)
    {
        try{
            return response()->json($this->productCategoryService->update($id, $request));
        }catch(\Exception $e) {
            return $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        return $this->productCategoryService->delete($id);
    }
}

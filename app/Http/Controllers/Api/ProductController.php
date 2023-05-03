<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\ApiController;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        return response()->json($this->productService->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        try{
            return response()->json($this->productService->create($request));
        }catch(\Exception $e) {
            return $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try{
            return response()->json($this->productService->find($id));
        }catch(\Exception $e) {
            return $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $id)
    {   
        try{
            return response()->json($this->productService->update($id, $request));
        }catch(\Exception $e) {
            return $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

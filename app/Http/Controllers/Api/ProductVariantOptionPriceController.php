<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ProductVariantOptionPrice;
use App\Http\Controllers\ApiController;

class ProductVariantOptionPriceController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductVariantOptionPrice::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductVariantOptionPrice $productVariantOption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductVariantOptionPrice $productVariantOption)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductVariantOptionPrice $productVariantOption)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariantOptionPrice $productVariantOption)
    {
        //
    }
}

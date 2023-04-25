<?php

namespace App\Http\Controllers\Api;

use App\Models\Discount;
use Illuminate\Http\Request;
use App\Services\DiscountService;
use App\Http\Controllers\ApiController;

class DiscountController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    protected $discountService;
    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }

    public function index()
    {
        return response()->json($this->discountService->getAll());
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
        try{
            return response()->json($this->discountService->create($request));
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
            return response()->json($this->discountService->find($id));
        }catch(\Exception $e) {
            return $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discount $discount)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        //
    }
}

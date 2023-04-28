<?php

namespace App\Http\Controllers\Api;

use App\Models\ProductSize;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SizeController extends ApiController
{





    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return  ProductSize::all();
    }

 }


<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Product model
     * @var \App\Models\Product
     */
    public $products;

    /**
     * Create a new controller instance.
     * @param  \App\Models\Product  $products
     */
    public function __construct(Product $products)
    {
        $this->products = $products;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = $this->products
            ->available()
            ->sort($request->get('sort'));
        return ProductResource::collection($query->paginate(10));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function liked(Request $request)
    {
        $query = $this->products
            ->available()
            ->liked($request->user('api'))
            ->sort($request->get('sort'));
        return ProductResource::collection($query->paginate(10));
    }
}

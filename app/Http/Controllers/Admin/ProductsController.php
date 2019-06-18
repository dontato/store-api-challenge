<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\CreateRequest;
use App\Http\Requests\Products\UpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = $this->products
            ->sort($request->get('sort'))
            ->lookup($request->get('term'));
        return ProductResource::collection($query->paginate(10));
    }

    /**
     * Store a new product resource
     * @param  \App\Http\Requests\Products\CreateRequest $request
     * @return \App\Http\Resources\ProductResource|\Illuminate\Http\JsonResponse
     */
    public function store(CreateRequest $request)
    {
        $product = $this->products->newInstance();
        $product->fill($request->validated());

        if ($product->save()) {
            return new ProductResource($product);
        }

        return new JsonResponse(['error' => 'unable_to_create'], 422);
    }

    /**
     * Show a given product
     * @param  string  $uuid
     * @return \App\Http\Resources\ProductResource
     */
    public function show($uuid)
    {
        $product = $this->products->findByUuidOrFail($uuid)
            ->load('prices', 'user');
        return new ProductResource($product);
    }

    /**
     * Update an existing product resource
     * @param  \App\Http\Requests\Products\UpdateRequest $request
     * @param  string                                    $uuid
     * @return \App\Http\Resources\ProductResource|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, $uuid)
    {
        $product = $this->products->findByUuidOrFail($uuid);

        $this->authorize('update', $product);
        $data = $request->validated();

        if ($request->user('api')->cant('updatePrice', $product)) {
            unset($data['price']);
        }

        $product->fill($data);

        if ($product->save()) {
            return new ProductResource($product);
        }

        return new JsonResponse(['error' => 'unable_to_update'], 422);
    }

    /**
     * Delete a given product
     * @param  string  $uuid
     * @return \App\Http\Resources\ProductResource|\Illuminate\Http\JsonResponse
     */
    public function destroy($uuid)
    {
        $product = $this->products->findByUuidOrFail($uuid);

        $this->authorize('delete', $product);

        if ($product->delete()) {
            return new ProductResource($product);
        }

        return new JsonResponse(['error' => 'unable_to_delete'], 422);
    }
}

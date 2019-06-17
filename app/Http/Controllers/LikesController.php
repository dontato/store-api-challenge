<?php

namespace App\Http\Controllers;

use App\Http\Resources\LikeResource;
use App\Models\Like;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LikesController extends Controller
{
    /**
     * Like model
     * @var \App\Models\Like
     */
    public $likes;

    /**
     * Product model
     * @var \App\Models\Product
     */
    public $products;

    /**
     * Create a new controller instance.
     * @param  \App\Models\Product  $products
     * @param  \App\Models\Like     $likes
     */
    public function __construct(Product $products, Like $likes)
    {
        $this->products = $products;
        $this->likes    = $likes;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $uuid)
    {
        $product = $this->products->findByUuidOrFail($uuid);
        $product->likes()->firstOrCreate([
            'user_id' => $request->user('api')->id
        ]);
        return new JsonResponse(['liked' => true], 201);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $uuid)
    {
        $product = $this->products->findByUuidOrFail($uuid);
        $like = $product->likes()
            ->where('user_id', $request->user('api')->id)
            ->first();

        if ($like) {
            $like->delete();
        }

        return new JsonResponse(['liked' => false]);
    }
}

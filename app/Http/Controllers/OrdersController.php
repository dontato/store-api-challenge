<?php

namespace App\Http\Controllers;

use App\Http\Resources\LikeResource;
use App\Http\Resources\OrderResource;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Cart\Cart;
use App\Contracts\OrderFactory;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Order model
     * @var \App\Models\Order
     */
    public $orders;

    /**
     * Order model
     * @var \App\Models\Product
     */
    public $products;

    /**
     * Create a new controller instance.
     * @param  \App\Models\Order    $orders
     * @param  \App\Models\Product  $products
     */
    public function __construct(Order $orders, Product $products)
    {
        $this->orders   = $orders;
        $this->products = $products;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = $this->orders
            ->latest()
            ->with('lineItems.product')
            ->mine($request->user('api'));
        return OrderResource::collection($query->paginate(10));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\CreateOrderRequest  $request
     * @param  \App\Contracts\OrderFactory            $orders
     * @return \App\Http\Resources\OrderResource
     */
    public function store(CreateOrderRequest $request, OrderFactory $orders)
    {

        $items    = collect($request->get('items', []));
        $cart     = new Cart;
        $products = $this->products
            ->whereIn('uuid', $items->pluck('uuid'))
            ->get();

        $items->each(function ($item) use ($products, $cart) {
            $cart->addProduct(
                $products->where('uuid', $item['uuid'])->first(),
                $item['quantity']
            );
        });

        $order = $orders->placeOrder($cart);

        return new OrderResource($order->load('lineItems.product'));
    }
}

<?php

namespace App\Http\Resources;

class LineItemResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'quantity' => $this->quantity,
            'price'    => $this->price,
            'total'    => $this->total,
            'product'  => new ProductResource($this->whenLoaded('product')),
        ];
    }
}

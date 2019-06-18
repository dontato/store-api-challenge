<?php

namespace App\Http\Resources;

class OrderResource extends BaseResource
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
            'uuid'           => $this->uuid,
            'user_id'        => $this->user_id,
            'status'         => $this->status,
            'total'          => $this->total,
            'total_products' => $this->total_products,
            'created_at'     => $this->asDate('created_at'),
            'line_items'     => LineItemResource::collection(
                $this->whenLoaded('lineItems')
            ),
        ];
    }
}

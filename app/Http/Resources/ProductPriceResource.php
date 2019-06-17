<?php

namespace App\Http\Resources;

class ProductPriceResource extends BaseResource
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
            'old_price'  => $this->slug,
            'new_price'  => $this->uuid,
            'user_id'    => $this->sku,
            'created_at' => $this->asDate('created_at'),
            'user'       => new UserResource($this->whenLoaded('user')),
        ];
    }
}

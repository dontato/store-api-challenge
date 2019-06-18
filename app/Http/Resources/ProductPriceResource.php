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
            'old_price'  => $this->old_price,
            'new_price'  => $this->new_price,
            'user_id'    => $this->user_id,
            'created_at' => $this->asDate('created_at'),
            'user'       => new UserResource($this->whenLoaded('user')),
        ];
    }
}

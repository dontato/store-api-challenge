<?php

namespace App\Http\Resources;

class LikeResource extends BaseResource
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
            'user'       => new UserResource($this->whenLoaded('user')),
            'product'    => new ProductResource($this->whenLoaded('product')),
            'created_at' => $this->asDate('created_at'),
        ];
    }
}

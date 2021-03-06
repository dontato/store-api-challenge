<?php

namespace App\Http\Resources;

class ProductResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = $request->user('api');

        return [
            'name'        => $this->name,
            'slug'        => $this->slug,
            'description' => $this->description,
            'uuid'        => $this->uuid,
            'sku'         => $this->sku,
            'liked'       => $this->likedBy($user),
            'price'       => (float) $this->price,
            'price_human' => number_format((float) $this->price, 2, '.', ','),
            'stock'       => (int) $this->stock,
            'like_count'  => (int) $this->like_count,
            'created_at'  => $this->asDate('created_at'),
            $this->mergeWhen(
                $user && $user->hasPermissionTo('manage products'),
                [
                    'is_available' => (int) $this->is_available,
                    'user'         => new UserResource(
                        $this->whenLoaded('user')
                    ),
                    'prices'       => ProductPriceResource::collection(
                        $this->whenLoaded('prices')
                    ),
                ]
            ),
        ];
    }
}

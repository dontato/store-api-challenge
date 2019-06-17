<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create products.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create products');
    }

    /**
     * Determine whether the user can update the product.
     *
     * @param  \App\Models\User     $user
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function update(User $user, Product $product)
    {
        if ($user->hasPermissionTo('edit any product')) {
            return true;
        }

        if ($user->hasPermissionTo('edit products')) {
            return $user->id == $product->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the product.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function delete(User $user, Product $product)
    {
        if ($user->hasPermissionTo('delete any product')) {
            return true;
        }

        if ($user->hasPermissionTo('delete products')) {
            return $user->id == $product->user_id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the product.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Product  $product
     * @return mixed
     */
    public function updatePrice(User $user, Product $product)
    {
        if ($user->hasPermissionTo('update any product prices')) {
            return true;
        }

        if ($user->hasPermissionTo('update product prices')) {
            return $user->id == $product->user_id;
        }

        return false;
    }
}

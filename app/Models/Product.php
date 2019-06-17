<?php

namespace App\Models;

use App\Contracts\Product as ProductContract;
use App\Eloquent\HasUuid;
use App\Eloquent\Ownlable;
use App\Events\ProductUpdated;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model implements ProductContract
{
    use Sluggable, SoftDeletes, HasUuid, Ownlable, SearchableTrait;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'updating' => ProductUpdated::class,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'price'        => 'float',
        'like_count'   => 'integer',
        'id'           => 'integer',
        'stock'        => 'integer',
        'is_available' => 'integer',
    ];

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'name', 'description', 'sku', 'price', 'stock', 'is_available',
    ];

    /**
     * Searchable rules.
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'name' => 10,
            'description' => 5
        ]
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function price()
    {
        return $this->getAttribute('price');
    }

    /**
     * Determine if a given user has liked a product
     * @param  \App\Models\User|null   $user
     * @return boolean
     */
    public function likedBy(User $user = null)
    {
        if (!$user) {
            return false;
        }

        return $user->likes
            ->pluck('product_id')
            ->contains($this->getAttribute('id'));
    }

    /**
     * The product price update log
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    /**
     * Product likes
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Order results by popularity
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string                                $sort
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSort(Builder $query, $sort = 'az')
    {
        if ($sort == 'popularity') {
            $query->popular();
        } else {
            $query->az();
        }

        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Order results by popularity
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopular(Builder $query)
    {
        return $query->orderBy('like_count', 'desc');
    }

    /**
     * Order results by name
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAz(Builder $query)
    {
        return $query->orderBy('name');
    }

    /**
     * Filter results for public endpoint
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable(Builder $query)
    {
        return $query->where('is_available', 1);
    }

    /**
     * Filter results to include only liked products
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  \App\Models\User|null                 $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLiked(Builder $query, User $user = null)
    {
        if ($user) {
            $liked_products = $user->likes->pluck('product_id');
            $query->whereIn('id', $liked_products->all());
        }

        return $query;
    }

    /**
     * Filter results to include only liked products
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string                                $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLookup(Builder $query, $term)
    {
        if (!empty($term) && is_string($term) && trim($term)) {
            $query->search($term, null, true);
        }

        return $query;
    }
}

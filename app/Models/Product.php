<?php

namespace App\Models;

use App\Contracts\Product as ProductContract;
use App\Eloquent\HasUuid;
use App\Eloquent\Ownlable;
use App\Events\ProductUpdated;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model implements ProductContract
{
    use Sluggable, SoftDeletes, HasUuid, Ownlable;

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
        'price' => 'float',
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
}

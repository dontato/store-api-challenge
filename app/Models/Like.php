<?php

namespace App\Models;

use App\Eloquent\Ownlable;
use App\Events\ProductLiked;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use Ownlable;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ProductLiked::class,
        'deleted' => ProductLiked::class,
    ];

    /**
     * Product liked
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

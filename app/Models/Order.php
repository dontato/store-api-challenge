<?php

namespace App\Models;

use App\Contracts\Order as OrderContract;
use App\Eloquent\HasUuid;
use App\Eloquent\Ownlable;
use Illuminate\Database\Eloquent\Model;

class Order extends Model implements OrderContract
{
    use Ownlable, HasUuid;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'total' => 'float',
    ];

    /**
     * Line items
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lineItems()
    {
        return $this->hasMany(LineItem::class);
    }
}

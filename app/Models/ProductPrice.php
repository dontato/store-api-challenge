<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    /**
     * @inheritdoc
     */
    protected $fillable = ['new_price', 'old_price', 'user_id'];
}

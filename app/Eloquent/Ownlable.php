<?php

namespace App\Eloquent;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait Ownlable
{
    /**
     * Boot trait
     * @return void
     */
    public static function bootOwnlable()
    {
        static::creating(function (Model $model) {
            if ($model->user_id == null && auth('api')->check()) {
                $model->user()
                    ->associate(auth('api')->user());
            }
        });
    }

    /**
     * User that created the model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

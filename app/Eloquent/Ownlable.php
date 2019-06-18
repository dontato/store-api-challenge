<?php

namespace App\Eloquent;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

    /**
     * Filter to include only records created by given user
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \App\Models\User                      $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMine(Builder $builder, User $user = null)
    {
        if ($user) {
            $builder->where('user_id', $user->id);
        }

        return $builder;
    }
}

<?php

namespace App\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Boot trait
     * @return void
     */
    public static function bootHasUuid()
    {
        static::creating(function (Model $model) {
            $model->uuid = (string) Str::uuid();
        });
    }
}

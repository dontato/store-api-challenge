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

    /**
     * Find a model by UUID
     * @param  string $uuid
     * @return static
     */
    public function findByUuid($uuid)
    {
        return $this->newQuery()
            ->where('uuid', $uuid)
            ->select('*')
            ->first();
    }

    /**
     * Find a model by UUID and throw an exception when no result is found
     * @param  string $uuid
     * @return static
     */
    public function findByUuidOrFail($uuid)
    {
        return $this->newQuery()
            ->where('uuid', $uuid)
            ->select('*')
            ->firstOrFail([]);
    }
}

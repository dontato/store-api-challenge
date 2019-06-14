<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

abstract class BaseResource extends JsonResource
{
    /**
     * Parse attribute as date
     * @param  string $attribute
     * @return \Illuminate\Http\Resources\MissingValue|mixed
     */
    protected function asDate($attribute)
    {
        return $this->when($this->{$attribute}, function () use ($attribute) {
            if ($this->{$attribute} instanceof Carbon) {
                return $this->{$attribute}->toIso8601String();
            }

            return new MissingValue;
        });
    }
}

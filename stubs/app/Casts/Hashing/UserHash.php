<?php

namespace App\Casts\Hashing;

use App\Services\HashidService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class UserHash implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return (new HashidService(config('hashids.default.salt'), config('hashids.default.length')))->encode($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return (new HashidService(config('hashids.default.salt'), config('hashids.default.length')))->decode($value);;
    }
}

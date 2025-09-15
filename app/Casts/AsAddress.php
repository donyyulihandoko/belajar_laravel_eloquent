<?php

namespace App\Casts;

use App\Models\Address;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class AsAddress implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?Address
    {
        if ($value == null) return null;

        $addreses = explode(', ', $value);
        return new Address($addreses[0], $addreses[1], $addreses[2], $addreses[3]);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value == null) return null;

        return "$value->street, $value->city, $value->country, $value->postal_code";
    }
}

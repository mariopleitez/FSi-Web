<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            "identificador" => (int) $user->id, 
            "nombre" => (string) $user->name,
        ];
    }

    public static  function originalAttribute($index)
    {
        $attributes =  [
            "identificador" => "id", 
            "nombre"        => "name",
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}

<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    protected $attributes;

    public function __construct($attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * A Fractal transformer.
     *
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        $returnData = collect([
            'id'        => $user->id,
            'name'      => $user->name,
            'username'  => $user->username,
            'email'     => $user->email,
        ]);

        if ($this->attributes) {
            collect($this->attributes)->each(static function ($attribute, $key) use ($returnData) {
                $returnData->put($key, $attribute);
            });
        }

        return $returnData->toArray();
    }
}

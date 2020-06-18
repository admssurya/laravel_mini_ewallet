<?php


namespace App\Models\Traits;


trait Uuid
{
    protected static function bootUuid()
    {
        static::creating(function ($model) {
            if (! $model->getKey()) {
                $model->{$model->getKeyName()} = (string) \Ramsey\Uuid\Uuid::uuid6();
            }
        });
    }
}

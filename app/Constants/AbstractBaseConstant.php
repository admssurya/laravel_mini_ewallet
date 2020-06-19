<?php


namespace App\Constants;


use Illuminate\Support\Str;
use ReflectionClass;

abstract class AbstractBaseConstant
{
    public static function all(): array
    {
        $constants = collect((new ReflectionClass(static::class))->getConstants());
        $values = collect();
        $constants->each(
            static function ($constant, $index) use ($values) {
                $values->put($constant, Str::title(str_replace('_', ' ', $index)));
            }
        );

        return $values->toArray();

    }
}

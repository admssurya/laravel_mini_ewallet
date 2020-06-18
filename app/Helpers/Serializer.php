<?php

namespace App\Helpers;

use League\Fractal\Serializer\DataArraySerializer;

class Serializer extends DataArraySerializer
{
    /**
     * @param  string $resourceKey
     * @param  array  $data
     * @return array
     */
    public function collection($resourceKey, array $data): array
    {
        return $data;
    }

    /**
     * @param  string $resourceKey
     * @param  array  $data
     * @return array
     */
    public function item($resourceKey, array $data): array
    {
        return $data;
    }

    /**
     * @return array
     */
    public function null(): array
    {
        return [];
    }
}

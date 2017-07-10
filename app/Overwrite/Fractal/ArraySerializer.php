<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 10.07.17
 * Time: 12:58
 */

namespace App\Overwrite\Fractal;


class ArraySerializer extends \League\Fractal\Serializer\ArraySerializer{


    /**
     * Serialize a collection.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        return [$resourceKey ?: 'data' => $data];
    }
}
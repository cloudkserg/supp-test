<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 04.09.17
 * Time: 13:44
 */

namespace App\Helpers;


use Illuminate\Database\Eloquent\Model;

class ModelHelper
{

    /**
     * @param $outputItem
     * @param array $params
     */
    public function copyParams(Model &$outputItem, array $params)
    {
        foreach ($params as $outputParam => $inputValue) {
            if ($inputValue != null) {
                $outputItem->$outputParam = $inputValue;
            }
        }
    }

}
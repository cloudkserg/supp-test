<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 15.09.16
 * Time: 9:39
 */

namespace App\Type;

abstract class ConstType
{

    /**
     * @return array
     */
    abstract public function getTitles();


    /**
     * @param $type
     * @return mixed
     * @throws \Exception
     */
    public function getTitle($type)
    {
        if (!isset($this->getTitles()[$type])) {
            throw new \Exception('Нет такого типа:' . $type);
        }
        return $this->getTitles()[$type];
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return array_keys($this->getTitles());
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->getTitles();
    }

}
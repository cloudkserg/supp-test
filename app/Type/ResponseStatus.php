<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 16:18
 */

namespace App\Type;


class ResponseStatus extends ConstType
{
    const ACTIVE = 'active';
    const ARCHIVED = 'archived';

    /**
     * @return array
     */
    public function getTitles()
    {
        return [
            self::ACTIVE => 'Создан',
            self::ARCHIVED => 'Архив'
        ];
    }


}
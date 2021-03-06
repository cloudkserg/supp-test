<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 16:18
 */

namespace App\Type;
use Swagger\Annotations as SWG;

/**
 *
 *
 * Class MessageStatus
 * @package App\Type
 */
class MessageStatus extends ConstType
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
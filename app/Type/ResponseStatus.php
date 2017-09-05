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
 * Class ResponseStatus
 * @package App\Type
 */
class ResponseStatus extends ConstType
{
    const DRAFT = 'draft';
    const ACTIVE = 'active';
    const CANCEL = 'cancel';
    const DONE = 'done';
    const DELETED = 'deleted';

    /**
     * @return array
     */
    public function getTitles()
    {
        return [
            self::DRAFT => 'Ожидает ответа',
            self::ACTIVE => 'Создан',
            self::CANCEL => 'Отклонен',
            self::DELETED => 'Удалено',
            self::DONE => 'Завершено'
        ];
    }


}
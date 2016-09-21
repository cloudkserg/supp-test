<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 16:18
 */

namespace App\Type;


class InvoiceStatus extends ConstType
{
    const REQUESTED = 'requested';
    const RESPONSED = 'responsed';
    const CANCEL = 'cancel';

    /**
     * @return array
     */
    public function getTitles()
    {
        return [
            self::REQUESTED => 'Запрошен',
            self::RESPONSED => 'Получен счет',
            self::CANCEL => 'Отклонен'
        ];
    }


}
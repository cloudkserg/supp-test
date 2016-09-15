<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 16:18
 */

namespace App\Type;


class DemandItemStatus extends ConstType
{
    const ACTIVE = 'active';
    const SELECTED = 'selected';
    const INVOICING = 'invoicing';
    const INVOICED = 'invoiced';
    const ARCHIVED = 'archived';

    /**
     * @return array
     */
    public function getTitles()
    {
        return [
            self::ACTIVE => 'Создан',
            self::SELECTED => 'Выбран поставщик',
            self::INVOICING => 'Запрошен счет',
            self::INVOICED => 'Получен счет',
            self::ARCHIVED => 'Архив',
        ];
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 29.07.17
 * Time: 18:40
 */

namespace App\Queries;

use Illuminate\Database\Eloquent\Builder;

interface Query
{

    /**
     * @return Builder
     */
    public function getBuilder();

}
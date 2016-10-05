<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 05.10.16
 * Time: 0:58
 */

namespace App\Bindings;


interface BindingInterface
{

    public function generateEventBindings();

    public function generateListenerBindings();

}
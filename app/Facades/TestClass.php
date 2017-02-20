<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * author: ouhanrong
 * Created by PhpStorm.
 * User: ohr445321
 * Date: 2017/2/16
 * Time: 15:57
 */
class TestClass extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'test';
    }
}


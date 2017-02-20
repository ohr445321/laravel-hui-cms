<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Facades\Test;

/**
 * author: ouhanrong
 * Created by PhpStorm.
 * User: ohr445321
 * Date: 2017/2/16
 * Time: 16:01
 */

class TestServiceProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('test', function(){
           return new Test;
        });
    }
}
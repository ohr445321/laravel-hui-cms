<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Facades\Test;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * author: ouhanrong
 * Created by PhpStorm.
 * User: ohr445321
 * Date: 2017/2/16
 * Time: 16:01
 */

class TestServiceProvider extends ServiceProvider
{
    //开启延时加载
    protected $defer = true;

    public function boot()
    {

    }

    public function register()
    {
        $this->app->bind('test', function(){
           return new Test;
        });

        $this->app->singleton('TestLog', function ($app) {
//            $Logger = new Logger('test_channel');
//
//            $Logger->pushHandler(new StreamHandler(__DIR__.'../../storage/logs/test.log', Logger::DEBUG));
//            $Logger->pushHandler(new FirePHPHandler());

            $stream = new StreamHandler(__DIR__.'/../../storage/logs/test.log', Logger::DEBUG);
            $firephp = new FirePHPHandler();

            $logger = new Logger('test_channel');
            $logger->pushHandler($stream);
            $logger->pushHandler($firephp);

            return $logger;
        });
    }

    /**
     * 设置延时加载的服务
     */
    public function provides()
    {
        return [
            'Log',
        ];
    }
}
<?php
/**
 * 功能：系统日志
 * author: ouhanrong
 * User: ohr445321
 * Date: 2017/2/28
 * Time: 15:42
 */

namespace App\Http\Controllers\Log;

use App;
use App\Http\Controllers\Controller;

class AdminLogController extends Controller
{

    public function anyTest()
    {
        $m_admin_log = App::make('AdminLogModel');
//        $m_admin_log->login_log = 'admin登陆系统';
//
//        if ($m_admin_log->save()){
//            dump('操作成功~');
//        }

//        App::make('TestLog')->pushHandler('My logger is now ready');
//        App::make('TestLog')->pushHandler('My logger is now ready');
//        App::make('TestLog')->pushHandler('My logger is now ready');

        // You can now use your logger
        App::make('TestLog')->info('My logger is now ready', array('username' => '张三'));

        $data = $m_admin_log->all();

        dump($data->toArray());
    }
}
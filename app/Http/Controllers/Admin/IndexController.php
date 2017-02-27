<?php
/**
 * Created by PhpStorm.
 * User: ohr
 * Date: 2016/12/6
 * Time: 18:13
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * author: ouhanrong
     * 功能：后台首页
     */
    public function Index()
    {
        return view('admin.index.index', ['user_info' => session(config('site.user_session_key'))]);
    }

    /**
     * 功能：欢迎页面
     * author: ouhanrong
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function welcome()
    {
        return view('welcome');
    }
}
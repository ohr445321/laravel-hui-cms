<?php
/**
 * @author:    ouhanrong
 * Created by PhpStorm.
 * User: ohr
 * Date: 2017/1/5
 * Time: 14:45
 */

namespace App\Http\Controllers\Admin;

use App\Http\Business\PublicBusiness;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PublicController extends Controller
{
    /**
     * author: ouhanrong
     * 功能：后台登陆
     */
    public function login(Request $request)
    {
        //如果已经登录，则直接返回首页或上一级页面
        $jump_url = !empty($request->server('HTTP_REFERER')) ? $request->server('HTTP_REFERER') : '/admin';

        $session_key = config('site.user_session_key');
        $user_id = session($session_key.'.user_id');
        $username = session($session_key.'.username');

        if($user_id > 0 && !empty($username)){
            return redirect($jump_url);
        }

        return view('admin.public.login');
    }

    /**
     * 功能：检测用户登陆
     * author: ouhanrong
     * @param Request $request
     * @param PublicBusiness $business
     * @return array
     */
    public function checkLogin(Request $request, PublicBusiness $business)
    {
        $data = $request->all();

        $response = $business->checkLogin($data);

        return $this->jsonFormat($response);
    }

    /**
     * 功能：退出登陆
     * author: ouhanrong
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function anyLogout()
    {
        session([config('site.user_session_key') => '']);

        return $this->jsonFormat([]);
    }
}
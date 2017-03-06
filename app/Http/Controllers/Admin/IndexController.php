<?php
/**
 * Created by PhpStorm.
 * User: ohr
 * Date: 2016/12/6
 * Time: 18:13
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Business\RoleBusiness;

class IndexController extends Controller
{
    /**
     * author: ouhanrong
     * 功能：后台首页
     */
    public function Index(RoleBusiness $role_business)
    {
        //获取用户左侧菜单数据
        $menu_data = $role_business->getPermissionMenuByRoleId(session(config('site.user_session_key'))['role_id']);

        dump($menu_data);

        return view('admin.index.index', ['data' =>['user_info' => session(config('site.user_session_key'))]]);
    }

    /**
     * 功能：获取后台权限菜单
     * author: ouhanrong
     * @param RoleBusiness $role_business
     * @return array
     */
    public function ajaxGetPermissionMenu(RoleBusiness $role_business)
    {
        //获取用户左侧菜单数据
        $menu_data = $role_business->getPermissionMenuByRoleId(session(config('site.user_session_key'))['role_id']);

        return $this->jsonFormat($menu_data);
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
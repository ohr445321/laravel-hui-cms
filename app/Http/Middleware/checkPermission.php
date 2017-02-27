<?php
/**
 * author: ouhanrong
 * Created by PhpStorm.
 * User: ohr445321
 * Date: 2017/2/22
 * Time: 08:42
 */

namespace App\Http\Middleware;

use Closure;

class checkPermission
{
    /**
     * 功能：检测是否允许访问系统
     * author: ouhanrong
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function handle($request, Closure $next)
    {
        //中间件请求处理前执行的一些任务
        $session_key = config('site.user_session_key');
        $user_id = session($session_key.'.user_id');
        $username = session($session_key.'.username');

        if (empty($user_id) || empty($username)) {
            return redirect('/admin/login');
        }

        $response = $next($request);

        //中间件请求处理后执行的一些任务
        //执行代码~~

        return $response;
    }
}
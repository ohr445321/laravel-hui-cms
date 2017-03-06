<?php
/**
 * @author:    ouhanrong
 * Created by PhpStorm.
 * User: ohr
 * Date: 2017/1/5
 * Time: 14:53
 */

namespace App\Http\Controllers\Admin;

use App\Http\Business\RoleBusiness;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Exceptions\JsonException;
use App\Http\Business\UsersBusiness;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * 功能：用户列表
     * author: ouhanrong
     * @param UsersBusiness $users_business
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, UsersBusiness $users_business)
    {
        $get_data = $request->all();

        $list_data = $users_business->getUsersList(array_merge($get_data, ['page_size' => 10, 'sort_column' => 'id', 'sort_type' => 'desc']), ['*'], []);

        return view('admin.user.index', ['data' => ['get_data' => $get_data, 'user_list' => $list_data]]);
    }

    /**
     * 功能：添加用户页面
     * author: ouhanrong
     * @param RoleBusiness $role_business
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(RoleBusiness $role_business)
    {
        //获取用户角色
        $role_data = $role_business->getRoleList(['all' => 1, 'is_disable' => 0, 'sort_column' => 'id', 'sort_type' => 'asc'], ['id','role_name'], []);

        return view('admin.user.create', ['role_data' => $role_data]);
    }


    /**
     * 功能：保存用户
     * author: ouhanrong
     * @param Request $request
     * @param UsersBusiness $users_business
     * @return array
     */
    public function store(Request $request, UsersBusiness $users_business)
    {
        $post_data = $request->all();

        $response = $users_business->storeUser($post_data);

        return $this->jsonFormat($response);

    }

    /**
     * 功能：编辑用户界面
     * author: ouhanrong
     * @param $id
     * @param UsersBusiness $users_business
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws JsonException
     */
    public function edit($id, UsersBusiness $users_business, RoleBusiness $role_business)
    {
        //获取用户角色
        $role_data = $role_business->getRoleList(['all' => 1, 'is_disable' => 0, 'sort_column' => 'id', 'sort_type' => 'asc'], ['id','role_name'], []);
        //获取用户角色
        $user_data = $users_business->getUserDetails($id, ['id', 'role_id','username','sex','email']);

        $data = [
            'role_data' => $role_data,
            'user_data' => $user_data
        ];

        return view('admin.user.edit', ['data' => $data]);
    }

    /**
     * 功能：更新用户信息
     * author: ouhanrong
     * @param $id
     * @param Input $input
     * @param UsersBusiness $users_business
     * @return array
     */
    public function update($id, Input $input, UsersBusiness $users_business)
    {
        $post_data = $input->get();

        $response = $users_business->updateUser($id, $post_data);

        return $this->jsonFormat($response);
    }

    /**
     * 功能：更新用户密码Iframe
     * author: ouhanrong
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updatePasswordIframe($id)
    {
        return view('admin.user.update-password-iframe', ['id' => $id]);
    }

    /**
     * 功能：更新用户密码
     * author: ouhanrong
     * @param Request $request
     * @param UsersBusiness $users_business
     * @return array
     */
    public function updatePassword(Request $request, UsersBusiness $users_business)
    {
        $post_data = $request->all();

        $response = $users_business->updatePassword($post_data);

        return $this->jsonFormat($response);
    }

    /**
     * 功能：禁用，启用用户
     * author: ouhanrong
     * @param Input $input
     * @param UsersBusiness $users_business
     * @return array
     */
    public function disable(Input $input, UsersBusiness $users_business)
    {
        $post_data = $input->get();

        $response = $users_business->disableUser($post_data);

        return $this->jsonFormat($response);
    }

    /**
     * 功能：删除用户
     * author: ouhanrong
     * @param $id
     * @param UsersBusiness $users_business
     * @return array
     */
    public function destroy($id, UsersBusiness $users_business)
    {
        $response = $users_business->destoryUser($id);

        return $this->jsonFormat($response);
    }

}
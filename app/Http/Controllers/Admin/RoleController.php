<?php
/**
 * 功能：用户角色
 * author: ouhanrong
 * User: ohr445321
 * Date: 2017/2/27
 * Time: 09:10
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Role;
use Illuminate\Http\Request;
use App\Http\Business\RoleBusiness;
use App\Http\Business\PermissionsBusiness;

class RoleController extends Controller
{
    /**
     * 功能：角色列表
     * author: ouhanrong
     * @param Request $request
     * @param RoleBusiness $role_business
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, RoleBusiness $role_business)
    {
        $get_data = $request->all();

        $list_data = $role_business->getRoleList(array_merge($get_data, ['page_size' => 10, 'sort_column' => 'id', 'sort_type' => 'desc']), ['*'], []);

        return view('admin.role.index', ['data' => ['get_data' => $get_data, 'list_data' => $list_data]]);
    }

    /**
     * 功能：添加角色页面
     * author: ouhanrong
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.role.create');
    }

    /**
     * 功能：保存用户角色
     * author: ouhanrong
     * @param Request $request
     * @param RoleBusiness $role_business
     * @return array
     */
    public function store(Request $request, RoleBusiness $role_business)
    {
        $data = $request->all();

        $response = $role_business->storeRole($data);

        return $this->jsonFormat($response);
    }

    /**
     * 功能：用户角色编辑页面
     * author: ouhanrong
     * @param $id
     * @param RoleBusiness $role_business
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, RoleBusiness $role_business)
    {
        $data = $role_business->getRoleDetails($id, ['id', 'role_name', 'remark', 'is_disable']);

        return view('admin.role.edit', ['info' => $data]);
    }

    /**
     * 功能：编辑保存用户角色
     * author: ouhanrong
     * @param $id
     * @param Request $request
     * @param RoleBusiness $role_business
     * @return array
     */
    public function update($id, Request $request, RoleBusiness $role_business)
    {
        $data = $request->all();

        $response = $role_business->updateRole($id, $data);

        return $this->jsonFormat($response);
    }

    /**
     * 功能：删除用户角色
     * author: ouhanrong
     * @param $id
     * @param RoleBusiness $role_business
     * @return array
     */
    public function destroy($id, RoleBusiness $role_business)
    {
        $response = $role_business->destoryRole($id);

        return $this->jsonFormat($response);
    }

    /**
     * 功能：权限设置页面
     * author: ouhanrong
     * @param $id
     * @param RoleBusiness $role_business
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rolePermissionsIframe($id, RoleBusiness $role_business)
    {
        return view('admin.role.role-permissions-iframe', ['id' => $id]);
    }

    /**
     * 功能：ajax获取权限设置数据
     * author: ouhanrong
     * @param Request $request
     * @param RoleBusiness $role_business
     * @return array
     */
    public function ajaxGetRolePermissions(Request $request, RoleBusiness $role_business)
    {
        $id = $request->get('id');

        //获取权限列表
        $data = $role_business->getRelationRolePermissionsList($id);

        return $this->jsonFormat($data);
    }

    /**
     * 功能：ajax保存权限设置数据
     * author: ouhanrong
     * @param Request $request
     */
    public function ajaxSaveRolePermissions(Request $request)
    {
        $data = $request->all();

        dump($data);
    }

}
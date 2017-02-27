<?php
/**
 * 功能：用户权限
 * author: ouhanrong
 * User: ohr445321
 * Date: 2017/2/23
 * Time: 09:47
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exceptions\JsonException;
use Illuminate\Http\Request;
use App\Http\Business\PermissionsBusiness;
use App\Http\Common\Helper;

class PermissionsController extends Controller
{
    /**
     * 功能：权限菜单列表
     * author: ouhanrong
     * @param PermissionsBusiness $permissions_business
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(PermissionsBusiness $permissions_business)
    {
        $list_data = $permissions_business->getPermissionsList(['all' => 1, 'sort_column' => 'sort', 'sort_type' => 'asc'], ['*'], []);

        return view('admin.permissions.index', ['data' => ['list_data' => $list_data]]);
    }

    /**
     * 功能：添加权限弹框
     * author: ouhanrong
     */
    public function create(PermissionsBusiness $permissions_business)
    {
        //获取所有权限菜单
        $tree_data = $permissions_business->getPermissionsTree();

        return view('admin.permissions.create', ['permissions_tree_data' => $tree_data]);
    }

    /**
     * 功能：保存权限菜单
     * author: ouhanrong
     * @param Request $request
     * @param PermissionsBusiness $permissions_business
     * @return array]
     */
    public function store(Request $request, PermissionsBusiness $permissions_business)
    {
        $post_data = $request->all();

        $response = $permissions_business->storePermissions($post_data);

        return $this->jsonFormat($response);
    }

    /**
     * 功能：权限菜单编辑
     * author: ouhanrong
     * @param $id
     * @param PermissionsBusiness $permissions_business
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, PermissionsBusiness $permissions_business)
    {
        //获取所有权限菜单
        $tree_data = $permissions_business->getPermissionsTree();
        //获取对应id的信息
        $permissions_details = $permissions_business->getDetailsById($id, ['*']);

        return view('admin.permissions.edit', ['permissions_tree_data' => $tree_data, 'permissions_details' => $permissions_details]);
    }

    /**
     * 功能：更新权限菜单
     * author: ouhanrong
     * @param $id
     * @param Request $request
     * @param PermissionsBusiness $permissions_business
     * @return array
     */
    public function update($id, Request $request, PermissionsBusiness $permissions_business)
    {
        $data = $request->all();

        $response = $permissions_business->updatePermissions($id, $data);

        return $this->jsonFormat($response);
    }

    /**
     * 功能：通过id删除权限菜单
     * author: ouhanrong
     * @param $id
     * @param PermissionsBusiness $permissions_business
     * @return array
     */
    public function destroy($id, PermissionsBusiness $permissions_business)
    {
        $response = $permissions_business->destroyPermissions($id);

        return $this->jsonFormat($response);
    }

    /**
     * 功能：添加下级权限菜单
     * author: ouhanrong
     * @param $id
     * @param PermissionsBusiness $permissions_business
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addLevelPermissionsIframe($id, PermissionsBusiness $permissions_business)
    {
        //获取所有权限菜单
        $tree_data = $permissions_business->getPermissionsTree();

        return view('admin.permissions.add-level-permissions-iframe', ['parent_id' => $id, 'permissions_tree_data' => $tree_data]);
    }


}
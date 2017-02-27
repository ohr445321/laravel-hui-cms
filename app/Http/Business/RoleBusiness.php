<?php
/**
 * 功能：用户角色业务
 * author: ouhanrong
 * User: ohr445321
 * Date: 2017/2/27
 * Time: 09:12
 */

namespace App\Http\Business;

use App\Http\Business\Dao\PermissionsDao;
use DB;
use App\Http\Business\BusinessBase;
use App\Http\Business\Dao\RoleDao;
use App\Http\Common\Helper;

class RoleBusiness extends BusinessBase
{
    private $role_dao = null;
    private $permissions_dao = null;

    public function __construct(RoleDao $role_dao, PermissionsDao $permissions_dao)
    {
        $this->role_dao = $role_dao;
        $this->permissions_dao = $permissions_dao;
    }

    /**
     * 功能：获取角色列表数据
     * author: ouhanrong
     * @param array $condition
     * @param array $select_columns
     * @param array $relatives
     * @return mixed
     */
    public function getRoleList(array $condition = [], array $select_columns = ['*'], array $relatives = [])
    {
        $list = $this->role_dao->getRoleList($condition, $select_columns, $relatives);

        return $list;
    }

    /**
     * 功能：保存角色名称
     * author: ouhanrong
     * @param $data
     * @return mixed
     */
    public function storeRole($data)
    {
        //角色名称不能为空
        if (empty($data['role_name'])) {
            throw new JsonException(20000);
        }

        DB::beginTransaction();
        try {
            $response = $this->role_dao->storeRole($data);

            DB::commit();

            return $response;

        } catch (JsonException $e) {
            DB::rollback();

            throw new JsonException($e->getCode());
        }
    }

    /**
     * 功能：根据角色id获取对应信息
     * author: ouhanrong
     * @param $user_id
     * @param array $select_colunms
     * @return mixed
     */
    public function getRoleDetails($user_id, array $select_colunms = ['*'])
    {
        if (empty($user_id) || !is_numeric($user_id)) {
            throw new JsonException(10003);
        }

        $data = $this->role_dao->getDetails($user_id, $select_colunms);

        return $data;
    }

    /**
     * 功能：更新用户角色
     * author: ouhanrong
     * @param $id
     * @param $data
     * @return mixed
     */
    public function updateRole($id, $data)
    {
        if (empty($id) || !is_numeric($id)) {
            throw new JsonException(10003);
        }

        //角色名称不能为空
        if (empty($data['role_name'])) {
            throw new JsonException(20000);
        }

        DB::beginTransaction();
        try {
            $response = $this->role_dao->updateRole($id, $data);

            DB::commit();

            return $response;

        } catch (JsonException $e) {
            DB::rollback();

            throw new JsonException($e->getCode());
        }
    }

    /**
     * 功能：删除用户角色
     * author: ouhanrong
     * @param $id
     * @return mixed
     */
    public function destoryRole($id)
    {
        if (empty($id || !is_numeric($id))) {
            throw new JsonException(10003);
        }

        $response = $this->role_dao->destoryRole($id);

        return $response;
    }

    /**
     * 功能：获取已经关联对应用户角色的权限数据
     * author: ouhanrong
     * @param $role_id
     * @return array|static
     */
    public function getRelationRolePermissionsList($role_id)
    {
        if (empty($role_id || !is_numeric($role_id))) {
            throw new JsonException(10003);
        }

        //获取全部权限菜单
        $permissions_data = $this->permissions_dao->getPermissionsList(['all' => 1], ['id','permissions_name','parent_id','level'], []);
        $tree_data = Helper::getSubs($permissions_data->toArray(), 0, 1);

        //获取对应$role_id对应的权限菜单ids
        $role_permissions_data = $this->role_dao->getPermissionsById($role_id);
        $permissions_ids = $role_permissions_data->relationRolePermissions->map(function ($permissions) {
            return $permissions['pivot']['permissions_id'];
        });

        //权限菜单匹配对应角色是否拥有该权限
        $tree_data = collect($tree_data)->map(function ($vo) use ($permissions_ids) {
            $vo['is_select'] = 0;
            if ($permissions_ids->search($vo['id'], true) !== false) {
                $vo['is_select'] = 1;
            }
            return $vo;
        });

        return $tree_data;
    }

}
<?php
/**
 * 功能：后台用户权限
 * author: ouhanrong
 * User: ohr445321
 * Date: 2017/2/23
 * Time: 10:01
 */

namespace App\Http\Business;

use App\Http\Business\Dao\PermissionsDao;
use App\Exceptions\JsonException;
use App\Http\Common\Helper;
use DB;

class PermissionsBusiness extends BusinessBase
{
    private $permissions_dao = null;

    public function __construct(PermissionsDao $permissions_dao)
    {
        $this->permissions_dao = $permissions_dao;
    }

    /**
     * 功能：获取权限列表
     * @author:     ouhanrong
     * @param array $condition
     * @param array $select_columns
     * @param array $relatives
     * @return mixed
     */
    public function getPermissionsList(array $condition = [], array $select_columns = ['*'], array $relatives = [])
    {
        $list = $this->permissions_dao->getPermissionsList($condition, $select_columns, $relatives);

        //获取菜单名
        $permissions_data = $this->permissions_dao->getPermissionsList(['all' =>1], ['id', 'permissions_name']);
        $permissions_name = [];
        foreach ($permissions_data as $permissions) {
            $permissions_name[$permissions->id] = $permissions->permissions_name;
        }
        //初始化数据
        foreach ($list as &$vo) {
            $vo->parent_permissions_name = isset($permissions_name[$vo->parent_id]) ? $permissions_name[$vo->parent_id] : '一级菜单';
        }

        //无限极分类
        $list = Helper::getSubs($list->toArray(), 0, 1);

        return $list;
    }

    /**
     * 功能：保存权限菜单
     * author: ouhanrong
     * @param $data
     * @return mixed
     * @throws JsonException
     */
    public function storePermissions($data)
    {
        //权限菜单不能为空
        if (empty($data['permissions_name'])) {
            throw new JsonException(30001);
        }
        //路由名称不能为空
        if (empty($data['route_name'])) {
            throw new JsonException(30002);
        }
        $data['parent_id'] = empty($data['parent_id']) ? 0 : $data['parent_id'];
        $data['is_menu'] = empty($data['is_menu']) ? 0 : $data['is_menu'];
        $data['is_api'] = empty($data['is_api']) ? 0 : $data['is_api'];
        $data['sort'] = empty($data['sort']) ? 0 : $data['sort'];

        DB::beginTransaction();
        try {
            $response = $this->permissions_dao->storePermissions($data);

            DB::commit();

            return $response;

        } catch (JsonException $e) {
            DB::rollback();

            throw new JsonException($e->getCode());
        }
    }

    /**
     * 功能：更新权限菜单
     * author: ouhanrong
     * @param $id
     * @param $data
     * @return mixed
     * @throws JsonException
     */
    public function updatePermissions($id, $data)
    {
        if (empty($id) || !is_numeric($id)) {
            throw new JsonException(10003);
        }
        //权限菜单不能为空
        if (empty($data['permissions_name'])) {
            throw new JsonException(30001);
        }
        //路由名称不能为空
        if (empty($data['route_name'])) {
            throw new JsonException(30002);
        }

        $data['is_menu'] = empty($data['is_menu']) ? 0 : $data['is_menu'];
        $data['is_api'] = empty($data['is_api']) ? 0 : $data['is_api'];
        $data['sort'] = empty($data['sort']) ? 0 : $data['sort'];

        DB::beginTransaction();
        try {

            $response = $this->permissions_dao->updatePermissions($id, $data);

            DB::commit();

            return $response;

        } catch (JsonException $e) {
            DB::rollback();

            throw new JsonException($e->getCode());
        }
    }

    /**
     * 功能：删除权限管理菜单
     * author: ouhanrong
     * @param $id
     * @return mixed
     * @throws JsonException
     */
    public function destroyPermissions($id)
    {
        if (empty($id) || !is_numeric($id)) {
            throw new JsonException(10003);
        }

        DB::beginTransaction();
        try {
            //获取父级权限
            $permissions_details = $this->permissions_dao->getDetailsById($id);
            //判断是否存在子分类
            if ($permissions_details->is_final == 0) {
                throw new JsonException(30002);
            }
            //判断是否需要设置上级is_final=1
            $parent_son_count = $this->permissions_dao->getPermissionsCountById($permissions_details->parent_id);
            //需要设置上级分类的is_final=1
            if ($parent_son_count <= 1) {
                $this->permissions_dao->updateIsFinalById($permissions_details->parent_id, 1);
            }
            //删除权限菜单
            $response = $this->permissions_dao->destroyPermissions($id);

            DB::commit();

            return $response;

        } catch (JsonException $e) {
            DB::rollback();

            throw new JsonException($e->getCode());
        }

        return $response;
    }

    /**
     * 功能：获取权限菜单无限极分类
     * author: ouhanrong
     * @return array
     */
    public function getPermissionsTree()
    {
        $data = $this->permissions_dao->getPermissionsList(['all' => 1], ['id','parent_id','permissions_name','level','path_code'], []);

        $tree_data = Helper::getSubs($data->toArray(), 0, 1);

        foreach ($tree_data as &$vo) {
            $vo['permissions_name'] = str_repeat('--', $vo['level']-1) . $vo['permissions_name'];
        }

        return $tree_data;
    }

    /**
     * 功能：通过id获取对应信息
     * author: ouhanrong
     * @param $id
     * @param array $select_colunms
     * @return mixed
     * @throws JsonException
     */
    public function getDetailsById($id, array $select_colunms = ['*'])
    {
        if (empty($id) || !is_numeric($id)) {
            throw new JsonException(10003);
        }

        $data = $this->permissions_dao->getDetailsById($id, $select_colunms);

        return $data;
    }

}
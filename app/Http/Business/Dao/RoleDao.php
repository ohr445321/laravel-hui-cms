<?php
/**
 * 功能：用户角色数据获取
 * author: ouhanrong
 * User: ohr445321
 * Date: 2017/2/27
 * Time: 09:14
 */

namespace App\Http\Business\Dao;

use App;
use App\Http\Business\Dao\DaoBase;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\JsonException;

class RoleDao extends DaoBase
{
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
        $m_roles = App::make('RoleModel')->select($select_columns);

        //关键字搜索
        if (!empty($condition['keyword'])) {
            $keyword = $condition['keyword'];
            $m_roles->where(function($query) use($keyword){
                $query->where('id','like', "%$keyword%")
                    ->orWhere('role_name', 'like', "%$keyword%")
                    ->orWhere('remark', 'like', "%$keyword%");
            });
        }

        if (isset($condition['is_disable']) && is_numeric($condition['is_disable'])) {
            $m_roles->IsDisableQuery($condition['is_disable']);
        }

        //列表排序
        $sort_column = empty($condition['sort_column']) ? 'id' : $condition['sort_column'];
        $sort_type = !empty($condition['sort_type']) && in_array($condition['sort_type'], ['asc', 'desc'])? $condition['sort_type'] : 'desc';
        $m_roles->orderBy($sort_column, $sort_type);
        //分页数
        $page = !empty($condition['page_size']) ? $condition['page_size'] : 10;

        //获取全部列表信息
        if (!empty($condition['all'])) {
            return $m_roles->get();
        }

        return $m_roles->paginate($page);
    }

    /**
     * 功能：通过$role_id 获取对应所属的用户权限
     * author: ouhanrong
     * @param $role_id
     * @return mixed
     */
    public function getPermissionsById($role_id)
    {
        $role_permissions_data = App::make('RoleModel')->select(['id'])->find($role_id)->load(['relationRolePermissions' => function ($query) {
            $query->select(['permissions_name']);
        }]);

        return $role_permissions_data;
    }

    /**
     * 功能：
     * author: ouhanrong
     * @param array $data
     * @return mixed
     * @throws JsonException
     */
    public function storeRole(array $data)
    {
        $validator = Validator::make($data, [
            'role_name' => 'required',
            'is_disable' => ['required', 'int'],
        ]);
        if ($validator->fails()) {
            throw new JsonException(10000, $validator->messages());
        }

        $m_roles = App::make('RoleModel');

        $m_roles->role_name = $data['role_name'];
        $m_roles->remark = empty($data['remark']) ? '' : $data['remark'];
        $m_roles->is_disable = !empty($data['is_disable']) ? 1 : 0;
        $m_roles->create_time = date('YmdHis');

        if (!$m_roles->save()) {
            throw new JsonException(10004);
        }

        return $m_roles;
    }

    /**
     * 功能：通过角色id获取对应角色信息
     * author: ouhanrong
     * @param $id
     * @param array $select_columns
     * @return mixed
     * @throws JsonException
     */
    public function getDetails($id, array $select_columns = ['*'])
    {
        $check = [
            'id' => ['required', 'int']
        ];
        $validator = Validator::make([
            'id' => $id
        ], $check);
        if ($validator->fails()) {
            throw new JsonException('10000', $validator->messages());
        }

        $data = App::make('RoleModel')->select($select_columns)->IdQuery($id)->first();

        return $data;
    }

    /**
     * 功能：更新用户角色
     * author: ouhanrong
     * @param $id
     * @param array $data
     * @return mixed
     * @throws JsonException
     */
    public function updateRole($id, array $data)
    {
        $data['id'] = $id;
        $validator = Validator::make($data, [
            'id' => ['required', 'int'],
            'role_name' => ['required'],
            'is_disable' => ['required', 'int'],
        ]);
        if ($validator->fails()) {
            throw new JsonException(10000, $validator->messages());
        }

        $m_roles = App::make('RoleModel')->find($id);

        $m_roles->role_name = $data['role_name'];
        $m_roles->remark = empty($data['remark']) ? '' : $data['remark'];
        $m_roles->is_disable = !empty($data['is_disable']) ? 1 : 0;
        $m_roles->update_time = date('YmdHis');

        if (!$m_roles->save()) {
            throw new JsonException(10004);
        }

        return $m_roles;
    }

    /**
     * 功能：删除用户角色
     * author: ouhanrong
     * @param $id
     * @return mixed
     * @throws JsonException
     */
    public function destoryRole($id)
    {
        $vaildator = Validator::make(['id' => $id], ['id' => ['required', 'int']]);

        if ($vaildator->fails()) {
            throw new JsonException(10000, $vaildator->messages());
        }

        $m_roles = App::make('RoleModel')->find($id);

        if (!$m_roles->delete()) {
            throw new JsonException(10004);
        }

        return $m_roles;
    }

    /**
     * 功能：保存维护relation_role_permissions中间边关系
     * author: ouhanrong
     * @param $data
     * @return mixed
     * @throws JsonException
     */
    public function saveRolePermissions($data)
    {
        $vaildator = Validator::make(['role_id' => $data['role_id']], ['role_id' => ['required', 'int']]);

        if ($vaildator->fails()) {
            throw new JsonException(10000, $vaildator->messages());
        }

        $data['permissions_ids'] = empty($data['permissions_ids']) ? [] : $data['permissions_ids'];

        $m_roles = App::make('RoleModel')->find($data['role_id']);

        //维护relation_role_permissions中间表
        $m_roles->relationRolePermissions()->sync($data['permissions_ids']);
        
        return $m_roles;
    }
}
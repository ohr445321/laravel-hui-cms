<?php
/**
 * 功能：
 * author: ouhanrong
 * User: ohr445321
 * Date: 2017/2/23
 * Time: 10:03
 */

namespace App\Http\Business\Dao;

use App;
use DB;
use App\Http\Common\Helper;
use App\Exceptions\JsonException;
use Illuminate\Support\Facades\Validator;

class PermissionsDao extends DaoBase
{
    /**
     * 功能：删除权限
     * author: ouhanrong
     * @param $id
     * @return mixed
     * @throws JsonException
     */
    public function destroyPermissions($id)
    {
        $vaildator = Validator::make(['id' => $id], ['id' => ['required', 'int']]);

        if ($vaildator->fails()) {
            throw new JsonException(10000, $vaildator->messages());
        }

        $permissions_model = App::make('PermissionsModel')->find($id);

        if (!$permissions_model->delete()) {
            throw new JsonException(10004);
        }

        return $permissions_model;
    }

    /**
     * 功能：修改权限
     * author: ouhanrong
     * @param $id
     * @param $data
     * @return mixed
     * @throws JsonException
     */
    public function updatePermissions($id, array $data)
    {
        $data['id'] = $id;
        $validator = Validator::make($data, [
            'id' => ['required', 'int'],
            'route_name' => ['required'],
            'permissions_name' => ['required'],
            'is_menu' => [ 'numeric'],
            'is_api' => ['numeric'],
            'sort' => ['required', 'int']
        ]);
        if ($validator->fails()) {
            throw new JsonException(10000, $validator->messages());
        }

        $permissions_model = App::make('PermissionsModel')->find($id);

        $permissions_model->route_name = $data['route_name'];
        $permissions_model->permissions_name = $data['permissions_name'];
        $permissions_model->is_menu = $data['is_menu'];
        $permissions_model->is_api = $data['is_api'];
        $permissions_model->sort = $data['sort'];

        if (!$permissions_model->save()) {
            throw new JsonException(10004);
        }

        return $permissions_model;
    }

    /**
     * 功能：添加权限
     * @author:     ouhanrong
     * @param $data
     * @return mixed
     * @throws JsonException
     */
    public function storePermissions(array $data)
    {
        $validator = Validator::make($data, [
            'parent_id' => [ 'numeric'],
            'route_name' => ['required'],
            'permissions_name' => ['required'],
            'is_menu' => [ 'numeric'],
            'is_api' => ['numeric'],
            'sort' => ['required', 'int']
        ]);
        if ($validator->fails()) {
            throw new JsonException(10000, $validator->messages());
        }

        $permissions_model = App::make('PermissionsModel');

        $permissions_model->parent_id = $data['parent_id'];
        $permissions_model->route_name = $data['route_name'];
        $permissions_model->permissions_name = $data['permissions_name'];
        $permissions_model->level = $data['level'] + 1;
        $permissions_model->is_menu = $data['is_menu'];
        $permissions_model->is_api = $data['is_api'];
        $permissions_model->is_final = 1;  //默认新增的都是最后分类
        $permissions_model->sort = $data['sort'];
        $permissions_model->create_time = date('YmdHis');

        if (!$permissions_model->save()) {
            throw new JsonException(10004);
        }

        //更新path_code字段
        $permissions_model->path_code = Helper::getPermissionsPathCode($permissions_model->id, $data['parent_path_code'], $data['level']);

        //更新上级分类is_final=0
        if (!empty($data['parent_id'])) {
            $this->updateIsFinalById($data['parent_id'], 0);
        }

        if (!$permissions_model->save()) {
            throw new JsonException(10004);
        }

        return $permissions_model;
    }

    /**
     * 功能：根据permissions_id 更新 is_final 字段
     * author: ouhanrong
     * @param $id
     * @return mixed
     * @throws JsonException
     */
    public function updateIsFinalById($id, $value = 0)
    {
        $validator = Validator::make(['id' => $id], ['id' => ['required', 'int']]);
        if ($validator->fails()) {
            throw new JsonException(10000, $validator->messages());
        }

        $permissions_model = App::make('PermissionsModel')->find($id);

        $permissions_model->is_final = $value;

        if (!$permissions_model->save()) {
            throw new JsonException(10004);
        }

        return $permissions_model;
    }

    /**
     * 功能：通过id获取对应权限信息
     * @author:     ouhanrong
     * @param $id
     * @param array $select_columns
     * @return mixed
     * @throws JsonException
     */
    public function getDetailsById($id, array $select_columns = ['*'])
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

        $data = App::make('PermissionsModel')->select($select_columns)->IdQuery($id)->first();

        return $data;
    }

    /**
     * 功能：获取权限列表
     * author: ouhanrong
     * @param array $condition
     * @param array $select_columns
     * @param array $relatives
     * @return mixed
     */
    public function getPermissionsList(array $condition = [], array $select_columns = ['*'], $relatives = [])
    {
        $m_permissions = App::make('PermissionsModel')->select($select_columns);

        //列表排序
        $sort_column = empty($condition['sort_column']) ? 'id' : $condition['sort_column'];
        $sort_type = !empty($condition['sort_type']) && in_array($condition['sort_type'], ['asc', 'desc'])? $condition['sort_type'] : 'desc';
        $m_permissions->orderBy($sort_column, $sort_type);
        //分页数
        $page = !empty($condition['page_size']) ? $condition['page_size'] : 10;

        //获取全部列表信息
        if (!empty($condition['all'])) {
            return $m_permissions->get();
        }

        return $m_permissions->paginate($page);
    }

    /**
     * 功能：获取下级分类数量
     * author: ouhanrong
     * @param $parent_id
     * @return int
     */
    public function getPermissionsCountById($parent_id)
    {
        $count = App::make('PermissionsModel')->where('parent_id', $parent_id)->count();

        return empty($count) ? 0 : $count;
    }
}
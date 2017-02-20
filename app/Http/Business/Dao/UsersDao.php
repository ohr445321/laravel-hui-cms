<?php
/**
 * @author:    ouhanrong
 * Created by PhpStorm.
 * User: ohr
 * Date: 2017/1/11
 * Time: 15:27
 */

namespace App\Http\Business\Dao;

use Illuminate\Support\Facades\App;
use App\Http\Common\Helper;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\JsonException;
use Exception;

class UsersDao extends DaoBase
{
    /**
     * 功能：删除用户
     * author: ouhanrong
     * @param $id
     * @return mixed
     * @throws JsonException
     */
    public function deleteUser($id)
    {
        $vaildator = Validator::make(['id' => $id], ['id' => ['required', 'int']]);

        if ($vaildator->fails()) {
            throw new JsonException(10000, $vaildator->messages());
        }

        $users_model = App::make('UsersModel')->find($id);

        if (!$users_model->delete()) {
            throw new JsonException(10004);
        }

        return $users_model;
    }

    /**
     * 功能：禁用，启用用户
     * author: ouhanrong
     * @param $data
     * @return mixed
     * @throws JsonException
     */
    public function disabledUser($data)
    {
        $check = [
            'id' => ['required', 'int'],
            'is_disable' => ['required', 'int']
        ];
        $validator = Validator::make($data, $check);
        if ($validator->fails()) {
            throw new JsonException(10000, $validator->messages());
        }

        $users_model = App::make('UsersModel')->find($data['id']);

        $users_model->is_disable = $data['is_disable'];

        if (!$users_model->save()) {
            throw new JsonException(10004);
        }

        return $users_model;
    }

    /**
     * 功能：修改用户
     * author: ouhanrong
     * @param $id
     * @param $data
     * @return mixed
     * @throws JsonException
     */
    public function updateUser($id, $data)
    {
        $data['user_id'] = $id;
        $validator = Validator::make($data, [
            'user_id' => ['required', 'int'],
            'user_name' => ['required'],
            'password' => ['required'],
        ]);
        if ($validator->fails()) {
            throw new JsonException(10000, $validator->messages());
        }

        $users_model = App::make('UsersModel')->find($id);

        $users_model->username = $data['user_name'];
        $users_model->password = $data['password'];
        if (!$users_model->save()) {
            throw new JsonException(10004);
        }

        return $users_model;
    }

    /**
     * 功能：添加保存用户
     * @author:     ouhanrong
     * @param $data
     * @return mixed
     * @throws JsonException
     */
    public function storeUser($data)
    {
        $validator = Validator::make($data, [
            'user_name' => 'required',
            'password' => 'required',
            'salt' => 'required',
        ]);
        if ($validator->fails()) {
            throw new JsonException(10000, $validator->messages());
        }

        $users_model = App::make('UsersModel');

        $users_model->username = $data['user_name'];
        $users_model->password = $data['password'];
        $users_model->salt = $data['salt'];

        if (!$users_model->save()) {
            throw new JsonException(10004);
        }

        return $users_model;
    }

    /**
     * 功能：通过id获取对应用户信息
     * @author:     ouhanrong
     * @param $user_id
     * @param array $select_columns
     * @return mixed
     * @throws JsonException
     */
    public function getDetails($user_id, array $select_columns = ['*'])
    {
        $check = [
            'user_id' => ['required', 'int']
        ];
        $validator = Validator::make([
            'user_id' => $user_id
        ], $check);
        if ($validator->fails()) {
            throw new JsonException('10000', $validator->messages());
        }

        $user_data = App::make('UsersModel')->select($select_columns)->UserIdQuery($user_id)->first();

        return $user_data;
    }

    /**
     * 功能：获取用户列表信息
     * author: ouhanrong
     * @param array $condition
     * @param array $select_columns
     * @param array $relatives
     * @return mixed
     * @throws JsonException
     */
    public function getUsersList(array $condition = [], array $select_columns = ['*'], array $relatives = [])
    {
        $m_users = App::make('UsersModel')->select($select_columns);

        //列表排序
        $sort_column = empty($condition['sort_column']) ? 'id' : $condition['sort_column'];
        $sort_type = !empty($condition['sort_type']) && in_array($condition['sort_type'], ['asc', 'desc'])? $condition['sort_type'] : 'desc';
        $m_users->orderBy($sort_column, $sort_type);
        //分页数
        $page = !empty($condition['page']) ? $condition['page'] : 10;

        //获取全部列表信息
        if (!empty($condition['all'])) {
            return $m_users->get();
        }

        return $m_users->paginate($page);
    }
}
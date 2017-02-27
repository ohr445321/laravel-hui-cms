<?php
/**
 * @author:    ouhanrong
 * Created by PhpStorm.
 * User: ohr
 * Date: 2017/1/11
 * Time: 15:25
 */

namespace App\Http\Business;

use App\Exceptions\JsonException;
use App\Http\Business\Dao\UsersDao;
use App\Http\Common\Helper;
use DB;

class UsersBusiness extends BusinessBase
{
    private $users_dao = null;

    public function __construct(UsersDao $users_dao)
    {
        $this->users_dao = $users_dao;
    }

    /**
     * 功能：删除用户
     * author: ouhanrong
     * @param $id
     * @return mixed
     * @throws JsonException
     */
    public function destoryUser($id)
    {
        if (empty($id || !is_numeric($id))) {
            throw new JsonException(10003);
        }

        $response = $this->users_dao->deleteUser($id);

        return $response;
    }

    /**
     * 功能：禁用，启用用户
     * author: ouhanrong
     * @param $data
     * @return mixed
     * @throws JsonException
     */
    public function disableUser($data)
    {
        if (empty($data['id'] || !is_numeric($data['id']))) {
            throw new JsonException(10003);
        }
        //禁用还是启用
        $data['is_disable'] = intval($data['is_disable']) == 0 ? 1 : 0;

        $response = $this->users_dao->disabledUser($data);

        return $response;
    }

    /**
     * 功能：更新用户密码
     * author: ouhanrong
     * @param $data
     * @return mixed
     * @throws JsonException
     */
    public function updatePassword($data)
    {
        if (empty($data['user_id']) || !is_numeric($data['user_id'])) {
            throw new JsonException(10003);
        }
        //密码不能为空
        if (empty($data['password'])) {
            throw new JsonException(20001);
        }
        //原始密码不能为空
        if (empty($data['old-password'])) {
            throw new JsonException(20004);
        }
        //确认密码不能为空
        if (empty($data['re-password'])) {
            throw new JsonException(20002);
        }
        //是否密码一致
        if ($data['password'] != $data['re-password']) {
            throw new JsonException(20003);
        }
        //原始密码是否正确
        $user_data = $this->users_dao->getDetails($data['user_id'], ['salt', 'password']);
        if (!Helper::checkEncryptPwd($user_data['password'], $data['old-password'], $user_data['salt'])) {
            throw new JsonException(20005);
        }

        //新密码加密
        $data['password'] = Helper::getEncryptPwd($data['password'], $user_data['salt']);

        $response = $this->users_dao->updatePassword($data);

        return $response;

    }

    /**
     * 功能：更新用户信息
     * author: ouhanrong
     * @param $id
     * @param $data
     * @return mixed
     * @throws JsonException
     */
    public function updateUser($id, $data)
    {
        if (empty($id) || !is_numeric($id)) {
            throw new JsonException(10003);
        }

        //用户名不能为空
        if (empty($data['user_name'])) {
            throw new JsonException(20000);
        }
        if (!preg_match('/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/', $data['email'])) {
            throw new JsonException(20006);
        }
        //判断用户是否存在
        $this->users_dao->isHasUsername($data['user_name']);

        DB::beginTransaction();
        try {
            $response = $this->users_dao->updateUser($id, $data);

            DB::commit();

            return $response;

        } catch (JsonException $e) {
            DB::rollback();

            throw new JsonException($e->getCode());
        }
    }

    /**
     * 功能：通过user_id 获取用户信息
     * author: ouhanrong
     * @param $user_id
     * @param array $select_colunms
     * @return mixed
     * @throws JsonException
     */
    public function getUserDetails($user_id, array $select_colunms = ['*'])
    {
        if (empty($user_id) || !is_numeric($user_id)) {
            throw new JsonException(10003);
        }

        $data = $this->users_dao->getDetails($user_id, $select_colunms);

        return $data;
    }

    /**
     * 功能：保存用户
     * @author:     ouhanrong
     * @param $data
     * @return mixed
     * @throws JsonException
     */
    public function storeUser($data)
    {
        //用户名不能为空
        if (empty($data['user_name'])) {
            throw new JsonException(20000);
        }
        //密码不能为空
        if (empty($data['password'])) {
            throw new JsonException(20001);
        }
        //确认密码不能为空
        if (empty($data['re-password'])) {
            throw new JsonException(20002);
        }
        //是否密码一致
        if ($data['password'] != $data['re-password']) {
            throw new JsonException(20003);
        }
        if (!preg_match('/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/', $data['email'])) {
            throw new JsonException(20006);
        }
        //判断用户是否存在
        $this->users_dao->isHasUsername($data['user_name']);

        $salt = mt_rand(1000, 9999);

        $data['salt'] = $salt;

        $data['password'] = Helper::getEncryptPwd($data['password'], $salt);

        DB::beginTransaction();
        try {
            $response = $this->users_dao->storeUser($data);

            DB::commit();

            return $response;

        } catch (JsonException $e) {
            DB::rollback();

            throw new JsonException($e->getCode());
        }
    }

    /**
     * 功能：获取用户列表信息
     * @author:     ouhanrong
     * @param array $condition
     * @param array $select_columns
     * @param array $relatives
     * @return mixed
     */
    public function getUsersList(array $condition = [], array $select_columns = ['*'], array $relatives = [])
    {
        $list = $this->users_dao->getUsersList($condition, $select_columns, $relatives);

        return $list;
    }

}
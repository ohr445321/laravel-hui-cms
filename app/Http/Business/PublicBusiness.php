<?php
/**
 * @author:    ouhanrong
 * Created by PhpStorm.
 * User: ohr
 * Date: 2017/2/21
 * Time: 15:25
 */

namespace App\Http\Business;

use App\Exceptions\JsonException;
use App\Http\Business\Dao\UsersDao;
use App\Http\Common\Helper;
use DB;

class PublicBusiness extends BusinessBase
{
    private $users_dao = null;

    public function __construct(UsersDao $users_dao)
    {
        $this->users_dao = $users_dao;
    }

    /**
     * 功能：检测用户登陆
     * author: ouhanrong
     * @param $data
     * @return array
     * @throws JsonException
     */
    public function checkLogin($data)
    {
        if (empty($data['username'])) {
            throw new JsonException(40003);
        }
        if (empty($data['password'])) {
            throw new JsonException(40004);
        }

        //根据用户名获取用户信息
        $user_data = $this->users_dao->getDetailsByUsername($data['username'], ['*']);

        //是否存在该用户
        if (empty($user_data)) {
            throw new JsonException(40000);
        }
        //判断用户状态是否被禁用
        if ($user_data['is_disable'] == 1) {
            throw new JsonException(40002);
        }
        //判断密码是否正确
        if (!Helper::checkEncryptPwd($user_data->password, $data['password'], $user_data->salt)) {
            throw new JsonException(40001);
        }

        //保存用户信息到session
        $session_data = [
            'user_id' => $user_data->id,
            'username' => $user_data->username,
            'role_id' => $user_data->role_id,
        ];
        session([config('site.user_session_key') => $session_data]);

        return $session_data;
    }

}
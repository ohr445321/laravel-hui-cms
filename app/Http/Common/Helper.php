<?php

namespace App\Http\Common;

use App\Exceptions\JsonException;

/**
 * @author:    ouhanrong
 * 功能：公用模块
 * Class Helper
 * @package App\Http\Common
 */
class Helper
{
    /**
     * 功能：密码加密
     * @author:     ouhanrong
     * @param $password
     * @param $salt
     * @return string
     */
    public static function getEncryptPwd($password, $salt)
    {
        $encrypt_pwd = md5($salt.md5($password));
        
        return $encrypt_pwd;
    }

    /**
     * 功能：验证密码是否正确
     * @author:     ouhanrong
     * @param $encrypt_password
     * @param $password
     * @param $salt
     * @return bool
     */
    public static function checkEncryptPwd($encrypt_password, $password, $salt)
    {
        return md5($salt.md5($password)) == $encrypt_password;
    }


}

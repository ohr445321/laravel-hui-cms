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

    /**
     * 功能：获取权限菜单path_code
     * author: ouhanrong
     * @param $permissions_id
     * @param $patent_path_code
     * @param $level
     * @return string
     */
    public static function getPermissionsPathCode($permissions_id, $patent_path_code, $level)
    {
        if (empty($level)) {
            return $permissions_id;
        }

        return $patent_path_code . '|' . $permissions_id;
    }

    /**
     * 功能：获取某个分类的所有子分类
     * author: ouhanrong
     * @param $categorys
     * @param int $cat_id
     * @param int $level
     * @return array
     */
    public static function getSubs($categorys, $cat_id=0, $level=1){
        $subs = array();
        foreach ($categorys as $item) {
            if ($item['parent_id'] == $cat_id) {
                $item['level'] = $level;
                $subs[] = $item;
                $subs = array_merge($subs, self::getSubs($categorys, $item['id'], $level+1));
            }
        }
        return $subs;
    }
}

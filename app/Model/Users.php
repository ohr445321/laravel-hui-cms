<?php
/**
 * @author:    ouhanrong
 * Created by PhpStorm.
 * User: ohr
 * Date: 2017/1/10
 * Time: 9:45
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Model
{
    //使用软连接
    use SoftDeletes;

    //关联到的数据库表
    protected $table = 'users';

    /***************************************常用查询条件**************************/

    /**
     * 功能：通过id查询
     * author: ouhanrong
     * @param $query
     * @param $user_id
     * @return mixed
     */
    public function scopeUserIdQuery($query, $user_id)
    {
        return $query->where('id', $user_id);
    }

    /**
     * 功能：通过username查询
     * author: ouhanrong
     * @param $query
     * @param $username
     * @return mixed
     */
    public function scopeUsernameQuery($query, $username)
    {
        return $query->where('username', $username);
    }

    /**
     * 功能：通过email查询
     * author: ouhanrong
     * @param $query
     * @param $email
     * @return mixed
     */
    public function scopeEmailQuery($query, $email)
    {
        return $query->where('email', $email);
    }

    /**
     * 功能：获取记录创建时间
     * author: ouhanrong
     * @param $value
     * @return false|string
     */
    public function getCreateTimeAttribute($value)
    {
        return date('Y-m-d H:i', strtotime($value));
    }

}
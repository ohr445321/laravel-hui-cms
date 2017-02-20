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
use Carbon\Carbon;

class Users extends Model
{
    //使用软连接
    use SoftDeletes;

    //关联到的数据库表
    protected $table = 'users';

    //created_at, updated_at 的时间格式
    protected $dateFormat = 'U';

    /***************************************常用查询条件**************************/

    /**
     * 功能：通过id查询
     * @author:     ouhanrong
     * @param $query
     * @param $user_id
     * @return mixed
     */
    public function scopeUserIdQuery($query, $user_id)
    {
        return $query->where('id', $user_id);
    }

}
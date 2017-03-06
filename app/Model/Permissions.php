<?php
/**www
 * 功能：用户权限
 * author: ouhanrong
 * User: ohr445321
 * Date: 2017/2/23
 * Time: 10:05
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permissions extends Model
{
    //使用软连接
    use SoftDeletes;

    //关联到的数据库表
    protected $table = 'permissions';

    /***************************************常用查询条件**************************/

    /**
     * 功能：通过id查询
     * author: ouhanrong
     * @param $query
     * @param $value
     * @return mixed
     */
    public function scopeIdQuery($query, $value)
    {
        return $query->where('id', $value);
    }

    public function scopeIsMenu($query, $value)
    {
        return $query->where('is_menu', $value);
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
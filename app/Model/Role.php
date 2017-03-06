<?php
/**
 * 功能：用户角色模型
 * author: ouhanrong
 * User: ohr445321
 * Date: 2017/2/23
 * Time: 10:05
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    //使用软连接
    use SoftDeletes;

    //关联到的数据库表
    protected $table = 'roles';

    /***************************************常用查询条件**************************/

    /**
     * 功能：通过id查询
     * author: ouhanrong
     * @param $query
     * @param $id
     * @return mixed
     */
    public function scopeIdQuery($query, $id)
    {
        return $query->where('id', $id);
    }

    public function scopeIsDisableQuery($query, $value)
    {
        return $query->where('is_disable', $value);
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

    /***************************************关联关系**************************/

    public function relationRolePermissions()
    {
        return $this->belongsToMany(__NAMESPACE__.'\Permissions', 'relation_role_permissions', 'role_id', 'permissions_id')->withTimestamps();
    }


}
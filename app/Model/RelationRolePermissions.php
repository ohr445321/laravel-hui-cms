<?php
/**
 * 功能：用户角色-权限关系模型
 * author: ouhanrong
 * User: ohr445321
 * Date: 2017/2/23
 * Time: 10:05
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelationRolePermissions extends Model
{
    //使用软连接
    use SoftDeletes;

    //关联到的数据库表
    protected $table = 'relation_role_permissions';

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

    /***************************************关联关系**************************/


}
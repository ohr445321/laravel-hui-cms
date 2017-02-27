<?php
/**
 * 功能：用户角色
 * author: ouhanrong
 * User: ohr445321
 * Date: 2017/2/23
 * Time: 10:05
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //使用软连接
    use SoftDeletes;

    //关联到的数据库表
    protected $table = 'role';

    /***************************************常用查询条件**************************/


}
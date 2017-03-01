<?php
/**
 * 功能：
 * author: ouhanrong
 * User: ohr445321
 * Date: 2017/2/28
 * Time: 15:44
 */

namespace App\Model;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class AdminLog extends Eloquent
{
    //使用软连接
    use SoftDeletes;

    //连接数据库类型
    protected $connection = 'mongodb';

    //连接数据库名称
    protected $table = 'admin_log';


}
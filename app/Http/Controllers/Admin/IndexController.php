<?php
/**
 * Created by PhpStorm.
 * User: ohr
 * Date: 2016/12/6
 * Time: 18:13
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * author: ouhanrong
     * 功能：后台首页
     */
    public function Index()
    {
//        dd('>>>>>>>>>>>>');exit();
        return view('admin.index.index');
    }
}
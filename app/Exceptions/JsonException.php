<?php
namespace App\Exceptions;

use Exception;

/**
 * 错误提示
 * @create 2016-07-27
 * @auth chentengfeng
 */
class JsonException extends Exception
{
    /**
     * 错误码列表
     * 10000 - 19999 基本错误
     */
    protected $code_list = [

        /*--- UserController错误提示 ---*/
        '20000' => [
            'msg' => '用户名不能为空',
        ],
        '20001' => [
            'msg' => '密码不能为空',
        ],
        '20002' => [
            'msg' => '确认密码不能为空',
        ],
        '20003' => [
            'msg' => '密码不一致',
        ],
        '20004' => [
            'msg' => '原始密码不能为空',
        ],
        '20005' => [
            'msg' => '原始密码不正确',
        ],

        /*---基本错误 start-----*/
        10000 => [
            'msg' => '参数错误',
        ],
        10001 => [
            'msg' => '系统内部错误!'
        ],
        10002 => [
            'msg' => '请确认是否已经开启数据库事务！',
        ],
        10003 => [
            'msg' => '非法操作！',
        ],
        10004 => [
            'msg' => '操作失败！',
        ],
        11000 => [
            'msg' => '手机号码不合法！',
        ],
        11001 => [
            'msg' => '邮箱不合法！',
        ],
        12000 => [
            'msg' => '您没有权限执行该操作！',
        ],
        12001 => [
            'msg'   =>  '请先登录!'
        ],
        /*---基本错误 end-----*/
    ];
    
    
    /**
     * 构造函数
     */
    public function __construct($code, $data = [])
    {
        $this->code = $code;
        $this->data = $data;
    }
    
    
    /**
     * 获取错误信息
     */
    public function getErrorMsg()
    {
        $re = [
            'code' => 10000,
            'msg' => $this->code_list[10000]['msg'],
            'data' => '',
        ];
        if (empty($this->code_list[$this->code])) {
            return $re;
        }
        
        $re['code'] = $this->code;
        $re['msg'] = $this->code_list[$this->code]['msg'];
        $re['data'] = $this->data;
        
        return $re;
    }
}

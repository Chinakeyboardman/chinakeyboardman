<?php
/**
 * author: Administrator.
 * createTime: 2018/1/28 13:49
 * description:
 */

namespace app\common\validate;


use think\Validate;

class User extends Validate{
    protected $rule=[

        'username'=>'require|max:25',
        'password'=>'require',
        'repassword'=>'require',
        'email'=>'email',
        'verifycode'=>'require',
    ];
    //场景设置
    protected $scene=[
        'add'=>['username','password'],//申请入驻
        'register'=>['username','password','repassword','email','verifycode'],//前台用户注册
        'login'=>['username','password'],//登录
    ];
}
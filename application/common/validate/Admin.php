<?php
/**
 * Created by PhpStorm.
 * User: TAHUN
 * Date: 2019/12/5
 * Time: 18:38
 */

namespace app\common\validate;

use think\Validate;

class Admin extends Validate
{
    //默认验证器,通用
    protected $rule=[
        //验证不为空的规则require,其他规则如alpha...
        'username|管理员账户'=>'require',
        'password|管理员密码'=>'require',
        'conpass|确认密码'=>'require|confirm:password',
        'nickname|昵称'=>'require',
        'email|邮箱'=>'require|email|unique:admin',
        'code|验证码'=>'require',
    ];

    //登录验证场景
    public function sceneLogin(){
        //only指定验证字段的函数
        return $this->only(['username','password']);
    }

    //注册场景验证
    public function sceneRegister(){
        return $this->only(['username','password','conpass','nickname','email'])
            ->append('username','unique:admin');
    }

    //重置密码验证场景
    public function sceneReset(){
        return $this->only(['code','password','conpass']);
    }




}
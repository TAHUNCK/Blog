<?php
/**
 * Created by PhpStorm.
 * User: TAHUN
 * Date: 2019/12/7
 * Time: 22:52
 */

namespace app\common\validate;


use think\Validate;

class Member extends Validate
{
    protected $rule=[
        'username|用户名'=>'require|unique:member',
        'password|密码'=>'require',
        'conpass|确认密码' => 'require',
        'nickname|昵称'=>'require',
        'email|邮箱'=>'require|email|unique:member',
        'oldpass|原密码'=>'require',
        'newpass|新密码' => 'require',
        'verify|验证码' => 'require|captcha'
    ];

    //添加场景
    public function sceneAdd(){
        return $this->only(['username','password','nickname','email']);
    }

    //会员编辑
    public function sceneEdit(){
        return $this->only(['oldpass','newpass','nickname']);
    }

    //注册场景
    public function sceneRegister()
    {
        return $this->only(['username', 'password', 'conpass', 'nickname', 'email', 'verify']);
    }

    //登录场景
    public function sceneLogin()
    {
        return $this->only(['username', 'password', 'verify'])
            ->remove('username', 'unique');
    }


}
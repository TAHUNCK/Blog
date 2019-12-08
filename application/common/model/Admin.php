<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;


class Admin extends Model
{
    //使用软删除
    use SoftDelete;

    //只读字段
    protected $readonly =['email','username'];

    //登录校验
    public function login($data){
        //为了区分，直接使用命名空间
        $validate=new \app\common\validate\Admin();
        //验证用户名和密码是否存在
        if(!$validate->scene('login')->check($data)){
            //验证未通过，返回错误信息
            return $validate->getError();
        }
        //查询一条结果
        $result=$this->where($data)->find();
        if($result){
            //判断用户是否可用
            if($result['status']!=1){
                return '此账户已被禁用';
            }
            //注入session
            $sessionData=[
                'id'=>$result['id'],
                'nickname'=>$result['nickname'],
                'is_super'=>$result['is_super']
            ];

            session('admin',$sessionData);

            //1表示用户名和密码正确
            return 1;
        }else{
            return '用户名或密码错误';
        }
    }

    //注册账户
    public function register($data){
        $validate=new \app\common\validate\Admin();
        //自定义注册场景验证器，5.1版本可用
        if(!$validate->scene('register')->check($data)){
            return $validate->getError();
        }
        //unset去除无用字段,allowField不允许插入数据库中没有的字段
        //unset($data['conpass']);
        //直接保存不需要查询
        $result=$this->allowField(true)->save($data);
        if($result){
            mailTo($data['email'],'注册管理员账户成功','注册管理员账户成功');
            return 1;
        }else{
            return '注册失败';
        }
    }

    //重置密码
    public function reset($data){
        $validate=new \app\common\validate\Admin();
        if(!$validate->scene('reset')->check($data)){
            return $validate->getError();
        }
        if($data['code']!=session('code')){
            return '验证码不正确';
        }
        $adminInfo=$this->where('email',$data['email'])->find();
        $adminInfo->password=$data['password'];
        $result=$adminInfo->save();
        if($result){
            return 1;
        }else{
            return '重置密码失败';
        }

    }

    //添加管理员
    public function add($data){
        $validate=new \app\common\validate\Admin();
        if(!$validate->scene('add')->check($data)){
            return $validate->getError();
        }
        $result=$this->allowField(true)->save($data);
        if($result){
            return 1;
        }else{
            return '管理员添加失败';
        }
    }

    //编辑管理员
    public function edit($data){
        $validate= new \app\common\validate\Admin();
        if(!$validate->scene('edit')->check($data)){
            return $validate->getError();
        }
        $adminInfo=$this->find($data['id']);
        if($data['oldpass']!=$adminInfo['password']){
            return '原密码错误';
        }
        $adminInfo->password=$data['newpass']?$data['newpass']:$adminInfo->password;
        $adminInfo->nickname=$data['nickname'];
        $result=$adminInfo->save();
        if($result){
            return 1;
        }else{
            return '管理员修改失败';
        }
    }

}

<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Member extends Model
{
    //软删除
    use SoftDelete;

    //只读字段
    protected $readonly=['username','email'];

    //关联评论模型
    public function comments()
    {
        return $this->hasMany('Comment','member_id','id');
    }

    //会员添加
    public function add($data){
        $validate =new \app\common\validate\Member();
        if(!$validate->scene('add')->check($data)){
            return $validate->getError();
        }
        $result=$this->allowField(true)->save($data);
        if($result){
            return 1;
        }else{
            return '会员添加失败';
        }

    }

    //会员编辑
    public function edit($data){
        $validate=new \app\common\validate\Member();
        if(!$validate->scene('edit')->check($data)){
            return $validate->getError();
        }
        $memberInfo=$this->find($data['id']);
        if($data['oldpass']!=$memberInfo['password']){
            return '原密码输入错误';
        }
        $memberInfo->password=$data['newpass'];
        $memberInfo->nickname=$data['nickname'];
        $result=$memberInfo->save();
        if($result){
            return 1;
        }else{
            return '会员编辑失败';
        }

    }

    //会员注册
    public function register($data)
    {
        $validate = new \app\common\validate\Member();
        if (!$validate->scene('register')->check($data)) {
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        } else {
            return '注册失败';
        }

    }

    //会员登录
    public function login($data)
    {
        $validate = new \app\common\validate\Member();
        if (!$validate->scene('login')->check($data)) {
            return $validate->getError();
        }
        //先去除验证码再查询
        unset($data['verify']);
        $result = $this->where($data)->find();
        if ($result) {
            $sessionData = [
                'id' => $result['id'],
                'nickname' => $result['nickname']
            ];
            session('index', $sessionData);
            return 1;
        } else {
            return '用户名或密码错误';
        }
    }


}

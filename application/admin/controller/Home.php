<?php

namespace app\admin\controller;

use think\Controller;

class Home extends Base
{
    //后台首页
    public function index(){
        return view();
    }

    //退出登录
    public function logout(){
        session(null);
        if(session('?admin.id')){
            $this->error('推出失败');
        }else{
            $this->success('退出成功','admin/index/login');
        }
    }


}

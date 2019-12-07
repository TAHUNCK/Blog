<?php

namespace app\admin\controller;

use think\Controller;

class Base extends Controller
{
    //登录检测控制器
    public function initialize()
    {
        if(!session('?admin.id')){
            $this->redirect('admin/index/login');
        }
    }
}

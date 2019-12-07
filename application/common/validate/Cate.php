<?php
/**
 * Created by PhpStorm.
 * User: TAHUN
 * Date: 2019/12/6
 * Time: 23:57
 */

namespace app\common\validate;


use think\Validate;

class Cate extends Validate
{
    protected $rule=[
        'catename|栏目名称'=>'require|unique:cate',
        'sort|排序'=>'require|number'
    ];

    //添加栏目场景验证
    public function sceneAdd(){
        return $this->only(['catename','sort']);
    }

    //排序场景验证
    public function sceneSort(){
        return $this->only(['sort']);
    }

    //编辑场景验证
    public function sceneEdit(){
        return $this->only(['catename']);
    }

}
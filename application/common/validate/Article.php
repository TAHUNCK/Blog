<?php
/**
 * Created by PhpStorm.
 * User: TAHUN
 * Date: 2019/12/7
 * Time: 11:41
 */

namespace app\common\validate;


use think\Validate;

class Article extends Validate
{
    protected $rule=[
        'title|文章标题'=>'require|unique:article',
        'tags|标签'=>'require',
        'cate_id|所属栏目'=>'require',
        'desc|文章概要'=>'require',
        'content|内容'=>'require',
        'is_top|推荐'=>'require'
    ];

    //文章添加场景验证
    public function sceneAdd(){
        return $this->only(['title','tags','cate_id','desc','content']);
    }

    //推荐场景验证
    public function sceneTop(){
        return $this->only(['is_top']);
    }

    //编辑场景验证
    public function sceneEdit(){
        return $this->only(['title','tags','is_top','desc','cate_id','content']);
    }



}
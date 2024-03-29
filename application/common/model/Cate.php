<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Cate extends Model
{
    //软删除
    use SoftDelete;

    //栏目关联文章删除，栏目对文章为1:n
    public function article(){
        return $this->hasMany('Article','cate_id','id');
    }

    //栏目添加
    public function add($data){
        $validate=new \app\common\validate\Cate();
        if(!$validate->scene('add')->check($data)){
            return $validate->getError();
        }
        //allowField自动去除数据库中没有的字段
        $result=$this->allowField(true)->save($data);
        if($result){
            return 1;
        }else{
            return '栏目添加失败';
        }
    }

    //栏目排序
    public function sort($data){
        $validate=new \app\common\validate\Cate();
        if(!$validate->scene('sort')->check($data)){
            return $validate->getError();
        }
        //先查询
        $cateInfo=$this->find($data['id']);
        $cateInfo->sort=$data['sort'];
        $result=$cateInfo->save();
        if($result){
            return 1;
        }else{
            return '排序失败';
        }
    }

    //栏目编辑
    public function edit($data){
        $validate=new \app\common\validate\Cate();
        if(!$validate->scene('edit')->check($data)){
            return $validate->getError();
        }
        $cateInfo=$this->find($data['id']);
        $cateInfo->catename=$data['catename'];
        $result=$cateInfo->save();
        if($result){
            return 1;
        }else{
            return '编辑失败';
        }
    }


}

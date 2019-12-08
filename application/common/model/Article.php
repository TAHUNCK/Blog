<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Article extends Model
{
    //软删除
    use SoftDelete;

    //关联栏目表
    public function cate(){
        //文章对栏目多对一
        //article表中的cate_id对应cate表中的id
        return $this->belongsTo('Cate','cate_id','id');
    }

    //关联文章表
    public function comments()
    {
        //文章对评论一对多
        return $this->hasMany('Comment','article_id','id');
    }

    //文章添加
    public function add($data){
        $validate=new \app\common\validate\Article();
        if(!$validate->scene('add')->check($data)){
            return $validate->getError();
        }
        $result=$this->allowField(true)->save($data);
        if($result){
            return 1;
        }else{
            return '文章添加失败';
        }
    }

    //推荐
    public function top($data){
        $validate=new \app\common\validate\Article();
        if(!$validate->scene('top')->check($data)){
            return $validate->getError();
        }
        $articleInfo=$this->find($data['id']);
        $articleInfo->is_top=$data['is_top'];
        $result=$articleInfo->save();
       if($result){
           return 1;
       }else{
           return '操作失败';
       }
    }

    //文章编辑
    public function edit($data){
        $validate=new \app\common\validate\Article();
        if(!$validate->scene('edit')->check($data)){
            return $validate->getError();
        }
        //为了适应软删除，先查询在修改
        $articleInfo=$this->find($data['id']);
        $articleInfo->title=$data['title'];
        $articleInfo->tags=$data['tags'];
        $articleInfo->is_top=$data['is_top'];
        $articleInfo->cate_id=$data['cate_id'];
        $articleInfo->desc=$data['desc'];
        $articleInfo->content=$data['content'];
        $result=$articleInfo->save();
        if($result){
            return 1;
        }else{
            return '文章修改失败';
        }
    }

}

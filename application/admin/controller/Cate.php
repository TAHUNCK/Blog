<?php

namespace app\admin\controller;


class Cate extends Base
{
    //栏目列表
    public function list(){
        //以sort进行升序，分页以一条数据为一页
        $cates=model('Cate')->order('sort','asc')->paginate(10);
        //定义一个模板数据变量
        $viewData=[
            'cates'=>$cates,
        ];
        //Controller自带方法,将数据渲染到模型对应的视图中
        $this->assign($viewData);
        return view();
    }

    //栏目添加
    public function add(){
        if(request()->isAjax()){
            $data=[
                'catename'=>input('post.catename'),
                'sort'=>input('post.sort')
            ];
            $result=model('Cate')->add($data);
            if($result==1){
                $this->success('栏目添加成功','admin/cate/list');
            }
            else{
                $this->error($result);
            }
        }
        return view();
    }

    //栏目排序
    public function sort(){
        $data=[
            'id'=>input('post.id'),
            'sort'=>input('post.sort')
        ];
        $result=model('Cate')->sort($data);
        if($result==1){
            $this->success('排序成功','admin/cate/list');
        }else{
            $this->error($result);
        }
    }

    //栏目编辑
    public function edit(){
        if(request()->isAjax()){
            $data=[
                'id'=>input('post.id'),
                'catename'=>input('post.catename')
            ];
            $result=model('Cate')->edit($data);
            if($result==1){
                $this->success('栏目编辑成功','admin/cate/list');
            }else{
                $this->error($result);
            }
        }
        $cateInfo=model('Cate')->find(input('id'));
        //模板变量
        $viewData=[
            'cateInfo'=>$cateInfo
        ];
        //Controller自带方法,将数据渲染到模型对应的视图中
        $this->assign($viewData);
        return view();
    }

    //栏目删除
    public function delete(){
        //删除栏目的同时删除文章及文章下的评论
        $cateInfo=model('Cate')->with('article,article.commenta')->find(input('post.id'));
        //循环删除文章下的评论
        foreach ($cateInfo['article'] as $k=>$v) {
            $v->together('commenta')->delete();
        }
        $result=$cateInfo->together('article')->delete();
        if($result){
            $this->success('栏目删除成功','admin/cate/list');
        }else{
            $this->error('栏目删除失败');
        }
    }

}

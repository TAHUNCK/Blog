<?php

namespace app\admin\controller;

class Comment extends Base
{
    //评论列表
    public function list(){
        //数组载入或者字符串载入，此处使用字符产'article,member'载入关联模型
        $comments=model('Comment')->with('article,member')->order('create_time','desc')->paginate(10);
        $viewData=[
            'comments'=>$comments
        ];
        $this->assign($viewData);
        return view();
    }

    //评论删除
    public function del(){
        $comment=model('Comment')->find(input('post.id'));
        $result=$comment->delete();
        if($result){
            $this->success('评论删除成功','admin/comment/list');
        }else{
            $this->error('评论删除失败');
        }
    }

}

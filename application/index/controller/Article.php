<?php

namespace app\index\controller;


class Article extends Base
{
    //文章详情页
    public function info()
    {
        //关联预载入，获取和本条评论有关的其余信息
        $articleInfo = model('Article')->with('comments,comments.member')->find(input('id'));
        //点击浏览次数增加
        $articleInfo->setInc('click');
        $viewData = [
            'articleInfo' => $articleInfo
        ];
        $this->assign($viewData);
        return view();
    }

    //文章评论
    public function comment()
    {
        $data = [
            'article_id' => input('post.article_id'),
            'member_id' => input('post.member_id'),
            'content' => input('post.content')
        ];
        $result = model('Comment')->comment($data);
        if ($result == 1) {
            $this->success('评论成功');
        } else {
            $this->error($result);
        }
    }

}

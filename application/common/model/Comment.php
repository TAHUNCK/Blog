<?php

namespace app\common\model;

use think\Model;
use think\model\concern\SoftDelete;

class Comment extends Model
{
    //软删除
    use SoftDelete;

    //关联文章
    public function article(){
        //评论对文章为多对一
        return $this->belongsTo('Article','article_id','id');
    }

    //关联用户
    public function member(){
        //评论对用户为多对一
        return $this->belongsTo('Member','member_id','id');
    }

    //文章评论
    public function comment($data)
    {
        $validate = new \app\common\validate\Comment();
        if (!$validate->scene('comment')->check($data)) {
            return $validate->getError();
        }
        $result = $this->allowField(true)->save($data);
        if ($result) {
            return 1;
        } else {
            return '评论失败';
        }
    }

}

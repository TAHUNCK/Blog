<?php
/**
 * Created by PhpStorm.
 * User: TAHUN
 * Date: 2019/12/8
 * Time: 14:09
 */

namespace app\common\validate;


use think\Validate;

class Comment extends Validate
{
    protected $rule = [
        'content|评论内容' => 'require'
    ];
}
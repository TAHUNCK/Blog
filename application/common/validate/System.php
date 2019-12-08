<?php
/**
 * Created by PhpStorm.
 * User: TAHUN
 * Date: 2019/12/8
 * Time: 15:21
 */

namespace app\common\validate;


use think\Validate;

class System extends Validate
{
    protected $rule=[
        'webname|网站标题'=>'require',
        'copyright|版权信息'=>'require'
    ];

}
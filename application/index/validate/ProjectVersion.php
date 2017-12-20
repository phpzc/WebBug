<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/19
 * Time: 下午3:05
 */

namespace app\index\validate;


class ProjectVersion extends BaseValidate
{
    protected $rule = [
        'version_name'  =>  'require|max:64|min:1',

    ];

    protected $message = [

        'version_name.require'=>'版本名称不为空',
        'version_name.max'  =>  '版本名称不能超过64位',
        'version_name.min' => '版本名称不为空',


    ];

    //场景验证
    protected $scene = [
        'add'   =>  ['version_name'],
        'edit' => ['version_name'],
    ];
}
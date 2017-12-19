<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/19
 * Time: 下午3:05
 */

namespace app\index\validate;


class ProjectModule extends BaseValidate
{
    protected $rule = [
        'module_name'  =>  'unique:project_module|require|max:64|min:1',

    ];

    protected $message = [
        'module_name.unique' => '模块名称已存在',
        'module_name.require'=>'模块名称不为空',
        'module_name.max'  =>  '模块名称不能超过64位',
        'module_name.min' => '模块名称不为空',


    ];

    //场景验证
    protected $scene = [
        'add'   =>  ['module_name'],
        'edit' => ['module_name'],
    ];
}
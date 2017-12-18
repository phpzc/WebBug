<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/18
 * Time: 下午3:36
 */

namespace app\index\validate;


class Project extends BaseValidate
{
    protected $rule = [
        'project_name'  =>  'unique:project|require|max:255|min:1',

    ];

    protected $message = [
        'project_name.unique' => '项目名称已存在',
        'project_name.require'=>'项目名称不为空',
        'project_name.max'  =>  '项目名称不能超过255位',
        'project_name.min' => '项目名称不为空',


    ];

    //场景验证
    protected $scene = [
        'add'   =>  ['project_name'],
        'edit' => ['project_name'],
    ];
}
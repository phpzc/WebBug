<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/28
 * Time: 下午2:24
 */

namespace app\index\validate;


class Bug extends BaseValidate
{
    protected $rule = [
        'bug_title'  =>  'require|max:255|min:1',
        'bug_content' => 'require',

    ];

    protected $message = [
        'bug_title.require'=>'Bug标题不为空',
        'bug_title.max'  =>  'Bug标题不能超过255位',
        'bug_title.min' => 'Bug标题不为空',
        'bug_content.require'=>'Bug描述不为空',

    ];


    protected $scene = [
        'add'   =>  ['bug_title'],
        'edit' => ['bug_title'],
    ];
}
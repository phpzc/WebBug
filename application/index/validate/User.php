<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/8/20 0020
 * Time: 23:21
 */

namespace app\index\validate;

/**
 * Class User 用户模型验证器  类名与User模型名称一致 以支持 validate(true)直接调用验证
 * @package app\common\validate
 */
class User extends BaseValidate
{
    protected $rule = [
        'username'  =>  'unique:user|require|max:11|min:1',
        'password' =>  'require|max:32',

        'email' => 'unique:user|max:30',
    ];

    protected $message = [
        'username.unique' => '用户名已存在',
        'username.require'=>'用户名不为空',
        'username.max'  =>  '用户名不能超过11位',
        'username.min' => '用户名不为空',
        'password.require'=>'密码不为空',
        'password.max' =>  '密码最长32位',

        'email.unique'=>'邮箱已存在',
        'email.max'=>'邮箱不能超过30位',

    ];

    //场景验证
    protected $scene = [
        'add'   =>  ['username','password'],
        'edit_password'  => ['password'],
        'edit_email' => ['email'],
    ];
}
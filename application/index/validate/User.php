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
        'password' =>  'require|max:255',

        'email' => 'unique:user|require|max:60',
        'nickname' => 'unique:user|require|max:32'
    ];

    protected $message = [
        'username.unique' => '用户名已存在',
        'username.require'=>'用户名不为空',
        'username.max'  =>  '用户名不能超过11位',
        'username.min' => '用户名不为空',
        'password.require'=>'密码不为空',
        'password.max' =>  '密码最长255位',

        'email.unique'=>'邮箱已存在',
        'email.max'=>'邮箱不能超过60位',
        'email.require'=>'邮箱不为空',

        'nickname.unique'=>'昵称已存在',
        'nickname.max'=>'昵称不能超过32位',
        'nickname.require'=>'昵称不为空',

    ];

    //场景验证
    protected $scene = [
        'add'   =>  ['username','password'],
        'edit_password'  => ['password'],
        'edit_email' => ['email'],
        'update_profile'=>['nickname'],
    ];
}
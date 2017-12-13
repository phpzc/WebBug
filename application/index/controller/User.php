<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/13
 * Time: 上午11:11
 */

namespace app\index\controller;

class User extends Auth
{
    public function login()
    {
        return view('user/login');
    }

    public function register()
    {
        return view('user/register');
    }
}
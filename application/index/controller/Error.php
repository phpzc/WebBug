<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/12 0012
 * Time: 23:37
 */

namespace app\index\controller;


use think\Controller;

class Error extends Controller
{
    public function index()
    {
        return $this->_empty();
    }

    public function _empty()
    {
        return '404';
    }
}
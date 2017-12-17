<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/17 0017
 * Time: 22:27
 */

namespace app\index\controller;


class Dashboard extends Auth
{
    public function index()
    {

        return view('dashboard/index');
    }
}
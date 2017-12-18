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
        $this->assign('title',lang('Dashboard'));
        $this->assign('menu_nav','dashboard');
        return view('dashboard/index');
    }
}
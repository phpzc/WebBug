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

    /**
     * 显示bug统计数量 展示最新处理情况
     *
     * @return \think\response\View
     */
    public function index()
    {





        $this->assign('title',lang('Dashboard'));
        $this->assign('menu_nav','dashboard');
        return view('dashboard/index');
    }
}
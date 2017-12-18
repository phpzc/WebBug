<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/18 0018
 * Time: 8:03
 */

namespace app\index\controller;


class Project extends Auth
{

    public function index()
    {
        $this->assign('title',lang('Project List'));
        return view('project/index');
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/18 0018
 * Time: 8:06
 */

namespace app\index\controller;

use app\index\service\Bug as BugService;

class Bug extends Auth
{
    public function index()
    {
        $priority_status = $this->request->param('priority_status');

        $this->assign('title',lang('Bug List'));

        return view('bug/index');
    }
}
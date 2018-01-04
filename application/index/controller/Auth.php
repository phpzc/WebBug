<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/13
 * Time: 上午11:46
 */

namespace app\index\controller;


class Auth extends Base
{

    protected function initialize()
    {
        parent::initialize();


        if(!$this->isLogin())
        {
            if($this->request->isAjax())
            {
                echo json(['status'=>0,'message'=>'请登录',]);
                exit;
            }else{
                header('Location:'.$this->request->domain());
                exit;
            }

        }


        $this->assign('menu_nav','');
        $this->assign('priority_status','');
    }

}
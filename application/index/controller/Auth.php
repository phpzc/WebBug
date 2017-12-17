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
            header('Location:'.$this->request->domain());
            exit;
        }
    }

}
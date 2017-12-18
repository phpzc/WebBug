<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/18 0018
 * Time: 19:43
 */

namespace app\index\controller;


class Profile extends Auth
{
    public function index()
    {

        if($this->request->isGet())
        {
            return view('profile/index');
        }else{


        }
    }


}
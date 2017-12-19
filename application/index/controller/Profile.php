<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/18 0018
 * Time: 19:43
 */

namespace app\index\controller;

use app\index\model\User as UserModel;
use app\index\service\Profile as ProfileService;
class Profile extends Auth
{
    public function index()
    {

        if($this->request->isGet())
        {
            $this->assign('title',lang('Edit Profile'));
            $this->assign('menu_nav','profile');
            $this->assign('user',UserModel::get($this->user_id));
            return view('profile/index');
        }else{

            return ProfileService::updateProfile($this->request->param('nickname'),$this->user_id);
        }
    }


}
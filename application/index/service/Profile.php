<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/18 0018
 * Time: 19:48
 */

namespace app\index\service;

use app\index\model\User as UserModel;
use app\index\validate\User as UserValidate;

class Profile
{
    public static function updateProfile($nickname,$user_id)
    {
        $user = UserModel::get($user_id);
        if(!$user)
        {
            return ServiceResult::Error('用户不存在');
        }

        $validate = new UserValidate();

        if(!$validate->scene('update_profile')->check(['nickname'=>$nickname]))
        {
            return ServiceResult::Error($validate->getError());
        }


        $save = $user->save(['nickname'=>$nickname]);

        if($save !== false)
        {
            return ServiceResult::Success([],'修改成功');
        }else{
            return ServiceResult::Error('修改失败');
        }

    }
}
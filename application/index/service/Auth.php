<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/14 0014
 * Time: 22:56
 */

namespace app\index\service;


use app\index\model\User as UserModel;

class Auth
{

    /**
     * 旧密码修改新密码
     * @param $username
     * @param $oldPassword
     * @param $newPassword
     * @return ServiceResult
     */
    public static function updatePassword($username,$oldPassword,$newPassword)
    {
        $user = UserModel::get(['username'=>$username]);

        if($user->checkPassword($oldPassword)){
            return self::updatePasswordV2($username,$newPassword);
        }else{
            return ServiceResult::Error('旧密码不正确');
        }
    }

    /**
     * 直接修改密码
     * @param $username
     * @param $newPassword
     *
     * @return ServiceResult
     */
    public static function updatePasswordV2($username,$newPassword)
    {
        $user = UserModel::get(['username'=>$username]);
        $user->password = $newPassword;

        if($user->save() !== false)
        {
            return ServiceResult::Success([],'修改成功');
        }else{
            return ServiceResult::Error('修改失败');
        }
    }
    /**
     * 检查用户名是否被占用
     * @param $username
     * @return ServiceResult
     */
    public static function checkUsernameUnique($username)
    {
        $user = UserModel::where(['username'=>$username])->find();

        if(!$user)
        {
            return ServiceResult::Success([],'用户名没有被占用');
        }else{
            return ServiceResult::Error('用户名已被占用');
        }
    }

    /**
     * 前台注册服务
     *
     * @param $username
     * @param $password
     * @return ServiceResult
     */
    public static function register($username,$password)
    {
        $model = new UserModel();

        //开启事务
        $model->startTrans();
        try{
            //创建用户
            //validate data 数据校验 在验证器中验证
            $model->validate('User.add');
            $model->allowField(['username','password','create_time','phone','phone_status']);
            $add = $model->save([
                'username'=>$username,
                'password'=>$password,
                'phone'=>$username,
                'phone_status'=>1,

            ]);

            //创建其他

            $model->commit();
        }
        catch(\Exception $e)
        {
            $model->rollback();

            return ServiceResult::Error($e->getMessage());
        }




        if($add)
        {
            return ServiceResult::Success(['id'=>$model->user_id],'注册成功');

        }else{

            return ServiceResult::Error($model->getError());

        }

    }


    /**
     *
     * @param $username
     * @param $password
     * @return ServiceResult
     */
    public static function login($username,$password)
    {
        $user = UserModel::get(['username'=>$username]);

        if(!$user)
        {
            return ServiceResult::Error('用户不存在');
        }


        if (password_verify($password, $user->password)) {

            //登陆成功
            $data = $user->toArray();


            session('user_id',$data['user_id']);
            session('username',$data['username']);


            return ServiceResult::Success($data,'登陆成功');
        }
        else
        {
            //失败
            return ServiceResult::Error('密码不正确');
        }
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/14 0014
 * Time: 22:56
 */

namespace app\index\service;


use app\index\model\User as UserModel;
use app\index\validate\User as UserValidate;
use think\facade\Request;

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

        $validate = new UserValidate();

        if(!$validate->scene('edit_password')->check([

            'password'=>$newPassword,

        ]))
        {
            return ServiceResult::Error($validate->getError());
        }

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
     * @param $email
     * @return ServiceResult
     */
    public static function register($username,$password,$email)
    {
        $model = new UserModel();

        //开启事务
        $model->startTrans();
        try{
            //创建用户
            //validate data 数据校验 在验证器中验证
            //$model->validate('User.add');
            $validate = new UserValidate();

            if(!$validate->scene('add')->check([
                'username'=>$username,
                'password'=>$password,
                'email'=>$email,
            ]))
            {
                return ServiceResult::Error($validate->getError());
            }

            $model->allowField(['username','password','email','create_ip']);
            $add = $model->save([
                'username'=>$username,
                'password'=>$password,
                'email'=>$email,
                'create_ip'=>Request::ip(),
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
            self::addAuth($model->id,$username);

            return ServiceResult::Success(['id'=>$model->id,'url'=>'/'],'注册成功');

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
        $user = UserModel::getByUsername($username);

        if(!$user)
        {
            return ServiceResult::Error('用户不存在');
        }


        if (password_verify($password, $user->password)) {

            //登陆成功
            $data = $user->toArray();

            $data['url'] = '/';

            self::addAuth($data['id'],$data['username']);

            return ServiceResult::Success($data,'登陆成功');
        }
        else
        {
            //失败
            return ServiceResult::Error('密码不正确');
        }
    }

    /**
     * 添加授权
     * @param $id
     * @param $username
     */
    public static function addAuth($id,$username)
    {
        session('id',$id);
        session('username',$username);
    }

    /**
     * 取得授权信息
     * @return array
     */
    public static function getAuth()
    {
        return [
            'id'=>session('id'),
            'username'=>session('username'),
        ];
    }
}
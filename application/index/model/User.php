<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/8/18
 * Time: 下午4:06
 */

namespace app\index\model;


class User extends BaseModel
{
    protected $autoWriteTimestamp = 'datetime';



    /**
     * 密码加密
     * @param $password
     * @return bool|string
     */
    public function setPasswordAttr($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * 密码验证方法  与当前用户比对密码
     * @param $password
     * @return bool
     */
    public function checkPassword($password)
    {
        return password_verify($password, $this->getAttr('password'));
    }


}
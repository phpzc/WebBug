<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/13
 * Time: 上午11:46
 */

namespace app\index\controller;

use app\index\service\ServiceResult;
use think\captcha\Captcha;
use app\index\service\Auth as AuthService;

class Auth extends Base
{
    protected $user_id = 0;
    protected $username = '';

    protected function initialize()
    {
        parent::initialize();
        $auth = AuthService::getAuth();

        $this->user_id = $auth['id'];
        $this->username = $auth['username'];

    }

    public function verify()
    {
        $config = [
            'length'   => 4,
            // 验证码字体大小
            'fontSize'    =>    30,
            // 验证码字体大小(px)
            'useCurve' => false,

            'codeSet'=>'1234567890',
        ];
        $captcha = new Captcha($config);

        $id = $this->request->param('id','');
        return $captcha->entry($id);
    }


    public function login()
    {

        $login = AuthService::login($this->request->param('username'),
            $this->request->param('password')
            );

        return $login;
    }

    public function register()
    {
        if(!captcha_check($this->request->param('code')))
        {
            return ServiceResult::Error('验证码错误');
        }



        $register = AuthService::register(
            $this->request->param('username'),
            $this->request->param('password'),
            $this->request->param('email')
            );

        return $register;
    }
}
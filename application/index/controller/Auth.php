<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/13
 * Time: 上午11:46
 */

namespace app\index\controller;

use think\captcha\Captcha;

class Auth extends Base
{

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

    }

    public function register()
    {

    }
}
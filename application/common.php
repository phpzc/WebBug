<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
if(!function_exists('captcha_img_strong'))
{
    /**
     * 点击自动更换的验证码
     *
     * @param $id 验证码标识符 区分不同的验证码
     */
    function captcha_img_strong($id = '',$className ='',$widthHeightArray = [])
    {

        if(!empty($widthHeightArray)){
            $img=<<<EOT
    <img src="%s" onclick="this.src='%s?r='+Math.random()" alt="captcha" class="%s" style="cursor: pointer;z-index:100;position:absolute;right:0;bottom:5px;width: %spx;height: %spx"/>
EOT;

            if($id == '')
            {
                return sprintf($img,'/index/base/verify','/index/base/verify',$className,$widthHeightArray['width'],$widthHeightArray['height']);
            }else{
                return sprintf($img,'/index/base/verify/id/'.$id,'/index/base/verify/id/'.$id,$className,$widthHeightArray['width'],$widthHeightArray['height']);
            }
        }else{
            $img=<<<EOT
    <img src="%s" onclick="this.src='%s?r='+Math.random()" alt="captcha" style="cursor: pointer" class="%s" />
EOT;
            if($id == '')
            {
                return sprintf($img,'/index/base/verify','/index/base/verify',$className);
            }else{
                return sprintf($img,'/index/base/verify/id/'.$id,'/index/auth/verify/id/'.$id,$className);
            }
        }




    }
}

/**
 * 判断是否SSL协议
 * @return boolean
 */
function is_ssl() {
    if(isset($_SERVER['HTTPS']) && ('1' == $_SERVER['HTTPS'] || 'on' == strtolower($_SERVER['HTTPS']))){
        return true;
    }elseif(isset($_SERVER['SERVER_PORT']) && ('443' == $_SERVER['SERVER_PORT'] )) {
        return true;
    }
    return false;
}

/**
 * 生成网站地址
 *
 * @param string $requestUri 本站访问地址
 *
 * @return string
 */
function make_url($requestUri = '')
{
    if (empty($requestUri))
        $requestUri = strval($_SERVER['REQUEST_URI']);

    return (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $requestUri;

}
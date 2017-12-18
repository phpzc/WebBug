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
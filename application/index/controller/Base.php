<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/12 0012
 * Time: 23:37
 */

namespace app\index\controller;

use Lang;

class Base extends Error
{
    protected function initialize()
    {
        Lang::setAllowLangList(['zh-cn','en-us']);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/17 0017
 * Time: 22:22
 */

namespace app\index\model;


class ProjectUser extends BaseModel
{
    public function user()
    {
        return $this->hasOne('User','id','user_id');
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/17 0017
 * Time: 22:23
 */

namespace app\index\model;


class BugLog extends BaseModel
{
    protected $autoWriteTimestamp = 'datetime';


    public function olduser()
    {
        return $this->hasOne('User','id','old_user_id');
    }

    public function newuser()
    {
        return $this->hasOne('User','id','new_user_id');
    }


    public function getOldBugStatusAttr($value)
    {
        $status = [0=>'待处理',1=>'待审核',2=>'已解决'];
        return $status[$value];
    }

    public function getNewBugStatusAttr($value)
    {
        $status = [0=>'待处理',1=>'待审核',2=>'已解决'];
        return $status[$value];
    }
}
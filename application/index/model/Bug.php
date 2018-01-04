<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/17 0017
 * Time: 22:22
 */

namespace app\index\model;


class Bug extends BaseModel
{
    protected $autoWriteTimestamp = 'datetime';


    public function project()
    {
        return $this->hasOne('Project','id','project_id');
    }

    public function version()
    {
        return $this->hasOne('ProjectVersion','id','version_id');
    }

    public function module()
    {
        return $this->hasOne('ProjectModule','id','module_id');
    }


    public function createuser()
    {
        return $this->hasOne('User','id','create_user_id');
    }

    public function currentuser()
    {
        return $this->hasOne('User','id','current_user_id');
    }


    public function getBugStatusWord()
    {
        $status = [0=>'待处理',1=>'待审核',2=>'已解决'];
        return $status[$this->bug_status];
    }
}
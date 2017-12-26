<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/18 0018
 * Time: 8:11
 */

namespace app\index\service;

use app\index\model\Bug as BugModel;

class Bug
{

    public static function getBugWithPriority($user_id,$priority_status,$page)
    {

    }

    /**
     * 分配给用户的Bug
     * @param $user_id
     * @param $project_id
     */
    public static function getProjectBugWithStatus($user_id,$project_id)
    {

        $data = BugModel::all(['current_user_id'=>$user_id,'project_id'=>$project_id,]);

        return $data;
    }

    /**
     * 用户创建的Bug
     * @param $user_id
     * @param $project_id

     */
    public static function getUserProjectBugWithStatus($user_id,$project_id)
    {

        $data = BugModel::all(['create_user_id'=>$user_id,'project_id'=>$project_id]);

        return $data;
    }

    /**
     * 项目的所有的Bug
     * @param $project_id
     * @param $status
     */
    public static function getAllProjectBugWithStatus($project_id)
    {
        $data = BugModel::all(['project_id'=>$project_id]);
        return $data;
    }

}
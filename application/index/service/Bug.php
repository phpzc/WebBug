<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/18 0018
 * Time: 8:11
 */

namespace app\index\service;

use app\index\model\Bug as BugModel;
use app\index\model\BugLog as BugLogModel;
use app\index\validate\Bug as BugValidate;

class Bug
{

    public static function getBugWithPriority($user_id,$priority_status)
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

    /**
     * 创建Bug
     * @param $project_id
     * @param $user_id
     * @param $data
     *
     * @return ServiceResult
     */
    public static function create($project_id,$user_id,$data)
    {
        $model = new BugModel();
        $model->startTrans();

        try{

            $validate = new BugValidate();

            if(!$validate->scene('add')->check([
                'bug_title'=>$data['bug_title'],
                'bug_content'=>$data['bug_content'],
            ]))
            {
                return ServiceResult::Error($validate->getError());
            }

            $add = $model->save([
                'bug_title'=>$data['bug_title'],
                'bug_content'=>$data['bug_content'],
                'create_user_id'=>$user_id,
                'project_id'=>$project_id,
                'current_user_id'=>$data['current_user_id'],
                'bug_status'=>$data['bug_status'],
                'priority_status'=>$data['priority_status'],
                'version_id'=>$data['version_id'],
                'module_id'=>$data['module_id'],
            ]);



            $model->commit();

        }catch (\Exception $e)
        {
            $model->rollback();

            return ServiceResult::Error($e->getMessage());
        }

        if($add)
        {

            return ServiceResult::Success(['id'=>$model->id],'创建成功');

        }else{

            return ServiceResult::Error($model->getError());

        }
    }


    /**
     * 处理BUG
     *
     * @param $bug_id   bug id
     * @param $user_id  操作用户id
     * @param $data     操作数据
     */
    public static function handle($bug_id,$user_id,$data)
    {
        $bug = BugModel::get($bug_id);
        if(!$bug)
        {
            return ServiceResult::Error('Bug不存在');
        }

        $log = new BugLogModel();
        $log->startTrans();
        try{
            $log->bug_id = $bug_id;
            $log->content = $data['content'];
            $log->old_user_id = $bug->current_user_id;
            $log->new_user_id = $data['current_user_id'];
            $log->old_bug_status = $bug->bug_status;
            $log->new_bug_status = $data['status'];

            if($bug->current_user_id != $data['current_user_id'])
            {
                $bug->save(['status'=>$data['status'],'current_user_id'=>$data['current_user_id']]);
            }

            $log->save();

        }
        catch (\Exception $e)
        {
            $log->rollback();
            return ServiceResult::Error($e->getMessage());
        }

        $log->commit();

        return ServiceResult::Success([],'提交成功');

    }
}
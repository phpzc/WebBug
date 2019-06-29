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
use app\index\model\ProjectUser;
use app\index\validate\Bug as BugValidate;
use app\job\BugJob;
use think\Queue;

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

            static::notifyUser(BugJob::class,$model->id,'项目'.$model->project->project_name.'新增BUG','项目'.$model->project->project_name.'新增BUG成功');

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

        static::notifyUser(BugJob::class,$bug_id,'处理BUG '.$bug->bug_title.'【id:'.$bug_id.'】','处理BUG【id:'.$bug_id.'】');

        return ServiceResult::Success([],'提交成功');

    }

    /**
     * 修改bug内容
     * @param $id
     * @param $user_id
     * @param $data
     *
     * @return ServiceResult
     */
    public static function edit($id,$user_id,$data)
    {
        $bug = BugModel::get($id);

        if(!$bug)
        {
            return ServiceResult::Error('数据不存在');
        }

        $bug->startTrans();

        try{
            $saveData = [
                'bug_content'=>$data['bug_content'],
                'bug_status'=>$data['bug_status'],
                'priority_status'=>$data['priority_status'],
                'module_id'=>$data['module_id'],
                'version_id'=>$data['version_id'],
                'bug_title'=>$data['bug_title'],
            ];

            $save = $bug->save($saveData);

        }catch (\Exception $e)
        {
            $bug->rollback();

            return ServiceResult::Error($e->getMessage());
        }

        if($save !== false)
        {
            $bug->commit();

            static::notifyUser(BugJob::class,$id,'处理BUG '.$bug->bug_title.'【id:'.$id.'】','处理BUG'.$bug->bug_title);


            return ServiceResult::Success([],'修改成功');
        }else{
            $bug->rollback();

            return ServiceResult::Error('修改失败');
        }

    }




    public static function notifyUser($jobClassName,$bugId,$title,$content)
    {
        $bug = \app\index\model\Bug::where(['id'=>$bugId])->find();

        $all = ProjectUser::all(['project_id'=>$bug->project_id]);

        $userIds = array_column($all->toArray(),'user_id');

        $data =  make_job($userIds,$title,BugEmailTemplate::getEmail($content));


        Queue::push($jobClassName,$data);
    }
}
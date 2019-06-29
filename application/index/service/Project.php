<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/18
 * Time: 下午3:35
 */

namespace app\index\service;

use app\index\model\Project as ProjectModel;
use app\index\model\ProjectModule;
use app\index\model\ProjectUser;
use app\index\model\ProjectVersion;
use app\index\model\User;
use app\index\validate\Project as ProjectValidate;
use app\job\ProjectJob;
use think\facade\Request;

use think\Queue;

class Project
{
    public static function create($project_name,$user_id)
    {
        $model = new ProjectModel();

        $model->startTrans();
        try{

            $validate = new ProjectValidate();

            if(!$validate->scene('add')->check([
                'project_name'=>$project_name,
            ]))
            {
                return ServiceResult::Error($validate->getError());
            }


            $add = $model->save([
                'project_name'=>$project_name,
                'user_id'=>$user_id,
                'create_ip'=>Request::ip(),
            ]);

            $m = new ProjectModule();
            $v = new ProjectVersion();
            $u = new ProjectUser();
            $m->project_id = $model->id;
            $v->project_id = $model->id;
            $u->project_id = $model->id;

            $m->user_id = $user_id;
            $v->user_id = $user_id;
            $u->user_id = $user_id;

            $m->module_name = lang('Default');
            $v->version_name = lang('Default');
            $m->save();
            $v->save();
            $u->save();


            $model->commit();
        }
        catch(\Exception $e)
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

    public static function edit($project_name,$user_id,$id)
    {
        $project = ProjectModel::get($id);

        if(!$project)
        {
            return ServiceResult::Error('项目不存在');
        }

        if($project->user_id != $user_id)
        {
            return ServiceResult::Error('没有权限修改');
        }

        $oldName = $project->project_name;

        $project->startTrans();
        try{

            $validate = new ProjectValidate();

            if(!$validate->scene('edit')->check([
                'project_name'=>$project_name,
            ]))
            {
                return ServiceResult::Error($validate->getError());
            }

            $project->allowField(['project_name']);

            $update = $project->save([
                'project_name'=>$project_name,
            ]);

            $project->commit();
        }
        catch(\Exception $e)
        {
            $project->rollback();

            return ServiceResult::Error($e->getMessage());
        }

        if($update !== false)
        {

            static::notifyUser(ProjectJob::class,$id, '修改项目名称','项目原名'.$oldName.'改为'.$project_name);

            return ServiceResult::Success([],'修改成功');

        }else{

            return ServiceResult::Error($project->getError());

        }
    }

    public static function delete($id,$user_id)
    {
        $project = ProjectModel::get($id);

        if(!$project)
        {
            return ServiceResult::Error('项目不存在');
        }

        if($project->user_id != $user_id)
        {
            return ServiceResult::Error('没有权限');
        }

        $del = $project->delete();

        if($del)
        {
            return ServiceResult::Success([],'删除成功');
        }else{
            return ServiceResult::Error('删除失败');
        }
    }

    /**
     * 查询出 可添加项目的 用户数据
     * @param $project_id
     *
     * @return ServiceResult
     */
    public static function findCanAddUser($project_id)
    {

        $project = ProjectModel::get($project_id);

        if(!$project)
        {
            return ServiceResult::Error('项目不存在');
        }

        $projectUserResult = ProjectUser::all(['project_id'=>$project_id]);

        $userIds = [];

        foreach ($projectUserResult as $v)
        {
            $userIds[]=$v['user_id'];
        }

        $allUser = User::all();

        $userData = [];

        foreach ($allUser as $k=>$v)
        {
            if(in_array($v['id'],$userIds)){
                continue;
            }

            $userData[] = $v;

        }

        if(!empty($userData)){
            return ServiceResult::Success($userData,'获取用户成功');
        }else{
            return ServiceResult::Error('获取用户失败');
        }



    }


    /**
     * 添加用户到项目人员中
     * @param $userIdsArray
     * @param $project_id
     *
     * @return ServiceResult
     */
    public static function addProjectUser($userIdsArray,$project_id)
    {
        $projectUserResult = ProjectUser::all(['project_id'=>$project_id]);

        $userIds = [];

        foreach ($projectUserResult as $v)
        {
            $userIds[]=$v['user_id'];
        }


        foreach ($userIdsArray as $k=>$v)
        {
            if(in_array(strval($v),$userIds)){
                unset($userIdsArray[$k]);
            }
        }

        if(empty($userIdsArray))
        {
            return ServiceResult::Error('没有可添加的用户');
        }

        $addData = [];

        foreach ($userIdsArray as $v)
        {
            $addData[] = [
                'user_id'=>$v,
                'project_id'=>$project_id,
            ];
        }

        $model = new ProjectUser();

        $model->saveAll($addData);



        return ServiceResult::Success([],'成功添加用户');
    }


    /**
     * 删除项目人员
     * @param $user_id
     * @param $project_id
     * @return ServiceResult
     */
    public static function deleteProjectUser($user_id,$project_id)
    {
        $project = ProjectModel::get($project_id);

        if($project['user_id'] == $user_id)
        {
            return ServiceResult::Error('创建者不能删除');
        }

        ProjectUser::where(['project_id'=>$project_id,'user_id'=>$user_id])->delete();


        return ServiceResult::Success([],'删除成功');
    }




    public static function notifyUser($jobClassName,$projectId,$title,$content)
    {
        $all = ProjectUser::all(['project_id'=>$projectId]);

        $userIds = array_column($all->toArray(),'user_id');

        $data =  make_job($userIds,$title,ProjectEmailTemplate::getEmail($content));


        Queue::push($jobClassName,$data);
    }
}
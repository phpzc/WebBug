<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/18
 * Time: 下午3:35
 */

namespace app\index\service;

use app\index\model\Project as ProjectModel;
use app\index\validate\Project as ProjectValidate;
use think\facade\Request;

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

            $model->allowField(['project_name','user_id','create_ip']);
            $add = $model->save([
                'project_name'=>$project_name,
                'user_id'=>$user_id,
                'create_ip'=>Request::ip(),
            ]);

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
}
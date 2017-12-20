<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/19
 * Time: 下午3:08
 */

namespace app\index\service;

use app\index\model\ProjectVersion as ProjectVersionModel;
use app\index\validate\ProjectVersion as ProjectVersionValidate;

class ProjectVersion
{
    /**
     * 添加新的项目版本名称
     * @param $name
     * @param $project_id
     * @param $user_id
     * @return ServiceResult
     */
    public static function add($name,$project_id,$user_id)
    {
        $model = new ProjectVersionModel();

        //开启事务
        $model->startTrans();
        try{

            $validate = new ProjectVersionValidate();

            if(!$validate->scene('add')->check([
                'version_name'=>$name,

            ]))
            {
                return ServiceResult::Error($validate->getError());
            }

            $add = $model->save([
                'version_name'=>$name,
                'project_id'=>$project_id,
                'user_id'=>$user_id,
            ]);

            //创建其他

            $model->commit();
        }
        catch(\Exception $e)
        {
            $model->rollback();

            return ServiceResult::Error($e->getMessage());
        }


        if($add)
        {
            return ServiceResult::Success(['id'=>$model->id],'添加成功');

        }else{

            return ServiceResult::Error($model->getError());

        }

    }


    /**
     * 修改项目版本名称
     * @param $id
     * @param $user_id
     * @param $new_name
     *
     * @return ServiceResult
     */
    public static function edit($id,$user_id,$new_name)
    {
        $data = ProjectVersionModel::get($id);

        if(!$data){
            return ServiceResult::Error('项目版本数据不存在');
        }

        if($data->user_id != $user_id)
        {
            return ServiceResult::Error('没有权限修改');
        }

        $validate = new ProjectVersionValidate();

        if(!$validate->scene('edit')->check([
            'version_name'=>$new_name,

        ]))
        {
            return ServiceResult::Error($validate->getError());
        }


        $data->version_name = $new_name;

        $save = $data->save();


        if($save !== false)
        {
            return ServiceResult::Success([],'修改成功');
        }else{
            return ServiceResult::Error('修改失败');
        }

    }

    public static function delete($id,$user_id)
    {
        $data = ProjectVersionModel::get($id);

        if(!$data){
            return ServiceResult::Error('项目版本数据不存在');
        }

        if($data->user_id != $user_id)
        {
            return ServiceResult::Error('没有权限修改');
        }

        if($data->delete())
        {
            return ServiceResult::Success([],'删除成功');
        }else{
            return ServiceResult::Error('删除失败');
        }
    }
}
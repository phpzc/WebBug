<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/18 0018
 * Time: 8:03
 */

namespace app\index\controller;

use app\index\service\Project as ProjectService;
use app\index\model\Project as ProjectModel;
class Project extends Auth
{

    public function index()
    {

        $list = ProjectModel::where('user_id',$this->user_id)->order('id desc')->paginate(3);
        $page = $list->render();

        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('title',lang('Project List'));

        return view('project/index');
    }

    /**
     *
     * @return \app\index\service\ServiceResult
     */
    public function create()
    {
        return ProjectService::create($this->request->param('project_name'),$this->user_id);
    }


    public function edit()
    {
        if($this->request->isGet())
        {
            $this->assign('project',ProjectModel::get($this->request->param('id')));
            $this->assign('title',lang('Edit Project'));
            return view('project/edit');
        }else{
            return ProjectService::edit($this->request->param('project_name'),$this->user_id,$this->request->param('id'));
        }


    }

    public function delete()
    {
        return ProjectService::delete($this->request->param('id'),$this->user_id);
    }
}
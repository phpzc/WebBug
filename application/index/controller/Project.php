<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/18 0018
 * Time: 8:03
 */

namespace app\index\controller;

use app\index\model\ProjectModule;
use app\index\model\ProjectVersion;
use app\index\service\Project as ProjectService;
use app\index\model\Project as ProjectModel;
use app\index\model\ProjectModule as ProjectModuleModel;
use app\index\model\ProjectVersion as ProjectVersionModel;

use app\index\service\ProjectModule as ProjectModuleService;
use app\index\service\ProjectVersion as ProjectVersionService;


class Project extends Auth
{

    public function index()
    {

        $list = ProjectModel::where('user_id',$this->user_id)->order('id desc')->paginate(3);
        $page = $list->render();

        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('title',lang('Project List'));
        $this->assign('menu_nav','project/index');

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
            //module version


            $this->assign('module',ProjectModuleModel::all(['project_id'=>$this->request->param('id')]));
            $this->assign('version',ProjectVersionModel::all(['project_id'=>$this->request->param('id')]));
            $this->assign('project',ProjectModel::get($this->request->param('id')));
            $this->assign('title',lang('Edit Project'));
            $this->assign('menu_nav','project/index');
            return view('project/edit');
        }else{
            return ProjectService::edit($this->request->param('project_name'),$this->user_id,$this->request->param('id'));
        }


    }

    public function delete()
    {
        return ProjectService::delete($this->request->param('id'),$this->user_id);
    }


    /**
     * 项目详情
     */
    public function main()
    {
        //todo BUG列表 BUG统计 项目版本 模块


        $this->assign('menu_nav','project/index');
        return view('project/main');
    }

    /**
     * 修改项目模块名称
     */
    public function edit_module()
    {
        return ProjectModuleService::edit($this->request->param('id','0'),$this->user_id,$this->request->param('module_name'));
    }

    /**
     * 修改项目版本名称
     */
    public function edit_version()
    {
        return ProjectVersionService::edit($this->request->param('id','0'),$this->user_id,$this->request->param('version_name'));
    }


    /**
     * 删除项目模块
     */
    public function del_module()
    {
        return ProjectModuleService::delete($this->request->param('id','0'),$this->user_id);
    }


    /**
     * 删除项目版本
     */
    public function del_version()
    {
        return ProjectVersionService::delete($this->request->param('id','0'),$this->user_id);
    }

    /**
     * 添加项目模块
     */
    public function add_module()
    {
        return ProjectModuleService::add($this->request->param('module_name'),$this->request->param('project_id','0'),$this->user_id);
    }


    /**
     * 添加项目版本
     */
    public function add_version()
    {
        return ProjectVersionService::add($this->request->param('version_name'),$this->request->param('project_id','0'),$this->user_id);
    }

}
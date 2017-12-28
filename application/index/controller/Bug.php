<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/18 0018
 * Time: 8:06
 */

namespace app\index\controller;

use app\index\service\Bug as BugService;
use app\index\model\ProjectModule as ProjectModuleModel;
use app\index\model\ProjectVersion as ProjectVersionModel;
use app\index\model\ProjectUser as ProjectUserModel;

class Bug extends Auth
{
    public function index()
    {
        $priority_status = $this->request->param('priority_status');

        $this->assign('title',lang('Bug List'));

        return view('bug/index');
    }

    public function add()
    {
        if($this->request->isGet())
        {
            $this->assign('module',ProjectModuleModel::all(['project_id'=>$this->request->param('id')]));
            $this->assign('version',ProjectVersionModel::all(['project_id'=>$this->request->param('id')]));

            $this->assign('project_user',ProjectUserModel::all(['project_id'=>$this->request->param('id')]));

            $this->assign('id',$this->request->param('id'));


            return view('bug/add');
        }else{

            return BugService::create($this->request->param('id'),$this->user_id,$this->request->post());
        }
    }
}
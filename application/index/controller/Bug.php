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
use app\index\model\Bug as BugModel;
use app\index\model\BugLog as BugLogModel;

use app\index\service\ServiceResult;

class Bug extends Auth
{

    public function index()
    {

        $priority_status = $this->request->param('priority_status',0,'intval');

        $this->assign('bugs',BugModel::all(['priority_status'=>$priority_status,'current_user_id'=>$this->user_id]));

        $this->assign('title',lang('Bug List'));
        $this->assign('menu_nav','bug/index');
        $this->assign('priority_status',$priority_status + 1);

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

    /**
     * 处理Bug
     */
    public function handle()
    {
        if($this->request->isGet())
        {
            $id = $this->request->param('id');

            $this->assign('bug',BugModel::get($id));
            $this->assign('bug_log',BugLogModel::all(['bug_id'=>$id]));

            $this->assign('title',lang('Handle Bug'));
            return view('bug/handle');

        }else{

            $content = $this->request->param('content','');
            $bug_id = $this->request->param('bug_id',0);
            $current_user_id = $this->request->param('current_user_id',0);
            $status = $this->request->param('status',0);
            $user_id = $this->user_id;

            //添加BugLog日志 修改Bug状态
            return BugService::handle($bug_id,$user_id,['content'=>$content,'current_user_id'=>$current_user_id,'status'=>$status]);

        }

    }


    /**
     * 获取项目的人员
     */
    public function project_users()
    {
        $id = $this->request->param('id',0);

        $users = ProjectUserModel::all(['project_id'=>$id]);

        $data = [];

        foreach($users as $k=>$v)
        {
            $data[] = [
                'user_id'=>$v['user_id'],
                'username'=>$v->user->username,
            ];
        }

        if(empty($data))
        {
            return ServiceResult::Error('项目人员数据为空');
        }else{


            return ServiceResult::Success($data);
        }
    }


    /**
     *
     */
    public function edit()
    {
        if($this->request->isGet())
        {

            $id = $this->request->param('id');

            $bug = BugModel::get($id);
            $this->assign('bug',$bug);
            $this->assign('bug_log',BugLogModel::all(['bug_id'=>$id]));

            $this->assign('module',ProjectModuleModel::all(['project_id'=>$bug->project_id]));
            $this->assign('version',ProjectVersionModel::all(['project_id'=>$bug->project_id]));


            $this->assign('title',lang('Edit Bug'));

            return view('bug/edit');
        }else{

        }
    }

}
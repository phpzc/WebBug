<?php
/**
 * Created by PhpStorm.
 * User: zhangcheng
 * Date: 2017/12/17 0017
 * Time: 22:27
 */

namespace app\index\controller;


use app\index\model\ProjectUser as ProjectUserModel;
use app\index\model\Bug as BugModel;


class Dashboard extends Auth
{

    /**
     * 显示bug统计数量 展示最新处理情况
     *
     * @return \think\response\View
     */
    public function index()
    {

        $this->assign('project_count',ProjectUserModel::where(['user_id'=>$this->user_id])->count());
        $this->assign('bug_count_no',BugModel::where(['current_user_id'=>$this->user_id,'bug_status'=>0])->count());
        $this->assign('bug_count_yes',BugModel::where(['current_user_id'=>$this->user_id,])->where('bug_status','>',0)->count());

        $projectIds = ProjectUserModel::all(['user_id'=>$this->user_id]);
        $projectIdArray = array_column($projectIds->toArray(),'project_id');

        $this->assign('bug_count_all',BugModel::where(['current_user_id'=>$this->user_id,])->where('project_id','in',$projectIdArray)->count());


        $this->assign('title',lang('Dashboard'));
        $this->assign('menu_nav','dashboard');
        return view('dashboard/index');
    }
}
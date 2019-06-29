<?php


namespace app\job;

use app\index\model\User;
use think\queue\Job;

use app\handler\Email;

/**
 * Class BugJob   操作问题bug 发送邮件通知任务
 * @package app\job
 */
class BugJob extends BaseJob
{
    public function fire(Job $job, $data){

        //....这里执行具体的任务

        if ($job->attempts() > 1) {
            //通过这个方法可以检查这个任务已经重试了几次了
            return $job->delete();
        }


        $email = new Email();


        //读取用户id 挨个发送邮件
        foreach ($data['userIdArray'] as $v){

            $user = User::where(['id'=>$v])->find();

            $email->send($user->email,$user->username,$data['title'],$data['content']);

        }


        $job->delete();



    }


}
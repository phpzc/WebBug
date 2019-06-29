<?php


namespace app\job;


class BaseJob
{
    public function failed($data){

        // ...任务达到最大重试次数后，失败了
    }
}
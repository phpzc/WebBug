<?php


namespace app\index\service;


class ProjectEmailTemplate
{
    public static function getEmail($content)
    {
        $date = date('Y-m-d H:i:s');

        return <<<EOT
类型:项目<br />
内容:{$content}<br />
时间:{$date}<br />
EOT;

    }
}
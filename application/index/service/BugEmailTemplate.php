<?php


namespace app\index\service;


class BugEmailTemplate
{
    public static function getEmail($content)
    {
        $date = date('Y-m-d H:i:s');

        return <<<EOT
类型:BUG<br />
内容:{$content}<br />
时间:{$date}<br />
EOT;

    }
}
<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::get('hello/:name', 'index/hello');

Route::rule('user/login','index/user/login');
Route::rule('user/register','index/user/register');
Route::rule('base/register','index/base/register');
Route::rule('base/login','index/base/login');
Route::rule('dashboard','index/dashboard/index');
Route::rule('project/index','index/project/index');
Route::rule('project/main','index/project/main');
Route::rule('profile','index/profile/index');
Route::rule('logout','index/base/logout');
return [

];

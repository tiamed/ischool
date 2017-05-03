<?php

header('conten-type:text/html;charset=utf-8');

//BUG调试

function show_bug($msg){
	echo "<pre style='color:red'>";
	var_dump($msg);
	echo "</pre>";
}

//前后台资源常量定义
//
define('SITE_URL',"http://192.168.1.111/item/");
define('SITE_URL_L',"http://192.168.1.111/item/students/index.php/");

define('ADMIN_CSS_URL',SITE_URL.'students/Public/Admin/css/');
define('ADMIN_FONTS_URL',SITE_URL.'students/Public/Admin/font/');
define('ADMIN_IMGS_URL',SITE_URL.'students/Public/Admin/img/');
define('ADMIN_JS_URL',SITE_URL.'students/Public/Admin/js/');
define('ADMIN_UPLOAD_URL',SITE_URL.'students/Public/Admin/upload/');

define('HOME_BT_URL',SITE_URL.'students/Public/Home/bootstrap/');
define('HOME_CSS_URL',SITE_URL.'students/Public/Home/css/');
define('HOME_FONTS_URL',SITE_URL.'students/Public/Home/fonts/');
define('HOME_IMAGES_URL',SITE_URL.'students/Public/Home/images/');
define('HOME_JS_URL',SITE_URL.'students/Public/Home/js/');
define('HOME_LAYUI_URL',SITE_URL.'students/Public/Home/layui/');
define('HOME_ASSETS_URL',SITE_URL.'students/Public/Home/assets/');
//define('STU_CONTROLLER_URL',SITE_URL_L.'students/Students/Controller/');
//把目前tp模式由生产模式变为开发模式

define("APP_DEBUG",true);

//引入框架的核心程序

include "../ThinkPHP/ThinkPHP.php";

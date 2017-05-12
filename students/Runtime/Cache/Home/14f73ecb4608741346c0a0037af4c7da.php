<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width" />
    <title>ISchool</title>
    <meta name="author" content="Alvaro Trigo Lopez" />
    <meta name="description" content="学生事务管理系统" />
    <meta name="keywords" content="学生事务管理系统" />
    <meta name="Resource-type" content="Document" />
    <link rel="stylesheet" type="text/css" href="<?php echo (HOME_CSS_URL); ?>frontpage.css" />
    <link href="<?php echo (HOME_CSS_URL); ?>bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link href="<?php echo (ADMIN_CSS_URL); ?>simple-line-icons.css" rel="stylesheet">
    <link href="<?php echo (ADMIN_CSS_URL); ?>font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo (ADMIN_CSS_URL); ?>pagination.css" rel="stylesheet">
    <link href="<?php echo (HOME_CSS_URL); ?>custom_style.css" rel="stylesheet">
    <link href="<?php echo (HOME_CSS_URL); ?>hover.css" rel="stylesheet">
    <link href="<?php echo (HOME_CSS_URL); ?>detailed.css" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo (HOME_IMAGES_URL); ?>apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo (HOME_IMAGES_URL); ?>'favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo (HOME_IMAGES_URL); ?>favicon-16x16.png">
    <link rel="manifest" href="<?php echo (HOME_IMAGES_URL); ?>manifest.json">
    <link rel="mask-icon" href="<?php echo (HOME_IMAGES_URL); ?>safari-pinned-tab.svg" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
</head>

<body>
    <div id="loading">
            <div id="loading-center">
                <div id="loading-center-absolute">
                    <div class="object" id="object_one"></div>
                    <div class="object" id="object_two"></div>
                    <div class="object" id="object_three"></div>
                </div>
            </div>
        </div>
    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <form action="<?php echo (SITE_URL_L); ?>Home/Index/detailed/id/<?php echo ($detailed["id"]); ?>" method="post">
            <div class="mtitle">
                <h3 class="login-title">ISchool</h3>
            </div>
            <div class="modal-body">
                <div class="input-field">
                    <input type="username" name="username" class="form-control" placeholder="学/工号" required="required">
                </div>
                <div class="input-field">
                    <input type="password" name="password" class="form-control" placeholder="密码" required="required">
                </div>
            </div>
            <div>
                <button type="submit" class="btn btn-red">登录</button>
            </div>
        </div>
    </div>
    <header class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1">
		<h1 style="font-size:3.5vh; margin-top: 4rem; margin-bottom: 4rem;">
	        <img src="<?php echo (HOME_IMAGES_URL); ?>active-xiangqing.png" class="img-position" style="height: 4vh;"></i>活动详情
	    </h1>
    </header>
    <div class="container-fluid">
    	<div class="row">
	    	<div class="col-md-10 col-md-offset-1 col-xs-12 labels">
	    		<div class="col-md-4 col-sm-4 gray">
	    			<img class="center-cropped image" id="img" src="<?php echo (SITE_URL); ?>students/<?php echo ($detailed["big_image"]); ?>"/>
                    <p id="title" style="font-size: 2.4vh;"><?php echo ($detailed["title"]); ?>
                    </p>
	    			<ul class="captions" id="captions">
                        <span>
                            <li>报名时间：</li><li><?php echo (subtext2($detailed["reg_start"],16)); ?>  —  <?php echo (subtext2($detailed["reg_end"],16)); ?></li>
                        </span>
                        <span>
                            <li>活动时间：</li><li><?php echo (subtext2($detailed["start"],16)); ?>  — <?php echo (subtext2($detailed["end"],16)); ?></li>
                        </span>
                        <span>
                            <li>活动地点：<?php echo ($detailed["place"]); ?></li>
                        </span>
                        <span>
                            <li>活动名额：<?php echo ($detailed["limit"]); ?></li> 
                        </span>
                        <span>  
                            <li><a id="sign" href="<?php echo (SITE_URL_L); ?>Home/Index/apply/id/<?php echo ($detailed["id"]); ?>"><i class="fa fa-envelope-o"></i>&nbsp;我要报名</a></li>
                        </span>
                    </ul>
					
	    		</div>
                <div class="col-md-8 col-sm-8 info" id="info">
                    <p><?php echo ($detailed["content"]); ?></p>
                </div>
	    	</div>
            <a class="return hvr-pulse" href="<?php echo (SITE_URL_L); ?>Home/Index/index#3rdPage"><img src="<?php echo (HOME_IMAGES_URL); ?>return.png" style="width: 38px; height: 38px;"></a>
    	</div>
    </div>
    
    <script src="<?php echo (ADMIN_JS_URL); ?>jquery-latest.js"></script>
    <script src="<?php echo (HOME_JS_URL); ?>bootstrap.js"></script>
    <script src="<?php echo (HOME_JS_URL); ?>login.js"></script>
    <script src="<?php echo (HOME_JS_URL); ?>javascript.fullPage.js"></script>
    <script type="text/javascript">
        $(window).load(function() {
           $("#loading").fadeOut(1200);
        })
    </script>
</body>
</html>
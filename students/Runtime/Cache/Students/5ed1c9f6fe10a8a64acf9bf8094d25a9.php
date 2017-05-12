<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<!-- 导航栏阴影 -->
<style type="text/css">
header{
    box-shadow: -5px 5px 10px #888888;
}
.card{

}
</style>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="离校统计">
    <meta name="keyword" content="admin,teacher,information,collect">
    <link rel="shortcut icon" href="<?php echo (ADMIN_IMGS_URL); ?>favicon.png">

    <title>已填写的离返校信息</title>

    <!-- Icons -->
    <link href="<?php echo (ADMIN_CSS_URL); ?>font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo (ADMIN_CSS_URL); ?>simple-line-icons.css" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="<?php echo (ADMIN_CSS_URL); ?>style2.css" rel="stylesheet">
    <link href="<?php echo (ADMIN_CSS_URL); ?>pagination.css" rel="stylesheet">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo (HOME_IMAGES_URL); ?>apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo (HOME_IMAGES_URL); ?>favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo (HOME_IMAGES_URL); ?>favicon-16x16.png">
<link rel="manifest" href="<?php echo (HOME_IMAGES_URL); ?>manifest.json">
<link rel="mask-icon" href="<?php echo (HOME_IMAGES_URL); ?>safari-pinned-tab.svg" color="#5bbad5">
<meta name="theme-color" content="#ffffff">
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler hidden-lg-up" type="button">☰</button>
        <a class="navbar-brand" href="<?php echo (SITE_URL_L); ?>Students/Index" style="padding:1rem;"><img src="<?php echo (ADMIN_IMGS_URL); ?>ISchool2.png" style=" height: 2rem;float: left;margin-top: -0.1rem;margin-right:0.5rem;"><h4 style="color:#494949;">学生个人中心</h4></a>
        <ul class="nav navbar-nav ml-auto">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" role="button" aria-haspopup="true" aria-expanded="false">
						账户管理
                </a>
				<div class="dropdown-menu dropdown-right text-xs-center">
						<a class="dropdown-item" href="<?php echo (SITE_URL_L); ?>Home/Index/change">修改密码</a>
				</div>
			</li>
            <li class="nav-item">
                <a class="btn btn-outline" href="<?php echo (SITE_URL_L); ?>Home/Index/logout" style="margin-right: 1em;">
                    <i class="icon-logout"></i> 注销
                </a>
            </li>

        </ul>
    </header>

    <div class="app-body">
        <div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li class="nav-title">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo (SITE_URL_L); ?>Students/Index" ><i class="fa fa-cog"></i>我的信息</a>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-edit"></i>活动管理</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo (SITE_URL_L); ?>Students/Index/actives">未填报的活动</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo (SITE_URL_L); ?>Students/Index/actived">已填报的活动</a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-calendar-o"></i>离返校管理</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo (SITE_URL_L); ?>Students/Index/los">填写离校信息</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo (SITE_URL_L); ?>Students/Index/leavelist">已填写的离返校信息</a>
                            </li>
<!--                             <li class="nav-item">
    <a class="nav-link" href="<?php echo (SITE_URL_L); ?>students/index/map">离返校签到</a>
</li> -->
                        </ul>
                    </li>

                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-pie-chart"></i>问卷调查管理</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo (SITE_URL_L); ?>Students/Index/infolist">未填写的问卷调查</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo (SITE_URL_L); ?>Students/Index/infolisted">已填写的问卷调查</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-briefcase"></i>志愿分流管理</a>
                        <ul class="nav-dropdown-items">
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo (SITE_URL_L); ?>Students/Index/major">填报志愿信息</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo (SITE_URL_L); ?>Students/Index/majored">已填报的志愿信息</a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </nav>
        </div>

        <!-- Main content -->
        <main class="main">
            <div class="container-fluid animated fadeIn">
              
                <div class="card">
                                <div class="card-header">
                                    <i class="fa fa-pencil-square fa-lg m-t-2"></i> 已填写的离返校信息
                                </div>
                                <div class="card-block col-md-12">
                                    <table class="table table-bordered table-striped table-condensed">
                                        <tbody>
                                            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                                    <td><?php echo ($vo["title"]); ?></td>
                                                    <td style="text-align: center;"><?php echo ($vo["edit_time"]); ?></td>
                                                    <td style="text-align: center;"><?php echo ($vo["register"]); ?></td>
                                                    <td style="text-align: center;"><a class="badge badge-primary" href="<?php echo (SITE_URL_L); ?>Students/Index/updatelos/id/<?php echo ($vo["id"]); ?>">修改</a>
                                                    <a class="badge badge-danger" href="<?php echo (SITE_URL_L); ?>Students/Index/map/id/<?php echo ($vo["id"]); ?>">签到</a>
                                                    </td>
                                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </tbody>
                                    </table>
                                    
        <div class="pages">  
            <?php echo ($page); ?>  
        </div>
                                </div>
                            </div>
                        </div>
                </div>          
        </main>


    </div>

    <footer class="app-footer">

        <p  align="center" style="width: 60%;
            margin: 2em auto 0;
            margin-top:0.8em;
            font-size: 14px;
            text-align: center;
            color: #999;
            line-height: 1.8em;
            font-family: "Microsoft Yahei"
            ">版权所有 © ISchool
        </p>    

    </footer>

    <!-- Bootstrap and necessary plugins -->
    <script src="<?php echo (ADMIN_JS_URL); ?>jquery.min.js"></script>
    <script src="<?php echo (ADMIN_JS_URL); ?>tether.min.js"></script>
    <script src="<?php echo (ADMIN_JS_URL); ?>bootstrap.min.js"></script>
    <script src="<?php echo (ADMIN_JS_URL); ?>pace.min.js"></script>
    <!-- GenesisUI main scripts -->

    <script src="<?php echo (ADMIN_JS_URL); ?>app.js"></script>
    <!-- Plugins and scripts required by this views -->

    <!-- Custom scripts required by this view -->
    <script src="<?php echo (ADMIN_JS_URL); ?>views/main.js"></script>
    <script type="text/javascript">
        $('.dropdown-toggle').click(function(){
        $(this).next(".dropdown-menu").toggle();
        });
    </script>
</body>

</html>
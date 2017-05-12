<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="学生个人中心">
    <meta name="keyword" content="admin,teacher,information,collect">
    <link rel="shortcut icon" href="<?php echo (ADMIN_IMGS_URL); ?>favicon.png">

    <title>学生个人中心</title>

    <!-- Icons -->
    <link href="<?php echo (ADMIN_CSS_URL); ?>font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo (ADMIN_CSS_URL); ?>simple-line-icons.css" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="<?php echo (ADMIN_CSS_URL); ?>style2.css" rel="stylesheet">



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
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="fa fa-briefcase"></i>问卷调查管理</a>
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
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-pie-chart"></i>志愿分流管理</a>
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
                                    <div class="fa fa-bookmark fa-lg m-t-2"></div> 个人信息
                                </div>
                                <div class="card-block">
                                    <table class="table hidden-sm-down">
                                        <tbody>
                                            <tr>
                                                <td style="text-align: center;"><b>姓名</b></td>
                                                <td><?php echo (session('name')); ?></td>
                                                <td style="text-align: center;"><b>性别</b></td>
                                                <td><?php echo (session('sex')); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;"><b>出生年月</b></td>
                                                <td><?php echo (session('birthday')); ?></td>
                                                <td style="text-align: center;"><b>行政班</b></td>
                                                <td><?php echo (session('class')); ?></td>
                                            
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;"><b>民族</b></td>
                                                <td><?php echo (session('nation')); ?></td>
                                                
                                                <td style="text-align: center;"><b>家庭住址</b></td>
                                                <td><?php echo (session('address')); ?></td>
                                            </tr> 
                                            <tr>
                                                <td style="text-align: center;"><b>长号</b></td>
                                                <td><?php echo (session('lphonenum')); ?></td>
                                                <td style="text-align: center;"><b>短号</b></td>
                                                <td><?php echo (session('sphonenum')); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;"><b>书院寝室号</b></td>
                                                <td><?php echo (session('room')); ?></td>
                                               
                                                <td style="text-align: center;"><b>火车终点站</b></td>
                                                <td><?php echo (session('train')); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-bordered hidden-md-up">
                                        <tbody>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <b>
                                                        姓名
                                                    </b>
                                                </td>
                                                <td data-title="姓名">
                                                    <?php echo (session('name')); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <b>
                                                        性别
                                                    </b>
                                                </td>
                                                <td>
                                                    <?php echo (session('sex')); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <b>
                                                        出生年月
                                                    </b>
                                                </td>
                                                <td>
                                                    <?php echo (session('birthday')); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;"><b>行政班</b></td>
                                                <td><?php echo (session('class')); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <b>
                                                        民族
                                                    </b>
                                                </td>
                                                <td>
                                                    <?php echo (session('nation')); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <b>
                                                        家庭住址
                                                    </b>
                                                </td>
                                                <td>
                                                    <?php echo (session('address')); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <b>
                                                        学号
                                                    </b>
                                                </td>
                                                <td>
                                                    <?php echo (session('num')); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;"><b>长号</b></td>
                                                <td><?php echo (session('lphonenum')); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;"><b>短号</b></td>
                                                <td><?php echo (session('sphonenum')); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;"><b>书院寝室号</b></td>
                                                <td><?php echo (session('room')); ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;"><b>火车终点站</b></td>
                                                <td><?php echo (session('train')); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>                               
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
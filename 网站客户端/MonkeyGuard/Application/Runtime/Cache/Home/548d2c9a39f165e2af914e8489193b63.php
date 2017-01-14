<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MonkeyGuard</title>

    <!-- Bootstrap Core CSS -->
    <link href="/MonkeyGuard/Public/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="/MonkeyGuard/Public/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/MonkeyGuard/Public/dist/css/sb-admin-2.css" rel="stylesheet">
    <script type="text/javascript" src="/MonkeyGuard/Public/js/flowplayer-3.2.8.min.js"></script>
    <!-- Custom Fonts -->
    <link href="/MonkeyGuard/Public/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(".scroll").click(function(event){
                event.preventDefault();
                $('html,body').animate({scrollTop:$(this.hash).offset().top},900);
            });
        });
    </script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <!--<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>-->
        <!--<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>-->
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">安全家居管理平台</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                <li class="divider"></li>
                <li><a href="<?php echo U('logOut');?>"><i class="fa fa-sign-out fa-fw"></i>退出</a>
                </li>
                </li>
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="搜索...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="<?php echo U('index');?>"><i class="fa fa-dashboard fa-fw"></i>首页</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i>室内环境<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo U('temp');?>">温度</a>
                                </li>
                                <li>
                                    <a href="<?php echo U('fire');?>">火焰</a>
                                </li>
                                <li>
                                    <a href="<?php echo U('gas');?>">可燃气体</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="<?php echo U('tables');?>?type=drop"><i class="fa fa-male fa-fw"></i> 老人检测</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> 防盗系统<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo U('lists');?>">人脸识别库</a>
                                </li>
                                <li>
                                    <a href="<?php echo U('blank');?>">视频监控</a>
                                </li>
                                <li>
                                    <a href="<?php echo U('doortables');?>?type=door">家门打开</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="<?php echo U('Index/contact');?>"><i class="fa fa-files-o fa-fw"></i> 联系我们</a>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">监控录像</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            监控视频
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <a
                                    href="#"
                                    style="display:block;width:900px;height:500px"
                                    id="player">

                            </a>
                            <script>
                                flowplayer("player", "/MonkeyGuard/Public/flowplayer-3.2.8.swf",{
                                    clip: {
                                        url: 'livestream',
                                        provider: 'rtmp',
                                        live: true,
                                    },
                                    plugins: {
                                        rtmp: {
                                            url: 'flowplayer.rtmp-3.2.8.swf',
                                            netConnectionUrl: 'rtmp://115.29.109.27:1935/live'
                                        }
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="/MonkeyGuard/Public/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/MonkeyGuard/Public/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="/MonkeyGuard/Public/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="/MonkeyGuard/Public/dist/js/sb-admin-2.js"></script>

</body>

</html>
<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="">
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

    <!-- Morris Charts CSS -->
    <link href="/MonkeyGuard/Public/vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/MonkeyGuard/Public/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <!--<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>-->
        <!--<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>-->
    <!--<![endif]&ndash;&gt;-->

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
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>室内环境<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo U('flot');?>">温度</a>
                                </li>
                                <li>
                                    <a href="flot.html">火焰</a>
                                </li>
                                <li>
                                    <a href="morris.html">可燃气体</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="tables.html"><i class="fa fa-male fa-fw"></i> 老人检测</a>
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
                                    <a href="<?php echo U('tables');?>">家门打开</a>
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

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header" >本月情况</h1>
                </div>
                <div class="col-lg-12">
                    <h4 style="margin-top: 0px; font-size: 16px">异常指数/天</h4>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-2 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-sun-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo ($temp); ?></div>
                                    <div>温度</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">详情</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa  fa-dashboard  fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo ($fire); ?></div>
                                    <div>火焰</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">详情</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa  fa-life-ring fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo ($gas); ?></div>
                                    <div>可燃气体</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">详情</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-camera fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo ($lalal); ?></div>
                                    <div>家门</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">详情</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-male fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo ($old); ?></div>
                                    <div>老人</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">详情</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i>每日异常次数
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="morris-area-chart"></div>
                </div>
                <!-- /.panel-body -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h6 class="page-header" style="margin-top: 0px"></h6>
                </div>
                <div class="col-lg-12">
                    <h4 style="margin-top: 0px; font-size: 16px">室内环境</h4>
                </div>
            </div>

            <!--&lt;!&ndash; /.row &ndash;&gt;开始分列-->
            <div class="row">
                <div class="col-lg-8">
                    <!-- /.panel -->
                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> 本月异常情况详情
                            <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        温度
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="<?php echo U('index');?>?chose=1">温度</a></li>
                                        <li><a href="<?php echo U('index');?>?chose=2">火焰</a></li>
                                        <li><a href="<?php echo U('index');?>?chose=3">可燃气体</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="row">

                                <!-- /.col-lg-4 (nested) -->
                                <div class="col-lg-12">
                                    <div id="morris-bar-chart"></div>
                                </div>
                                <!-- /.col-lg-8 (nested) -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>

                </div>
                <!-- /.col-lg-8 -->
                <div class="col-lg-4">

                    <div class="panel panel-default" >
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> 异常天数
                        </div>
                        <div class="panel-body">
                            <div id="morris-donut-chart"></div>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-4 -->

                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            异常数据 --<?php echo ($sensor); ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>传感器</th>
                                    <th>数据</th>
                                    <th>日期</th>
                                    <th>时间</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(is_array($abT)): $i = 0; $__LIST__ = $abT;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vi): $mod = ($i % 2 );++$i;?><tr>
                                        <td><?php echo ($vi["id"]); ?></td>
                                        <td><?php echo ($sensor); ?></td>
                                        <td><?php echo ($vi["num"]); ?></td>
                                        <td><?php echo ($vi["time"]); ?></td>
                                        <td><?php echo ($vi["time"]); ?></td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- /.table-responsive -->
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header" >陌生人识别</h1>
                </div>

                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            本月异常开门
                        </div>
                    <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>日期</th>
                                        <th>时间</th>
                                    </tr>
                                    </thead>
                                    <?php if(is_array($door)): $i = 0; $__LIST__ = $door;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vi): $mod = ($i % 2 );++$i;?><tr>
                                            <td><?php echo ($vi["id"]); ?></td>
                                            <td><?php echo ($vi["time"]); ?></td>
                                            <td><?php echo ($vi["time"]); ?></td>
                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!--存放照片-->

                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            本月新添标记
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>日期</th>
                                        <th>时间</th>
                                        <th>标记</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr>
                                        <td>3319</td>
                                        <td>2016-11-01</td>
                                        <td>10:48:31</td>
                                        <td>同学1</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- /.row -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header" >老人安全</h1>
                </div>

                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            异常信息
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>日期</th>
                                        <th>时间</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($drop)): $i = 0; $__LIST__ = $drop;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vi): $mod = ($i % 2 );++$i;?><tr>
                                            <td><?php echo ($vi["id"]); ?></td>
                                            <td><?php echo ($vi["time"]); ?></td>
                                            <td><?php echo ($vi["time"]); ?></td>
                                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /.row -->
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

    <!-- Morris Charts JavaScript -->
    <script src="/MonkeyGuard/Public/vendor/raphael/raphael.min.js"></script>
    <script src="/MonkeyGuard/Public/vendor/morrisjs/morris.min.js"></script>
    <!--<script src="/MonkeyGuard/Public/data/morris-data.js"></script>-->
    <script type="text/javascript">
        $(function() {

            Morris.Area({
                element: 'morris-area-chart',
                data: [<?php echo ($data); ?>],
                xkey: 'time',
                ykeys: ['temp', 'fire', 'fog'],
                labels: ['温度', '火焰', '可燃气体'],
                pointSize: 2,
                hideHover: 'auto',
                resize: true
            });

            Morris.Donut({
                element: 'morris-donut-chart',
                data: [{
                    label: "温度",
                    value: <?php echo ($temp); ?>
                }, {
                    label: "火焰",
                    value: <?php echo ($fire); ?>
                }, {
                    label: "可燃气体",
                    value: <?php echo ($gas); ?>
                }],
                resize: true
            });

            Morris.Line({
                element: 'morris-bar-chart',
                data: [<?php echo ($data1); ?>],
                xkey: 'time',
                ykeys: ['sensor'],
                labels: ['<?php echo ($sensor); ?>'],
                hideHover: 'auto',
                resize: true
            });

        });
    </script>

    <!-- Custom Theme JavaScript -->
    <script src="/MonkeyGuard/Public/dist/js/sb-admin-2.js"></script>

</body>

</html>
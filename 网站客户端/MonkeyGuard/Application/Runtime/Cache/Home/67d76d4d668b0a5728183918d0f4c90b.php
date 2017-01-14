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

    <!-- DataTables CSS -->
    <link href="/MonkeyGuard/Public/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="/MonkeyGuard/Public/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/MonkeyGuard/Public/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/MonkeyGuard/Public/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
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
                <h1 class="page-header">家门异常打开</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo ($month); ?>月异常打开时间详情
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>日期</th>
                                <th>时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(is_array($array)): $i = 0; $__LIST__ = $array;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$array): $mod = ($i % 2 );++$i;?><tr>
                                    <td><?php echo ($array["id"]); ?></td>
                                    <td><?php echo ($array["date"]); ?></td>
                                    <td><?php echo ($array["time"]); ?></td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table>
                        <!-- /.table-responsive -->
                        <div class="panel-heading">
                            <a href="<?php echo U('lastdoor');?>?month=1"><button type="button" class="btn btn-outline btn-default">01月</button></a>
                            <a href="<?php echo U('lastdoor');?>?month=2"><button type="button" class="btn btn-outline btn-primary">02月</button></a>
                            <a href="<?php echo U('lastdoor');?>?month=3"><button type="button" class="btn btn-outline btn-success">03月</button></a>
                            <a href="<?php echo U('lastdoor');?>?month=4"><button type="button" class="btn btn-outline btn-info">04月</button></a>
                            <a href="<?php echo U('lastdoor');?>?month=5"><button type="button" class="btn btn-outline btn-warning">05月</button></a>
                            <a href="<?php echo U('lastdoor');?>?month=6"><button type="button" class="btn btn-outline btn-danger">06月</button></a>
                            <a href="<?php echo U('lastdoor');?>?month=7"><button type="button" class="btn btn-outline btn-default">07月</button></a>
                            <a href="<?php echo U('lastdoor');?>?month=8"><button type="button" class="btn btn-outline btn-primary">08月</button></a>
                            <a href="<?php echo U('lastdoor');?>?month=9"><button type="button" class="btn btn-outline btn-success">09月</button></a>
                            <a href="<?php echo U('lastdoor');?>?month=10"><button type="button" class="btn btn-outline btn-info">10月</button></a>
                            <a href="<?php echo U('lastdoor');?>?month=11"><button type="button" class="btn btn-outline btn-warning">11月</button></a>
                            <a href="<?php echo U('lastdoor');?>?month=12"><button type="button" class="btn btn-outline btn-danger">12月</button></a>
                        </div>
                    </div>

                    <!-- /.panel-body -->
                </div>
                <a href="<?php echo U('tables');?>?year=last"><button type="button" class="btn btn-outline btn-primary">查看所有记录</button></a>

                <!-- /.panel -->
            </div>
            <!--<div class="col-lg-12">-->
            <!--<div class="panel panel-default">-->
            <!--<div class="panel-heading">-->
            <!--今年每月摔倒次数统计-->
            <!--</div>-->
            <!--&lt;!&ndash; /.panel-heading &ndash;&gt;-->
            <!--<div class="panel-body">-->
            <!--<div id="morris-area-chart"></div>-->
            <!--</div>-->
            <!--&lt;!&ndash; /.panel-body &ndash;&gt;-->
            <!--</div>-->
            <!--&lt;!&ndash; /.panel &ndash;&gt;-->
            <!--</div>-->
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <!-- /.row -->
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

<!-- DataTables JavaScript -->
<script src="/MonkeyGuard/Public/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="/MonkeyGuard/Public/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="/MonkeyGuard/Public/vendor/datatables-responsive/dataTables.responsive.js"></script>
<script src="/MonkeyGuard/Public/data/morris-data.js"></script>
<!-- Custom Theme JavaScript -->
<script src="/MonkeyGuard/Public/dist/js/sb-admin-2.js"></script>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>

</body>

</html>
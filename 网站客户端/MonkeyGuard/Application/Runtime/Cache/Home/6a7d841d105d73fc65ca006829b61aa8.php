<?php if (!defined('THINK_PATH')) exit();?><!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!doctype html>
<html>
	<head>
		<title>烟雾</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="refresh" content="20">
		<meta name="keywords" content="Play-Offs Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
		<script type="application/x-javascript"> addEventListener("load", function() {setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		<!meta charset utf="8">
		<!--bootstrap-->
		<link href="/monkeyguard/Public/css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<!--coustom css-->
		<link href="/monkeyguard/Public/css/style.css" rel="stylesheet" type="text/css"/>
		<!--script-->
		<script src="/monkeyguard/Public/js/jquery-2.1.4.min.js"></script>
		<script src="/monkeyguard/Public/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="/monkeyguard/Public/js/move-top.js"></script>
		<script type="text/javascript" src="/monkeyguard/Public/js/easing.js"></script>

		<!--line-->
		<!--<script type="text/javascript" src="/monkeyguard/Public/jss/jquery.min.js"></script>-->
		<script src="/monkeyguard/Public/jss/highcharts.js"></script>
		<script src="/monkeyguard/Public/jss/modules/exporting.js"></script>
		<style type="text/css">
			${demo.css}
		</style>

		<!--fonts-->
		<link href='http://fonts.googleapis.com/css?family=Quicksand:300,400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
		<!--script-->
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},900);
				});
			});

			<!--line-->
			$(function () {
				$('#container').highcharts({
					chart: {
						type: 'line'
					},
					title: {
						text: '<?php echo ($name); ?>'
					},
//					subtitle: {
////						text: 'Source:'
//					},
					xAxis: {
						categories: [<?php echo ($data0); ?>]//这里应该输入时间
					},
					yAxis: {
						title: {
							text: '火焰值'
						}
					},
					tooltip: {
						backgroundColor: {
							linearGradient: [0, 0, 0, 60],
							stops: [
								[0, '#FFFFFF'],
								[1, '#E0E0E0']
							]
						},
						borderWidth: 1,
						borderColor: '#AAA',
						headerFormat: '<table>',
						pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
						'<td style="padding:0"></td>'+'<td>{point.y:.1f}</td></tr>',
						footerFormat: '</table>',
						shared: true,
						useHTML: true
					},
					plotOptions: {
						line: {
							dataLabels: {
								enabled: false
							},
							enableMouseTracking: true
						}
					},
					series: [{
						name: '<?php echo ($high); ?>',
						data: [<?php echo ($data); ?>]
					}, {
						name: '<?php echo ($low); ?>',
						data: [<?php echo ($data1); ?>]
					}]
				});
			});
		</script>
	</head>
	<body>
		<!--header-part-->
		<div class="banner-background" id="to-Top">
			<div class="container">
				<div class="nav-back">
					<div class="navigation">
						<nav class="navbar navbar-default">
							<!-- Brand and toggle get grouped for better mobile display -->
							<div class="navbar-header">
							  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							  </button>
							</div>
							<!-- Collect the nav links, forms, and other content for toggling -->
							<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
								<ul class="nav navbar-nav">
									<li><a  href="<?php echo U('index');?>">首页 <span class="sr-only">(current)</span></a></li>
									<li class="dropdown">
										<a href="<?php echo U('temp');?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">温度变化<span class="caret"></span></a>
										<ul class="dropdown-menu">
											<!--<li><a href="<?php echo U('temp');?>?id=1">今日湿度</a></li>-->
											<li><a href="<?php echo U('temp');?>">今日温度</a></li>
											<li><a href="<?php echo U('recent');?>">最近七日温度</a></li>
										</ul>
									</li>
									<li><a class="active" href="<?php echo U('fog');?>" >火焰强度</a></li>
									<li><a href="<?php echo U('gas');?>">可燃气体</a></li>
									<li><a href="<?php echo U('video');?>">监控录像</a></li>
									<li><a href="<?php echo U('contact');?>">联系我们</a></li>
								</ul>
							</div><!-- /.navbar-collapse -->
								<div class="clearfix"></div>
							<div class="clearfix"></div>
						</nav>
						<div class="clearfix"></div>
					</div>
					<div class="logo">
						<h1><a href="index.html">Monkey<span class="hlf">Guard</span></a></h1>
					</div>
				</div>
			</div>
		</div>
		<!--header-->
		<!--services-->
			<div class="services">
				<div class="container">
					<div class="service-list">
						<h3>火焰传感器</h3>
						<div>
							<form action="" method="GET" class="center" >
								<div class="" data-date="" data-date-format="yyyy-mm-dd"  >
									<div style="margin-left:35%; float: left; width: 30%; height: 40px"><input class="form-control"name="begin" size="10"  data-rule="required" type="date" value=""  onblur="checkDateInput(this)"></div>
									<div style="margin-left:1%; float: left; width: 5%; height: 40px"><input class="btn btn-danger" type="submit" value="搜索" style="height: 32px"></div>
									<div style="clear: both"></div>
								</div >
							</form>
						</div>
						<!--line-->
						<script src="/monkeyguard/Public/jss/highcharts.js"></script>
						<script src="/monkeyguard/Public/jss/modules/exporting.js"></script>

						<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
					</div>
				</div>
			</div>
		<!--services-->
		<!--footer-->
		<div class="footer">

			<div class="col-md-3 brk5">
				<div class="copy-rt">
					<h4>COPYRIGHT</h4>
				</div>
			</div>
			<div  style="padding-top: 80px; padding-left: 550px">
				<p>MonkeyGuard &#169 2016 Design by Monkey</p>
			</div>
			<div class="clearfix"></div>
		</div>
		<!--footer-->
		<!---->
		<script type="text/javascript">
				$(document).ready(function() {
						/*
						var defaults = {
						containerID: 'toTop', // fading element id
						containerHoverID: 'toTopHover', // fading element hover id
						scrollSpeed: 1200,
						easingType: 'linear' 
						};
						*/
				$().UItoTop({ easingType: 'easeOutQuart' });
		});
		</script>
		<a href="#to-top" id="toTop" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
		<!----> 
	</body>
</html>
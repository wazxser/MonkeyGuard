<?php if (!defined('THINK_PATH')) exit();?><!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!doctype html>
<html>
	<head>
		<title>监控录像</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="Play-Offs Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
		<script type="application/x-javascript"> addEventListener("load", function() {setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		<script type="text/javascript" src="/monkeyguard/Public/js/flowplayer-3.2.8.min.js"></script>
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
		</script>
	</head>
	<body>
		<!--header-part-->
		<div class="banner-background">
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
									<li><a href="<?php echo U('fog');?>" >火焰强度</a></li>
									<li><a href="<?php echo U('gas');?>">可燃气体</a></li>
									<li><a class="active" href="<?php echo U('video');?>">监控录像</a></li>
									<li><a href="<?php echo U('contact');?>">联系我们</a></li>
								</ul>

							</div><!-- /.navbar-collapse -->
								<div class="clearfix"></div>
							<div class="clearfix"></div>
						</nav>
						<div class="clearfix"></div>
					</div>
					<div class="logo">
						<h1><a href="index.html">Monkey<span class="hlf"> Guard</span></a></h1>
					</div>
				</div>
			</div>
		</div>
		<!--header-->
		<!--contact-->
			<div class="contact-page">
				<h3>监控录像</h3>
				<div class="container">

					<!--video-->
					<!-- this A tag is where your Flowplayer will be placed. it can be anywhere -->
					<div align="center" ><div
							href="#"
							style="display:block;width:900px;height:500px"
							id="player">
					</div>
					</a>
					<!-- this will install flowplayer inside previous A- tag. -->
					<script>
						flowplayer("player", "/monkeyguard/Public/flowplayer-3.2.8.swf",{
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
		<!--contact-->
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
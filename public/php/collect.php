<?php
include 'checklevel.php';
$login=false;
$level=0;
$username='';
session_start();
if(!empty($_SESSION['username'])){
	$username=$_SESSION['username'];
	$level=checklevel($conn,$username);
	if($level!=3){
		echo "请勿尝试非法绕过系统";
		header("location:/index.php");
	}
	$login=true;
}
else{
	echo '请先登录!';
	header("location:/index.php");
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="/public/img/icon.ico">

	<title>广工咸鱼网</title>

	<!-- Bootstrap core CSS -->
	<!--<link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">-->
	<link href="/public/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="/public/css/start.css" rel="stylesheet">
	<link href="/public/css/footer.css" rel="stylesheet">
  </head>

  <body>
	<!-- 导航栏 -->
	<nav class="navbar navbar-inverse navbar-fixed-top">
	  <div class="container">
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand">收藏</a>
		</div>
		<div id="navbar" class="collapse navbar-collapse">
		  <ul class="nav navbar-nav">
			<!-- 这里做了修改 -->
			<li><a href="/index.php">主页</a></li>
            <?php
            if($login){
			echo '<li > <a href="/public/php/order.php" >订单</a></li>';
			echo '<li class="active" > <a href="/public/php/collect.php" >收藏</a></li>';
			echo '<li > <a href="/public/php/logout.php" >注销</a></li>';
            }
            else{
                echo '<li > <a href="#login" data-toggle="modal" data-target="#login">登录</a></li>	';		
		echo '<li >  <a href="#register" data-toggle="modal" data-target="#register">注册</a></li>';
    
            }
            ?>
		  </ul>
		</div><!--/.nav-collapse -->
	  </div>
	</nav>
	<footer class="footer">
		<div class="container">
		<p class="text-muted">
		  <h2><a href="http://www.moyingliu.cn" title="www.moyingliu.cn" style="color: blue;">www.moyingliu.cn</a></h2>
		</p>
        </div>
	</footer>
  </body>
    <script src="/public/js/jquery.min.js"></script>
	<script src="/public/js/bootstrap.min.js"></script>
<script src="/public/js/vertify.js"></script>
	<script src="/public/js/check.js"></script>
</html>

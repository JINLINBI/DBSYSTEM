<?php
include 'conn.php';
include 'checklevel.php';
session_start();
if(!empty($_SESSION['username'])){	//判断是否登录
	$username=$_SESSION['username'];	//提取用户名

	$level=checklevel($conn,$username);	//判断用户类型
	if($level!=3){				//检查是否其他用户非法提交数据
		echo "请勿尝试非法绕过系统";
		header("location:/index.php");
	}

	$sql="SELECT * FROM USER U1,ORDERTABLE,GOOD,USER U2 WHERE U1.USERNAME='$username' AND U1.UID=ORDERTABLE.UID AND ORDERTABLE.GID=GOOD.GID AND GOOD.UID=U2.UID";
	$result=mysqli_query($conn,$sql);	//连接查询数据库三个表
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
	<link rel="icon" href="public/img/icon.ico">

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
		  <a class="navbar-brand" >订单中心</a>
		</div>
		<div id="navbar" class="collapse navbar-collapse">
		  <ul class="nav navbar-nav">
			<!-- 这里做了修改 -->
			<li ><a href="/index.php">主页</a></li>
			<li class="active"><a href="/public/php/order.php">订单</a></li>
            		<li > <a href="/public/php/logout.php" >注销</a></li>
		  </ul>
		</div><!--/.nav-collapse -->
	  </div>
	</nav>
	<!-- 页面主体内容 -->
	<div class="container">
		<div class="order_info">
				<div class="form-group">
					<h3>订单信息</h3>
				</div>
<?php while($good_array=mysqli_fetch_array($result)){?>
				<div class="form-group">
					<input type="text" name="gid" value="<?php echo $good_array['GID'];?>" class="hidden">
					<label for="gname" >商品名:</label>
					<span name="gname" ><?php echo $good_array['GNAME']?></span>
					<label for="gprice" >商品价格:</label>
					<span name="gprice"><?php echo $good_array['GPRICE']."元"?></span>
					<label for="ginfo" >商品信息:</label>
					<span name="ginfo"><?php echo $good_array['GINFO']?></span>
					<label for="sinfo" >商家手机:</label>
					<span name="sinfo"><?php echo $good_array['CONTACT']?></span>
					<label for="smail" >商家E-mail:</label>
					<span name="smail"><?php echo $good_array['EMAIL']?><span>
				</div>
<?php }?>
		</div>
		
		
	</div>
	<!-- 网页底部 -->
  </body>
    <script src="/public/js/jquery.min.js"></script>
	<script src="/public/js/bootstrap.min.js"></script>
<script src="/public/js/vertify.js"></script>
	<script src="/public/js/check.js"></script>
</html>

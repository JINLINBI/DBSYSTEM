<?php
include 'checklevel.php';
include 'conn.php';
include 'safe.php';
$login=false;
$level=0;
$username='';
session_start();
if(!empty($_SESSION['username'])){
	$username=$_SESSION['username'];
	$level=checklevel($conn,$username);
	$login=true;
	
}
$result=mysqli_query($conn,"SELECT * FROM GOOD");

/*
<div id="myCarousel" class="carousel slide">
    <!-- 轮播（Carousel）指标 -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>   
    <!-- 轮播（Carousel）项目 -->
    <div class="carousel-inner" width="100%" height="600">
        <div class="item active">
            <img src="/public/img/kenan.jpeg" alt="First slide" width="100%" height="80%" >
        </div>
        <div class="item">
            <img src="/public/img/may.jpg" alt="Second slide" width="100%" height="80%">
        </div>
        <div class="item">
            <img src="/public/img/iphone.jpg" alt="Third slide" width="100%" height="80%">
        </div>
    </div>
    <!-- 轮播（Carousel）导航 -->
    <a class="carousel-control left" href="#myCarousel" 
        data-slide="prev">&lsaquo;
    </a>
    <a class="carousel-control right" href="#myCarousel" 
        data-slide="next">&rsaquo;
    </a>
</div>
*/

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
		  <a class="navbar-brand" href="/index.php">广工咸鱼网</a>
		</div>
		<div id="navbar" class="collapse navbar-collapse">
		  <ul class="nav navbar-nav">
			<!-- 这里做了修改 -->
			<li class="active"><a href="/index.php">主页</a></li>
            <?php
            if($login){
				if($level==3){
                    echo '<li > <a href="/public/php/order.php" >订单</a></li>';
                    echo '<li > <a href="/public/php/collect.php" >收藏</a></li>';
				}
				else if($level==2){
                    echo '<li > <a href="/public/php/statistic.php" >统计</a></li>';
                    echo '<li > <a href="/public/php/sale.php" >卖咸鱼</a></li>';
                    echo '<li > <a href="/public/php/self.php" >个人中心</a></li>';
				}
				else if($level==1){
                    echo '<li > <a href="/public/php/statistic.php" >统计</a></li>';
                    echo '<li > <a href="/public/php/self.php" >个人中心</a></li>';
                    echo '<li > <a href="/public/php/manage.php" >管理</a></li>';
				}
                    echo '<li > <a href="public/php/logout.php" >注销</a></li>';
            }
            else{
                echo '<li > <a href="#login" data-toggle="modal" data-target="#login">登录</a></li>			
			          <li >  <a href="#register" data-toggle="modal" data-target="#register">注册</a></li>';
    
            }
            ?>	
			
		  </ul>
			<form action="/public/php/search.php" method="post" class="navbar-form navbar-right" >
				<div class="form-group">
				<input class="form-control" type="text" name="search" placeholder="Search">
				<button class="btn btn-success" type="submit" name="submit" >搜索</button>
				</div>
			</form>
		</div><!--/.nav-collapse -->
	  </div>
	</nav>
	<!-- 页面主体内容 -->
	<div class="container">
		<div >
			<table class="table table-condensed table-bordered">
			<?php
				$search=safe_string($_POST['search']);
				$result=mysqli_query($conn,"SELECT SUM(*) FROM GOOD WHERE GNAME LIKE '%$search%' OR GPRICE LIKE '%$search%' OR GINFO LIKE '%$search%'");
				if($result && $sum=mysqli_fetch_array($result)){
					echo "<h3>搜索到".$sum['SUM(*)']."件商品.</h3>";
				}

			?>
			<tr><th>商品名</th><th>商品价格</th><th>商品信息</th></tr>
			<?php
				$result=mysqli_query($conn,"SELECT * FROM GOOD WHERE GNAME LIKE '%$search%'  OR GPRICE LIKE '%$search%' OR GINFO LIKE '%$search%'");
				while($array=mysqli_fetch_array($result)){
				?>
				<tr>
				<td><?php echo $array['GNAME']?></td>
				<td><?php echo $array['GPRICE']?></td>
				<td><?php echo $array['GINFO']?></td>
				</tr>
			<?php }?>
			</table>
		</div>
	</div>

  </body>
	<script src="/public/js/jquery.min.js"></script>
	<script src="/public/js/bootstrap.min.js"></script>
	<script src="/public/js/vertify.js"></script>
	<script src="/public/js/check.js"></script>
</html>

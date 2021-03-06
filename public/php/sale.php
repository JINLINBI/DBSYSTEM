<?php			///该文件实现商家刊登商品信息
include 'checklevel.php';	//引入查询用户类型的函数
include 'conn.php';		//引入数据库连接文件
include 'safe.php';		//引入安全过滤函数
$login=false;			//登录状态变量
$level=0;			//用户类型变量
$username='';			//用户名
session_start();		//开始会话
if(!empty($_SESSION['username'])){	//判断是否登录
	$username=$_SESSION['username'];	//提取用户名
	$level=checklevel($conn,$username);	//查询用户类型
	$login=true;				//登录
}else{
	echo "您还没有登录,请先登录在操作!";	
	header("location:/index.php");
}
if(!empty($_POST['goodname']) && !empty($_POST['goodprice']) && !empty($_POST['goodinfo'])){ //检查商家发普的信息是否全都提交
	$goodname=($_POST['goodname']);		//过滤
	$goodprice=($_POST['goodprice']);		//..
	$goodinfo=($_POST['goodinfo']);		//..


	$sql="SELECT UID FROM USER WHERE USERNAME='$username'";	
	$uid_result=mysqli_query($conn,$sql);		//查询用户信息
	$uid_array=mysqli_fetch_array($uid_result);	//提取row(元组)
	$uid=$uid_array['UID'];				//得到商家的uid

	$gid_result=mysqli_query($conn,"SELECT MAX(GID) FROM GOOD ");	//查询商品信息
	$gid_array=mysqli_fetch_array($gid_result);		
	$gid=(string) (1+(int)($gid_array['MAX(GID)']));	//得到商品的gid


	$insert="INSERT INTO GOOD VALUES('$gid','$uid','$goodname','$goodprice','$goodinfo')"; 	//构造商家发布商品的sql语句
	
	if(mysqli_query($conn,$insert)){	
		$isinsert=true;		//成功
	}else{
		$isinsert=false;	//失败
	}
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

	<title>卖咸鱼</title>

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
		  <a class="navbar-brand" href="">卖咸鱼</a>
		</div>
		<div id="navbar" class="collapse navbar-collapse">
		  <ul class="nav navbar-nav">
			<!-- 这里做了修改 -->
			<li><a href="/index.php">主页</a></li>
            <?php
            if($login){
                    echo '<li > <a href="/public/php/statistic.php" >统计</a></li>';
                    echo '<li class="active" > <a href="/public/php/sale.php" >卖咸鱼</a></li>';
                    echo '<li > <a href="/public/php/self.php" >个人中心</a></li>';
                    echo '<li > <a href="/public/php/logout.php" >注销</a></li>';
            }
            else{
                echo '<li > <a href="#login" data-toggle="modal" data-target="#login">登录</a></li>			
			          <li >  <a href="#register" data-toggle="modal" data-target="#register">注册</a></li>';
    
            }
            ?>
		  </ul>
		</div><!--/.nav-collapse -->
	  </div>
	</nav>
	<!-- 网页底部 -->
	<div class="container">
		<div>
			<form action="/public/php/sale.php" method="post">
				<div class="form-group">
				<label class="col-ms-8 control-label" style="color:red" >
<?php
if(isset($isinsert) && $isinsert==true){
	echo "<h4>提交商品信息成功!</h4>"; 	//成功时打印
}
else if(isset($isinsert)){
	echo "<h4>提交商品信息失败!</h4>";
}
?></label>
				</div>
				<h3>提交商品信息</h3>
				<div class="form-group">
					<label class="col-ms-4 control-label" for="goodname">商品名:</label>
					<div class="col-ms-5">
					<input type="text" class="form-control" name="goodname" id="goodname">	
					</div>
				</div>
				<div class="form-group">
					<label class="col-ms-4 control-label"for="goodprice">商品价格(元):</label>
					<div class="col-ms-5">
					<input type="text" class="form-control" name="goodprice" id="goodprice">	
					</div>
				</div>
				<div class="form-group">
					<label class="col-ms-4 control-label" for="goodinfo">商品信息:</label>
					<div class="col-ms-5">
					<input type="text" class="form-control" name="goodinfo" id="goodinfo" width="400px">	
					</div>
				</div>
				<div class="form-group">
					<label class="col-ms-4 control-label" for="submit">提交:</label>
					<div class="col-ms-5">
					<button type="submit" class="btn btn-primary" name="submit" id="submit" >提交</button>
					</div>
				</div>
			</form>
		</div>
	</div>

  </body>
    <script src="/public/js/jquery.min.js"></script>
	<script src="/public/js/bootstrap.min.js"></script>
<script src="/public/js/vertify.js"></script>
	<script src="/public/js/check.js"></script>
</html>

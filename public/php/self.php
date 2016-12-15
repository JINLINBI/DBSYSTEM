<?php
include 'conn.php';
include 'checklevel.php';
session_start();
$msg='';
$passwordmsg='';
if(!empty($_SESSION['username'])){
	$username=$_SESSION['username'];
	$level=checklevel($conn,$username);
	if($level!=1 && $level!=2){
		echo "请勿尝试非法绕过系统";
		header("location:/index.php");
	}
	if(!empty($_POST['contact']) || !empty($_POST['email'])){
		$username=$_SESSION['username'];
		$email=$_POST['email'];
		$contact=$_POST['contact'];
		$level=checklevel($conn,$username);
		if($level==3){
			echo "请勿尝试非法绕过系统";
			header("location:/pubic/php/self.php");
		}
	//	$sql="SELECT * FROM USER WHERE USERNAME='$username'";
	//	$result=mysqli_query($conn,$sql);
	//	$array=mysqli_fetch_array($result);
		if(mysqli_query($conn,"UPDATE USER SET CONTACT='$contact',EMAIL='$email' WHERE USERNAME='$username'")){
				$msg="修改成功!";
		}else{
			$msg="修改失败!";
		}

	}
		
	if(!empty($_POST['oldpassword']) && !empty($_POST['newpassword']) && !empty($_POST['comfirmpassword']) && $_POST['newpassword']==$_POST['comfirmpassword']){
	$username=$_SESSION['username'];
	$oldpassword=$_POST['oldpassword'];
	$level=checklevel($conn,$username);
	if($level==3){
		echo "请勿尝试非法绕过系统";
		header("location:/index.php");
	}
	$sql="SELECT * FROM USER WHERE USERNAME='$username'";
	$result=mysqli_query($conn,$sql);
	$array=mysqli_fetch_array($result);
	if($array['PASSWD']==sha1($oldpassword)){
		$newpassword=$_POST['newpassword'];
		$newpassword=sha1($newpassword);
		if(mysqli_query($conn,"UPDATE USER SET PASSWD='$newpassword' WHERE USERNAME='$username'")){
			$passwdmsg="修改成功!";
			//header("location:/public/php/self.php");			
		}
	}else{
		$passwdmsg="原密码错误!";
		//header("location:/public/php/self.php");
	}

}

	$sql="SELECT * FROM USER WHERE USERNAME='$username'";
	$result=mysqli_query($conn,$sql);
	$array=mysqli_fetch_array($result);
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
		  <a class="navbar-brand" ><?php echo $username;?>的个人中心</a>
		</div>
		<div id="navbar" class="collapse navbar-collapse">
		  <ul class="nav navbar-nav">
			<!-- 这里做了修改 -->
			<li ><a href="/index.php">主页</a></li>
			<li ><a href="/public/php/statistic.php">统计</a></li>
			<?php if($level==2)echo '<li ><a href="/public/php/sale.php">卖咸鱼</a></li> '?>
			<li class="active"><a href="/public/php/self.php">个人中心</a></li>
			<?php if($level==1)echo '<li ><a href="/public/php/manage.php">管理</a></li> '?>
            		<li > <a href="/public/php/logout.php" >注销</a></li>
		  </ul>
		</div><!--/.nav-collapse -->
	  </div>
	</nav>
	<!-- 页面主体内容 -->
	<div class="container">
		<div class="self_info">
			<h3>个人信息</h3>
			<span style="color:red"><?php echo $msg;?></span>
			<form action="/public/php/self.php" method="post" >
				<div class="form-group">
					<label for="contact" >联系方式:</label>
					<input type="text" name="contact" placeholder="<?php echo $array['CONTACT'];?>" value="<?php echo $array['CONTACT'];?>">
				</div>
				<div class="form-group">
					<label for="email" >E-mail:</label>
					<input type="text" name="email"  placeholder="<?php echo $array['EMAIL']?>" value="<?php echo $array['EMAIL']?>">
				</div>
				<div class="form-group">
					<button class="btn btn-primary" type="submit" name="submit" >修改</button>
				</div>	
			</form>
		</div>
		<div >
			<h3>修改密码</h3>
			<span style="color:red"><?php echo $passwdmsg;?></span>
			<form action="/public/php/self.php" method="post" >
				<div class="form-group">
					<label for="oldpassword" >旧密码:</label>
					<input type="password" name="oldpassword" minlength="2" maxlength="20" >
				</div>
				<div class="form-group">
					<label for="newpassword" >新密码:</label>
					<input type="password" name="newpassword" minlength="2" maxlength="20" >
				</div>
				<div class="form-group">
					<label for="confirmpassword" >确认密码:</label>
					<input type="password" name="comfirmpassword" minlength="2" maxlength="20">
				</div>
				<div class="form-group">
					<button class="btn btn-primary" type="submit" name="submit" >修改</button>
				</div>	
			</form>
		</div>
		<?php
			
		?>
		
	</div>
	<!-- 网页底部 -->
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

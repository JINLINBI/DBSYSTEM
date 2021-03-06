<?php		//该文实现修改密码和修改个人信息的功能
include 'conn.php';		//连接数据库文件
include 'checklevel.php';	//检查用户类型文件
session_start();		//开始会话
$msg='';			//需打印修改个人信息的变量
$passwdmsg='';		//提示修改密码是否成功用到的变量
if(!empty($_SESSION['username'])){		//判断是否登录
	$username=$_SESSION['username'];	//提取用户名
	$level=checklevel($conn,$username);	//检查用户类型
	if($level!=1 && $level!=2){		//判断是否是管理员或商家
		echo "请勿尝试非法绕过系统";
		header("location:/index.php");
	}
	if(!empty($_POST['contact']) || !empty($_POST['email'])){	//判断提交的个人信息是否为空
		$username=$_SESSION['username'];			//用户名
		$email=$_POST['email'];					//email
		$contact=$_POST['contact'];				//手机号
		if(mysqli_query($conn,"UPDATE USER SET CONTACT='$contact',EMAIL='$email' WHERE USERNAME='$username'")){		//数据库查询语句
				$msg="修改成功!";
		}else{
				$msg="修改失败!";
		}

	}
	if(!empty($_POST['oldpassword']) && !empty($_POST['newpassword']) && !empty($_POST['comfirmpassword']) && $_POST['newpassword']==$_POST['comfirmpassword']){	//判断提交的参数是否有空
	$username=$_SESSION['username'];	//用户名
	$oldpassword=$_POST['oldpassword'];	//密码
	$sql="SELECT * FROM USER WHERE USERNAME='$username'";	//查询用户的信息
	$result=mysqli_query($conn,$sql);
	$array=mysqli_fetch_array($result);
	if($array['PASSWD']==sha1($oldpassword)){		//判断提交的旧密码和数据库中的记录是否相同
		$newpassword=$_POST['newpassword'];		
		$newpassword=sha1($newpassword);
		if(mysqli_query($conn,"UPDATE USER SET PASSWD='$newpassword' WHERE USERNAME='$username'")){	//更改密码的sql语句查询
			$passwdmsg="修改成功!";		
		}
	}else{
		$passwdmsg="原密码错误!";
	}

}

	$sql="SELECT * FROM USER WHERE USERNAME='$username'";
	$result=mysqli_query($conn,$sql);
	$array=mysqli_fetch_array($result);	//查询用户信息,在下面的表单用到
}
else{
	echo '请先登录!';
	header("location:/index.php");		//重定向到主页
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
					<label  for="contact" class="col-sm-1">联系方式:</label>
					<input  type="text" name="contact" placeholder="<?php echo $array['CONTACT'];?>" value="<?php echo $array['CONTACT'];?>">
				</div>
				<div class="form-group">
					<label  for="email" class="col-sm-1" >E-mail:</label>
					<input type="text" name="email"  placeholder="<?php echo $array['EMAIL']?>" value="<?php echo $array['EMAIL']?>">
				</div>
				<div class="form-group">
					<button class="btn btn-primary" type="submit" name="submit" >修改</button>
				</div>	
			</form>
		</div>
		<div style="margin-top:40px">
			<h3>修改密码</h3>
			<span style="color:red"><?php echo $passwdmsg;?></span>
			<form action="/public/php/self.php" method="post" >
				<div class="form-group">
					<label for="oldpassword" class="col-sm-1">旧密码:</label>
					<input type="password" name="oldpassword" minlength="2" maxlength="20" >
				</div>
				<div class="form-group">
					<label for="newpassword" class="col-sm-1">新密码:</label>
					<input type="password" name="newpassword" minlength="2" maxlength="20" >
					<div ></div>
				</div>
				<div class="form-group">
					<label for="confirmpassword" class="col-sm-1">确认密码:</label>
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
  </body>
    <script src="/public/js/jquery.min.js"></script>
	<script src="/public/js/bootstrap.min.js"></script>
<script src="/public/js/vertify.js"></script>
	<script src="/public/js/check.js"></script>
</html>

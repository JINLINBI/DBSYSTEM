<?php
include 'conn.php';
include 'checklevel.php';
session_start();
$msg='';

if(!empty($_SESSION['username'])){
	$username=$_SESSION['username'];

	$level=checklevel($conn,$username);
	if($level!=1){
		echo "请勿尝试非法绕过系统";
		header("location:/index.php");
	}
	
	if(!empty($_POST['delete'])){				
		if(!empty($_POST['uid']) && empty($_POST['gid']) ){ 
			$uid=$_POST['uid'];
			if(mysqli_query($conn,"DELETE FROM USER WHERE UID='$uid'")){
				$msg="删除成功!";
			}else{
				$msg="删除失败!";
			}
		}	
		else if(!empty($_POST['gid'])){
			$gid=$_POST['gid'];
			if(mysqli_query($conn,"DELETE FROM GOOD WHERE GID='$gid'")){
				$msg="删除成功!";
			}else{
				$msg="删除失败!请检查该商品是否被订购";
			}
		}
	}
	if(!empty($_POST['update'])){
		if(!empty($_POST['uid']) && empty($_POST['gid']) ){ 
			$uid=$_POST['uid'];
			$username=$_POST['username'];
			$usertype=$_POST['usertype'];
			$contact=$_POST['contact'];
			$email=$_POST['email'];
			if(mysqli_query($conn,"UPDATE USER SET USERNAME='$username',USERTYPE='$usertype',CONTACT='$contact',EMAIL='$email' WHERE UID='$uid'")){
				$msg="修改成功!";
			}else{
				$msg="修改失败!";
			}
		}	
		else if(!empty($_POST['gid'])){
			$gid=$_POST['gid'];
			$uid=$_POST['uid'];
			$gname=$_POST['gname'];
			$gprice=$_POST['gprice'];
			$ginfo=$_POST['ginfo'];
			if(mysqli_query($conn,"UPDATE GOOD SET UID='$uid',GNAME='$gname',GPRICE='$gprice',GINFO='$ginfo' WHERE GID='$gid'")){
				$msg="修改成功!";
			}else{
				$msg="修改失败!";
			}
		}
	}
	if(!empty($_POST['insert']) && $_POST['insert']=='user'){
		$username=$_POST['username'];
		$usertype=$_POST['usertype'];
		$phone=$_POST['contact'];
		$email=$_POST['email'];
		$password=sha1("123456");
		$result=mysqli_query($conn,"SELECT MAX(UID) FROM USER");
		if($result->num_rows>0){
			$row=$result->fetch_assoc();
			if((int)$row["MAX(UID)"]<160000000){
				$max=(int)$row["MAX(UID)"]+160000000;
			}else{
				$max=(int)$row["MAX(UID)"];
			}
			$id=(string)($max+1);
		}

		$sql="insert into USER values('$id','$username','$usertype','$password','$phone','$email')";
		if(mysqli_query($conn,$sql)==false){
			$msg="添加失败!";
		}else{
			$msg="添加成功,初始密码是'123456'!";
		}		
	}
	else if(!empty($_POST['insert']) && $_POST['insert']=='good'){
		$uid=$_POST['uid'];
		$gname=$_POST['gname'];
		$gprice=$_POST['gprice'];
		$ginfo=$_POST['ginfo'];
		$result=mysqli_query($conn,"SELECT MAX(GID) FROM GOOD");
		if($result->num_rows>0){
			$row=$result->fetch_assoc();
			if((int)$row["MAX(GID)"]<160000000){
				$max=(int)$row["MAX(GID)"]+160000000;
			}else{
				$max=(int)$row["MAX(GID)"];
			}
			$id=(string)($max+1);
		}
		$sql="INSERT INTO  GOOD VALUES('$id','$uid','$gname','$gprice','$ginfo')";
		if(mysqli_query($conn,$sql)==false){
			$msg="添加失败!";
		}else{
			$msg="添加成功!";
		}
	}
	$sql="SELECT * FROM USER WHERE USERNAME='$username'";
	$result=mysqli_query($conn,$sql);
	$array=mysqli_fetch_array($result);

	$user_sql="SELECT * FROM USER";
	$user_result=mysqli_query($conn,$user_sql);

	$good_sql="SELECT * FROM GOOD";
	$good_result=mysqli_query($conn,$good_sql);
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
		  <a class="navbar-brand" >管理中心</a>
		</div>
		<div id="navbar" class="collapse navbar-collapse">
		  <ul class="nav navbar-nav">
			<!-- 这里做了修改 -->
			<li ><a href="/index.php">主页</a></li>
			<li ><a href="/public/php/statistic.php">统计</a></li>
			<li ><a href="/public/php/self.php">个人中心</a></li>
			<li class="active"><a href="/public/php/manage.php">管理</a></li>
            		<li > <a href="/public/php/logout.php" >注销</a></li>
		  </ul>
		</div><!--/.nav-collapse -->
	  </div>
	</nav>
	<!-- 页面主体内容 -->
	<div class="container">
		<div class="self_info">
			<h3>个人信息</h3>
				<span style="color:red"> <?php echo $msg;?></span>
				<?php
					while($user_array=mysqli_fetch_array($user_result) ){
						if( $user_array['USERTYPE']=='1' )continue;
				?><form action="/public/php/manage.php" method="post" >
					<div class="form-group">
						<input type="text" name="uid" value="<?php echo $user_array['UID'];?>" class="hidden">
						<label for="username" >用户姓名:</label>
						<input type="text" name="username" placeholder="<?php echo $user_array['USERNAME'];?>" value="<?php echo $user_array['USERNAME'];?>">
						<label for="email" >用户级别:</label>
						<input type="text" name="usertype"  placeholder="<?php echo $user_array['USERTYPE']?>" value="<?php echo $user_array['USERTYPE']?>">
						<label for="contact" >联系方式:</label>
						<input type="text" name="contact" placeholder="<?php echo $user_array['CONTACT']?>" value="<?php echo $user_array['CONTACT']?>">
						<label for="email" >E-mail:</label>
						<input type="text" name="email"  placeholder="<?php echo $user_array['EMAIL']?>" value="<?php echo $user_array['EMAIL']?>">
						<button class="btn btn-primary" type="submit" name="update" value="true">修改</button>
						<button class="btn btn-danger" type="submit" name="delete" value="true">删除</button>
					</div>	
				</form>
				<?php }?>
				</form action="/public/php/manage.php" method="post" >
					<div class="form-group">
						<input type="text" name="uid" class="hidden">
						<label for="username" >用户姓名:</label>
						<input type="text" name="username" >
						<label for="email" >用户级别:</label>
						<input type="text" name="usertype" >
						<label for="contact" >联系方式:</label>
						<input type="text" name="contact">
						<label for="email" >E-mail:</label>
						<input type="text" name="email">
						<button class="btn btn-default" type="submit" name="insert" value="user">添加</button>
					</div>	
				</form>
			
		</div>
		<div >
			<h3>修改密码</h3>
			
				<?php
					while($good_array=mysqli_fetch_array($good_result)){
				?><form action="/public/php/manage.php" method="post" >
				<div class="form-group">
					<input type="text" name="gid" value="<?php echo $good_array['GID'];?>" class="hidden">
					<label for="uid" >商家号:</label>
					<input type="text" name="uid" value="<?php echo $good_array['UID'];?>">
					<label for="gname" >商品名:</label>
					<input type="text" name="gname"  placeholder="<?php echo $good_array['GNAME']?>" value="<?php echo $good_array['GNAME']?>">
					<label for="gprice" >商品价格:</label>
					<input type="text" name="gprice" placeholder="<?php echo $good_array['GPRICE'];?>" value="<?php echo $good_array['GPRICE']?>">
					<label for="ginfo" >商品信息:</label>
					<input type="text" name="ginfo"  placeholder="<?php echo $good_array['GINFO']?>" value="<?php echo $good_array['GINFO']?>">
					<button class="btn btn-primary" type="submit" name="update" value="true" >修改</button>
					<button class="btn btn-danger" type="submit" name="delete" value="true">删除</button>
				</div>	</form>
				<?php }?>
			<form action="/public/php/manage.php" method="post" >
				<div class="form-group">
					<input type="text" name="gid"  class="hidden">
					<label for="uid" >商家号:</label>
					<input type="text" name="uid" >
					<label for="gname" >商品名:</label>
					<input type="text" name="gname" >
					<label for="gprice" >商品价格:</label>
					<input type="text" name="gprice">
					<label for="ginfo" >商品信息:</label>
					<input type="text" name="ginfo">
					<button class="btn btn-default" type="submit" name="insert" value="good" >添加</button>
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

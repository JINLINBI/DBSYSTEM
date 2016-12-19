<?php
include 'conn.php';
include 'checklevel.php';
include 'safe.php';
session_start();
$msg='';
$goodmsg='';
$ordermsg='';
if(!empty($_SESSION['username'])){
	$username=$_SESSION['username'];
	$level=checklevel($conn,$username);
	if($level!=1){
		echo "请勿尝试非法绕过系统";
		header("location:/index.php");
	}
	if(!empty($_POST['delete'])){	
		if(!empty($_POST['oid'])){
			$oid=$_POST['oid'];
			if(mysqli_query($conn,"DELETE FROM ORDERTABLE WHERE OID='$oid'")){
				$ordermsg="删除成功!";
			}else{
				$ordermsg="删除失败!";
			}
		}						
		else if(!empty($_POST['uid']) && empty($_POST['gid']) ){ 
			$uid=$_POST['uid'];
			if(mysqli_query($conn,"DELETE FROM USER WHERE UID='$uid'")){//删除用户		
				$msg="删除成功!";
			}else{
				$msg="删除失败!";
			}
		}	
		else if(!empty($_POST['gid'])){
			$gid=$_POST['gid'];
			if(mysqli_query($conn,"DELETE FROM GOOD WHERE GID='$gid'")){
				$goodmsg="删除成功!";
			}else{
				$goodmsg="删除失败!请检查该商品是否被订购";
			}
		}
		
	}

	if(!empty($_POST['update'])){
		if(!empty($_POST['uid']) && empty($_POST['gid']) ){ 		//修改用户数据
			$uid=$_POST['uid'];
			$username=safe_string($_POST['username']);
			$usertype=safe_string($_POST['usertype']);
			$contact=safe_string($_POST['contact']);
			$email=$_POST['email'];
			if(mysqli_query($conn,"UPDATE USER SET USERNAME='$username',USERTYPE='$usertype',CONTACT='$contact',EMAIL='$email' WHERE UID='$uid'")){
				$msg="修改成功!";
			}else{
				$msg="修改失败!";
			}
		}	
		else if(!empty($_POST['gid'])){					//删除商品
			$gid=$_POST['gid'];
			$uid=$_POST['uid'];
			$gname=$_POST['gname'];
			$gprice=$_POST['gprice'];
			$ginfo=$_POST['ginfo'];
			if(mysqli_query($conn,"UPDATE GOOD SET UID='$uid',GNAME='$gname',GPRICE='$gprice',GINFO='$ginfo' WHERE GID='$gid'")){
				$goodmsg="修改成功!";
			}else{
				$goodmsg="修改失败!";
			}
		}
	}
	if(!empty($_POST['insert']) && $_POST['insert']=='user' && !empty($_POST['username'])  && !empty($_POST['usertype'])){		//添加用户
		$username=$_POST['username'];
		$usertype=$_POST['usertype'];
		$phone=$_POST['contact'];
		$email=$_POST['email'];
		$password=sha1("123456");
		if($result=mysqli_query($conn,"SELECT MAX(UID) FROM USER")){
			$row=mysqli_fetch_array($result);
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
	else if(!empty($_POST['insert']) && $_POST['insert']=='good' && !empty($_POST['uid']) && !empty($_POST['gname'])  && !empty($_POST['gprice'])){
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
			$goodmsg="添加失败!";
		}else{
			$goodmsg="添加成功!";
		}
	}
	else if(!empty($_POST['insert']) && $_POST['insert']=='order' ){
		$oid=$_POST['oid'];
		$uid=$_POST['uid'];
		$gid=$_POST['gid'];
		if($result=mysqli_query($conn,"SELECT MAX(OID) FROM ORDERTABLE")){
			$row=mysqli_fetch_array($result);
			if((int)$row["MAX(OID)"]<160000000){
				$max=(int)$row["MAX(OID)"]+160000000;
			}else{
				$max=(int)$row["MAX(OID)"];
			}
			$id=(string)($max+1);
		}
		$sql="INSERT INTO  ORDERTABLE(OID,UID,GID) VALUES('$id','$uid','$gid')";
		if(mysqli_query($conn,$sql)==false){
			$ordermsg="添加失败!";
		}else{
			$ordermsg="添加成功!";
		}
	}
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
					$user_sql="SELECT * FROM USER";
					$user_result=mysqli_query($conn,$user_sql);
					while($user_array=mysqli_fetch_array($user_result) ){
						if( $user_array['USERTYPE']=='1' )continue;
				?><form action="/public/php/manage.php" method="post" >
					<div class="form-group">
						<label for="uid" >用户号:</label>
						<input type="text" name="uid" size='9' value="<?php echo $user_array['UID'];?>" placeholder="<?php echo $user_array['UID'];?>">
						<label for="username" >用户姓名:</label>
						<input type="text" name="username" size='10' placeholder="<?php echo htmlspecialchars($user_array['USERNAME'])?>" value="<?php echo htmlspecialchars($user_array['USERNAME'])?>">
						<label for="email" >用户级别:</label>
						<input type="text" name="usertype" size='4'  placeholder="<?php echo htmlspecialchars($user_array['USERTYPE'])?>" value="<?php echo htmlspecialchars($user_array['USERTYPE'])?>">
						<label for="contact" >联系方式:</label>
						<input type="text" name="contact" size='13' placeholder="<?php echo htmlspecialchars($user_array['CONTACT'])?>" value="<?php echo htmlspecialchars($user_array['CONTACT'])?>">
						<label for="email" >E-mail:</label>
						<input type="text" name="email"  placeholder="<?php echo $user_array['EMAIL']?>" value="<?php echo $user_array['EMAIL']?>">
						<button class="btn btn-primary" type="submit" name="update" value="true">修改</button>
						<button class="btn btn-danger" type="submit" name="delete" value="true">删除</button>
					</div>	
				</form>
				<?php }?>
				<form action="/public/php/manage.php" method="post" >
					<div class="form-group">
						<label for="username" >用户姓名:</label>
						<input type="text" name="username" size='10' >
						<label for="email" >用户级别:</label>
						<input type="text" name="usertype" size='4' >
						<label for="contact" >联系方式:</label>
						<input type="text" name="contact" size='13' >
						<label for="email" >E-mail:</label>
						<input type="text" name="email">
						<button class="btn btn-default" type="submit" name="insert" value="user">添加</button>
					</div>	
				</form>
			
		</div>
		<div >
			<h3 name="goodinfo">商品信息</h3>
			<span style="color:red"><?php echo $goodmsg;?></span>
			
				<?php
					$good_sql="SELECT * FROM GOOD";
					$good_result=mysqli_query($conn,$good_sql);
					while($good_array=mysqli_fetch_array($good_result)){
				?><form action="/public/php/manage.php?#goodinfo" method="post" >
				<div class="form-group">
					<label for="gid" >商品号:</label>
					<input type="text" name="gid" size='9' value="<?php echo $good_array['GID'];?>" >
					<label for="uid" >商家号:</label>
					<input type="text" name="uid"  size='9' value="<?php echo $good_array['UID'];?>">
					<label for="gname" >商品名:</label>
					<input type="text" name="gname" size='8' placeholder="<?php echo htmlspecialchars($good_array['GNAME'])?>" value="<?php echo htmlspecialchars($good_array['GNAME'])?>">
					<label for="gprice" >商品价格:</label>
					<input type="text" name="gprice"  size='4' placeholder="<?php echo htmlspecialchars($good_array['GPRICE'])?>" value="<?php echo htmlspecialchars($good_array['GPRICE'])?>">
					<label for="ginfo" >商品信息:</label>
					<input type="text" name="ginfo"  placeholder="<?php echo $good_array['GINFO']?>" value="<?php echo $good_array['GINFO']?>">
					<button class="btn btn-primary" type="submit" name="update" value="true" >修改</button>
					<button class="btn btn-danger" type="submit" name="delete" value="true">删除</button>
				</div>	</form>
				<?php }?>
			<form action="/public/php/manage.php?#goodinfo" method="post" >
				<div class="form-group">
					<input type="text" name="gid" size='9' class="hidden">
					<label for="uid" >商家号:</label>
					<input type="text" name="uid"  size='9'>
					<label for="gname" >商品名:</label>
					<input type="text" name="gname"  size='9'>
					<label for="gprice" >商品价格:</label>
					<input type="text" name="gprice"  size='4'>
					<label for="ginfo" >商品信息:</label>
					<input type="text" name="ginfo">
					<button class="btn btn-default" type="submit" name="insert" value="good" >添加</button>
				</div>	
				
			</form>
		</div>

		<div >
			<h3 name="orderinfo">订单信息</h3>
			<span style="color:red"><?php echo $ordermsg;?></span>
			
				<?php
					$order_sql="SELECT * FROM ORDERTABLE,GOOD WHERE GOOD.GID=ORDERTABLE.GID";
					$order_result=mysqli_query($conn,$order_sql);
					while($order_array=mysqli_fetch_array($order_result)){
				?><form action="/public/php/manage.php" method="post" >
				<div class="form-group">
					<label class="col-sm-2"><?php echo "".$order_array['GNAME'];?></label>
					<label class="col-sm-1" for="oid" >订单号:</label>
					<input class="col-sm-2" type="text" name="oid" value="<?php echo $order_array['OID'];?>">
					<label class="col-sm-1" for="uid" >买家号:</label>
					<input class="col-sm-2" type="text" name="uid" value="<?php echo $order_array['UID'];?>">
					<label class="col-sm-1" for="gname" >商品号:</label>
					<input class="col-sm-2" type="text" name="gid"  placeholder="<?php echo $order_array['GID']?>" value="<?php echo $order_array['GID'];?>">
					<button class="btn btn-danger" type="submit" name="delete" value="true">删除</button>
				</div>	</form>
				<?php }?>
			<form action="/public/php/manage.php" method="post" >
				<div class="form-group">
					<input type="text" name="oid" class="hidden">
					<label for="uid" >买家号:</label>
					<input type="text" name="uid" >
					<label for="gname" >商品名:</label>
					<input type="text" name="gid" >
					<button class="btn btn-default" type="submit" name="insert" value="order" >添加</button>
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

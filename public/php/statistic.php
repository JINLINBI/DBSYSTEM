<?php
include 'checklevel.php';
include 'conn.php';
$login=false;
$level=0;
$username='';
session_start();
if(!empty($_SESSION['username'])){
	$username=$_SESSION['username'];
	$level=checklevel($conn,$username);
	if($level==2 || $level==1){	
		$login=true;
	}
	else{
		header("location:/index.html");	
	}	
	if(!empty($_POST['delete'])){		
		if(!empty($_POST['gid'])){
			$gid=$_POST['gid'];
			$uid=$_POST['uid'];
			if(mysqli_query($conn,"DELETE FROM GOOD WHERE GID='$gid' AND UID='$uid'")){
				$msg="删除成功!";
			}else{
				$msg="删除失败!请检查该商品是否被订购";
			}
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
		  <a class="navbar-brand">统计信息</a>
		</div>
		<div id="navbar" class="collapse navbar-collapse">
		  <ul class="nav navbar-nav">
			<!-- 这里做了修改 -->
			<li><a href="/index.php">主页</a></li>
            <?php
            if($login){
				if($level==2){
                    echo '<li class="active"> <a href="public/php/statistic.php" >统计</a></li>';
                    echo '<li > <a href="/public/php/sale.php" >卖咸鱼</a></li>';
                    echo '<li > <a href="/public/php/self.php" >个人中心</a></li>';
				}
				else if($level==1){
                    echo '<li class="active"> <a href="/public/php/statistic.php" >统计</a></li>';
                    echo '<li > <a href="/public/php/self.php" >个人中心</a></li>';
                    echo '<li > <a href="/public/php/manage.php" >管理</a></li>';
				}
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

		<div class="container">
			<?php if($level==2)echo "<h3>个人出售商品</h3>";
				else if($level==1)echo "<h3>在售商品</h3>";
?>
			<span style="color:red"><?php echo $msg;?></span>
			<?php if($level==2 && $result=mysqli_query($conn,"SELECT COUNT(*) FROM GOOD,USER WHERE USERNAME='$username' AND USER.UID=GOOD.UID")){
					$array=mysqli_fetch_array($result);
					echo "总件数:".$array["COUNT(*)"]."件";
				}else if($level==1 && $result=mysqli_query($conn,"SELECT COUNT(*) FROM GOOD")){
					$array=mysqli_fetch_array($result);
					echo "总件数:".$array["COUNT(*)"]."件";
					$result=mysqli_query($conn,"SELECT COUNT(*) FROM USER");
					$array=mysqli_fetch_array($result);
					echo "<h3>账户总数</h3>";
					echo "总人数:".$array["COUNT(*)"]."人";
					$result=mysqli_query($conn,"SELECT COUNT(*) FROM ORDERTABLE");
					$array=mysqli_fetch_array($result);
					echo "<h3>订单总数</h3>";
					echo "总订单数:".$array["COUNT(*)"]."单";
					
				}
			?>
			<?php
				$good_sql="SELECT * FROM GOOD,USER WHERE USERNAME='$username' AND GOOD.UID=USER.UID";
				$good_result=mysqli_query($conn,$good_sql);
				while( $level==2 && $good_array=mysqli_fetch_array($good_result)){
			?><form action="/public/php/statistic.php" method="post" >
			<div class="form-group">
				<input type="text" name="gid" size='9' value="<?php echo $good_array['GID'];?>" class="hidden">
				<input type="text" name="uid"  size='9' value="<?php echo $good_array['UID'];?>" class="hidden">
				<label for="gname" >商品名:</label>
				<input type="text" name="gname" size='12' placeholder="<?php echo $good_array['GNAME']?>" value="<?php echo $good_array['GNAME']?>">
				<label for="gprice" >商品价格:</label>
				<input type="text" name="gprice"  size='4' placeholder="<?php echo $good_array['GPRICE'];?>" value="<?php echo $good_array['GPRICE']?>">
				<label for="ginfo" >商品信息:</label>
				<input type="text" name="ginfo"  size='40' placeholder="<?php echo $good_array['GINFO']?>" value="<?php echo $good_array['GINFO']?>">
				<button class="btn btn-danger" type="submit" name="delete" value="true">删除</button>
			</div>	</form>
			<?php }?>
			

		</div>
  </body>
    <script src="/public/js/jquery.min.js"></script>
	<script src="/public/js/bootstrap.min.js"></script>
<script src="/public/js/vertify.js"></script>
	<script src="/public/js/check.js"></script>
</html>

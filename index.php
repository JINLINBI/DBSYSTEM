<?php
include 'public/php/checklevel.php';
include 'public/php/conn.php';
$login=false;
$level=0;
$username='';
session_start();
if(!empty($_SESSION['username'])){
	$username=$_SESSION['username'];
	$level=checklevel($conn,$username);
	$login=true;
	$result=mysqli_query($conn,"SELECT * FROM GOOD");
}
else{
	$result=mysqli_query($conn,"SELECT * FROM GOOD");
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
		</div><!--/.nav-collapse -->
	  </div>
	</nav>
	<!-- 页面主体内容 -->
	<div class="container">
			<div class="content">
			  <div class="starter-template">
				<!-- 这里做了修改，其他地方自由发挥 -->
				<h1>欢迎<?php echo '<b>'.$username.'</b>';?>来到广工咸鱼网</h1>
				<p class="lead">在这里,您可以买买买,也可以卖卖卖!</p>
			  </div>
			
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
            <img src="/public/img/kenan.jpeg" alt="First slide" width="100%" height="80%">
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

			<div class="goods" style="margin-top:30px">
				
				<?php
					while($good_array=mysqli_fetch_array($result)){
				?><form action="/public/php/indexpro.php" method="post" >
				<div class="form-group">
					<input type="text" name="gid" value="<?php echo $good_array['GID'];?>" class="hidden">
					<label for="gname" >商品名:</label>
					<input type="text" name="gname"  value="<?php echo $good_array['GNAME']?>" placeholder="<?php echo $good_array['GNAME']?>">
					<label for="gprice" >商品价格:</label>
					<input type="text" name="gprice" value="<?php echo $good_array['GPRICE'];?>" placeholder="<?php echo $good_array['GPRICE'];?>">
					<label for="ginfo" >商品信息:</label>
					<input type="text" name="ginfo"  value="<?php echo $good_array['GINFO']?>" placeholder="<?php echo $good_array['GINFO']?>">
					<button class="btn btn-info" type="submit" name="getcontact" value="true">联系方式</button>
					<?php if($level==3){
						echo '<button class="btn btn-primary" type="submit" name="order" >订购</button>';
					}else if($level==1){
						echo '<button class="btn btn-primary" type="submit" name="change" >修改</button>';
						echo '<button class="btn btn-danger" type="submit" name="delete" >删除</button>';
					}
					?>
				</div>	</form>
				<?php }?>
				
			
			</div>
                <!-- 注册表单 -->
                <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="register" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog modal-lg">
			  <div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">注册</h4>
			  </div>
			  <form action="register.php" method="post" accept-charset="utf-8" class="form-horizontal">
				<div class="modal-body">

				  <div class="form-group">
					<label for="username" class="col-sm-4 control-label">昵称:</label>
					<div class="col-sm-6">
					  <input type="text" class="form-control" name="username" id="username" minlength="2" maxlength="20" placeholder="username" required="">
					</div>
					<!-- 错误提示信息 -->
					<h6 style="color: red;" id="dis_un"></h6>
				  </div>
				  <div class="form-group">
					<label for="phone-numbers" id="phone-numbers" class="col-sm-4 control-label">手机号:</label>
					<div class="col-sm-6">
					  <input type="text" class="form-control" id="code"  name="phone-numbers"  placeholder="verification phone numbers" required="" maxlength="11" size="100">
					</div>
				  </div>
					<div class="form-group">
				
				  <div class="form-group">
					<label for="email" class="col-sm-4 control-label">Email:</label>
					<div class="col-sm-6">
					  <input type="email" class="form-control" name="email" id="remail" placeholder="Email" required="">
					</div>
					<!-- 错误提示信息 -->
					<h6 style="color: red;" id="dis_em"></h6>
				  </div>
				  <div class="form-group">
                      <div class="radio  col-sm-4" ></div>
					<div class="radio  col-sm-3" >
                        <label for="optionsRadios1" class="col-sm-10 control-label">普通用户  </label>
	                    <input stype="margin-right:5px" type="radio" name="usertype" id="optionsRadios1" value="3" checked>     
                    </div>
                    <div class="radio col-sm-2">
                        <label for="optionsRadios2" class="col-sm-10 control-label">卖家   </label>
                        <input stype="margin-right:5px" type="radio" name="usertype" id="optionsRadios2" value="2">
				    </div>
                    </div>

				  <div class="form-group">
					<label for="password" class="col-sm-4 control-label">密码:</label>
					<div class="col-sm-6">
					  <input type="password" class="form-control" name="password" id="password" placeholder="password" minlength="6" maxlength="20" required="">
					</div>
					<!-- 错误提示信息 -->
					<h6 style="color: red;" id="dis_pwd"></h6>
				  </div>

				  <div class="form-group">
					<label for="confirm" class="col-sm-4 control-label">确认密码:</label>
					<div class="col-sm-6">
					  <input type="password" class="form-control" name="confirm" id="confirm" placeholder="confirm" minlength="6" maxlength="20" required="">
					</div>
					<!-- 错误提示信息 -->
					<h6 style="color: red;" id="dis_con_pwd"></h6>
				  </div>

				  <div class="form-group">
					<div class="col-sm-12">
					  <img src="#" alt="" id="codeimg" >
					  <a href="#" title="Switch">点击切换</a>
					</div>
				  </div>
				</div>

				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal" style="float: left;">关闭</button>
				  <input type="reset" class="btn btn-warning" value ="重置" />
				  <button type="submit" class="btn btn-primary" id="reg">注册</button>
				</div>
			</div>	
                  </form>
                </div>
                </div>
                </div>
                 <!-- 登陆表单 -->
                <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="login" aria-labelledby="myLargeModalLabel">
			<div class="modal-dialog modal-lg">
			  <div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">登录</h4>
			  </div>
			  <form action="login.php" method="post" accept-charset="utf-8" class="form-horizontal">
				<div class="modal-body">
				  <div class="form-group">
					<label for="username" class="col-sm-4 control-label">昵称:</label>
					<div class="col-sm-6">
					  <input type="username" class="form-control" name="username" id="username" placeholder="username" required="">
					</div>
				  </div>
				  <div class="form-group">
					<label for="password" class="col-sm-4 control-label">密码:</label>
					<div class="col-sm-6">
					  <input type="password" class="form-control" name="password" placeholder="password" minlength="6" maxlength="20" required="">
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-sm-12">
					  <img src="#" alt="验证码加载失败" id="codeimg">
					  <span>点击切换</span>
					</div>
				  </div> 
				</div>
				<div class="modal-footer">
				  <button type="button" class="btn btn-default" data-dismiss="modal" style="float: left;">关闭</button>
				  <input type="reset" class="btn btn-warning" value ="reset" />
				  <button type="submit" class="btn btn-primary" name="login">登录</button>
				</div>
			</form>
            </div>       
			</div>           
		  </div>
            </div>
	</div><!-- /.container -->
     

  </body>
    <script src="/public/js/jquery.min.js"></script>
	<script src="/public/js/bootstrap.min.js"></script>
<script src="/public/js/vertify.js"></script>
	<script src="/public/js/check.js"></script>
</html>

<?php
include 'conn.php';		//引入连接数据库文件
include 'safe.php';		//引入安全过滤函数文件
session_start();		//开始会话
if(isset($_POST['username']) && isset($_POST['password'])){	//判断提交了用户名和密码是否为空
	$username=$_POST['username'];				//提取用户名
	$username=safe_string($username);			//过滤敏感字符
	if(strlen($username)>10){				//判断用户名是否过长
		echo "用户名长度不正确!";
	}
	$password=$_POST['password'];				//提取密码
	$password=sha1($password);				//将明文密码加密
	$sql="SELECT * FROM USER WHERE USERNAME='$username' and PASSWD='$password'";
								//
	if($result=mysqli_query($conn,$sql)){			//查询数据库记录是否有值
		$row=mysqli_fetch_array($result);		//提取元组
		if($row['USERNAME']==$username ){		//确认用户名是否匹配
			$_SESSION['username']=$row['USERNAME'];	//设置会话变量,作为成功登录的依据
			header("location:/index.php");		//重定向倒主页
		}
	}
	else{
		echo "用户名或密码错误";
	}
}
else {
	echo "用户名或密码错误!";
}
?>

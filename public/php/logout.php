<?php
session_start();			//开始会话
if(isset($_SESSION['username'])){	//判断是否登录
	$_SESSION['username']='';	//清空用户会话
	$msg='您已经注销了,<a href="index.php">返回首页</a>';
}
else{
	$msg='您没登录或已经超时退出,<a href="index.php">返回首页</a>';
}
header("location:/index.php");
?>
echo $msg;

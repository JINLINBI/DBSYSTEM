<?php
session_start();
if(isset($_SESSION['username'])){
	$_SESSION['username']='';
	$msg='您已经注销了,<a href="index.php">返回首页</a>';
}
else{
	$msg='您没登录或已经超时退出,<a href="index.php">返回首页</a>';
}
header("location:/index.php");
?>
echo $msg;

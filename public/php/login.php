<?php
include 'conn.php';
include 'safe.php';
session_start();
if(isset($_POST['username']) && isset($_POST['password'])){
	$username=$_POST['username'];
	$username=safe_string($username);
	if(strlen($username)>10){
		echo "用户名长度不正确!";
	}
	$password=$_POST['password'];
	$password=sha1($password);
	$sql="SELECT * FROM USER WHERE USERNAME='$username' and PASSWD='$password'";

	if($result=mysqli_query($conn,$sql)){
		$row=mysqli_fetch_array($result);
		if($row['USERNAME']==$username ){
			$_SESSION['username']=$row['USERNAME'];
			header("location:/index.php");	
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

<?php
include 'conn.php';
session_start();
if(isset($_POST['username']) && isset($_POST['password'])){
	$username=$_POST['username'];
	$password=$_POST['password'];
	$password=sha1($password);
	$sql="SELECT * FROM USER WHERE USERNAME='$username' and PASSWD='$password'";


	if($result=mysqli_query($conn,$sql)){
		$row=mysqli_fetch_array($result);
		if($row['USERNAME'] ){
			$_SESSION['username']=$row['USERNAME'];
			header("location:/index.php");	
		}
	}
	//	echo '<strong><font color="red">用户名或密码错误;</font></strong>';
	/*
	 else{
	}*/
}
?>
用户名或密码错误!

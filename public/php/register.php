<?php
session_start();
include 'conn.php';
$username=$_POST['username'];
$phone=$_POST['phone-numbers'];
$email=$_POST['email'];
$password=$_POST['password'];
$usertype=$_POST['usertype'];

if(empty($username) || empty($password)){
	echo "用户名或密码不能为空";

}
else if($usertype!='2' && $usertype!='3'){
	echo "请勿尝试非法输入!";
}
else {
	$password=sha1($password);
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
		echo "注册失败!";
	}
	else{
		$_SESSION['username']=$username;
		header("location:/index.php");
	}
}
?>

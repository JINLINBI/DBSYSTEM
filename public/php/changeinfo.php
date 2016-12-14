<?php
include 'conn.php';
include 'checklevel.php';
session_start();
if(!empty($_SESSION['username']) && (!empty($_POST['contact']) || !empty($_POST['email']))){
	$username=$_SESSION['username'];
	$email=$_POST['email'];
	$contact=$_POST['contact'];
	$level=checklevel($conn,$username);
	if($level==3){
		echo "请勿尝试非法绕过系统";
		header("location:/index.php");
	}
//	$sql="SELECT * FROM USER WHERE USERNAME='$username'";
//	$result=mysqli_query($conn,$sql);
//	$array=mysqli_fetch_array($result);
	if(mysqli_query($conn,"UPDATE USER SET CONTACT='$contact',EMAIL='$email' WHERE USERNAME='$username'")){
			echo"修改成功!";
	}else{
		echo "修改失败!";
	}

}else{
	echo '更改信息失败!';
}
?>

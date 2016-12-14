<?php
include 'conn.php';
include 'checklevel.php';
session_start();
if(!empty($_SESSION['username']) && !empty($_POST['oldpassword']) && !empty($_POST['newpassword']) && !empty($_POST['comfirmpassword']) && $_POST['newpassword']==$_POST['comfirmpassword']){
	$username=$_SESSION['username'];
	$oldpassword=$_POST['oldpassword'];
	$level=checklevel($conn,$username);
	if($level==3){
		echo "请勿尝试非法绕过系统";
		header("location:/index.php");
	}
	$sql="SELECT * FROM USER WHERE USERNAME='$username'";
	$result=mysqli_query($conn,$sql);
	$array=mysqli_fetch_array($result);
	if($array['PASSWD']==sha1($oldpassword)){
		$newpassword=$_POST['newpassword'];
		$newpassword=sha1($newpassword);
		if(mysqli_query($conn,"UPDATE USER SET PASSWD='$newpassword' WHERE USERNAME='$username'")){
			echo"修改成功!";
			//header("location:/public/php/self.php");			
		}
	}else{
		echo "原密码错误!";
		//header("location:/public/php/self.php");
	}

}
else{
	echo '更改密码失败!';
	//header("location:/index.php");
}
?>

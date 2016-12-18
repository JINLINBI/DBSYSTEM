<?php
session_start();		//开始会话
include 'conn.php';		//引入连接数据库文件
$username=$_POST['username'];	//提取提交过来的用户名
$phone=$_POST['phone-numbers'];	//提取.......的手机号
$email=$_POST['email'];		//....
$password=$_POST['password'];	//..
$usertype=$_POST['usertype'];	//.

if(empty($username) || empty($password)){	//判断提交的密码或用户名为空
	echo "用户名或密码不能为空";

}
else if($usertype!='2' && $usertype!='3'){	//判断用户是否修改该提交默认值,从而非法注册管理员帐号
	echo "请勿尝试非法输入!";
}
else {
	$password=sha1($password);		//加密密码
	$result=mysqli_query($conn,"SELECT MAX(UID) FROM USER");	//查询当前数据库用户数目
	if($result->num_rows>0){		//判断是否有值
		$row=$result->fetch_assoc();	
			if((int)$row["MAX(UID)"]<160000000){
				$max=(int)$row["MAX(UID)"]+160000000;
			}else{
				$max=(int)$row["MAX(UID)"];
			}
			$id=(string)($max+1);	//得到新创建用户的uid号
	}

	$sql="insert into USER values('$id','$username','$usertype','$password','$phone','$email')";
	if(mysqli_query($conn,$sql)==false){	//执行创建用户的数据更新
		echo "注册失败!";		//
	}
	else{
		$_SESSION['username']=$username;//执行成功时,设置用户会话变量
		header("location:/index.php");	//重定向
	}
}
?>

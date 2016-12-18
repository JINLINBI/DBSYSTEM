<?php
include 'conn.php';
include 'checklevel.php';
include 'safe.php';
session_start();
if(!empty($_SESSION['username']) && !empty($_POST['order']) && !empty($_POST['gid'])){
	$username=$_SESSION['username'];
	$level=checklevel($conn,$username);
	if($level!=3){
		echo "请勿尝试非法绕过系统";
		header("location:/index.php");
	}
	if($result=mysqli_query($conn,"SELECT * FROM USER WHERE USERNAME='$username'")){
		$array=mysqli_fetch_array($result);
		if($array['UID']){
			$uid=$array['UID'];
			$gid=$_POST['gid'];
			if($result=mysqli_query($conn,"SELECT MAX(OID) FROM ORDERTABLE")){
				$row=mysqli_fetch_array($result);
				if((int)$row["MAX(OID)"]<160000000){
					$max=(int)$row["MAX(OID)"]+160000000;
				}else{
					$max=(int)$row["MAX(OID)"];
				}
				$id=(string)($max+1);
			}
			if(mysqli_query($conn,"INSERT INTO ORDERTABLE(OID,UID,GID) VALUES('$id','$uid','$gid')")){
				echo "<a href='/index.php'>订购成功,点击返回!</a>";
			}
			else {
				echo "<a href='/index.php'>订购失败,点击返回!</a>";
			}
		}
	}
}
if(!empty($_POST['getcontact']) && !empty($_POST['gid'])){
	//$gid=$_POST['gid'];
	$gid=safe_string($_POST['gid']);
	if($result=mysqli_query($conn,"SELECT USERNAME,CONTACT,EMAIL FROM USER,GOOD WHERE GOOD.GID='$gid' AND USER.UID=GOOD.UID")){
		$array=mysqli_fetch_array($result);
		if(empty($array['CONTACT']))
			$array['CONTACT']='无联系方式';
		if(empty($array['EMAIL']))
			$array['EMAIL']='无EMAIL';
		echo "  商家姓名:".$array['USERNAME'].'</br>联系方式:'.$array['CONTACT']." </br> E-mail".$array['EMAIL'];
	}
}
?>

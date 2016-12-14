<?php
include "conn.php";
function checklevel(&$conn,$var){
	$sql="SELECT * FROM USER WHERE USERNAME='$var'";
	$result=mysqli_query($conn,$sql);
	$array=mysqli_fetch_array($result);
	if($array['USERTYPE']){
		return  (int)$array['USERTYPE'];
	}
}
?>

<?php
//APP Id
$appID = "3090c2fdd4694b0da6b545b513ecf3f9";
//授权码
$authKey = "dda4a68f2722463e8342e1212c52251e";
//待验证手机号
$pn = $_GET["number"];
if($pn>0){
	echo "fuckyou";
}
$version = "1.0";
$url = "https://api.ciaapp.cn/{$version}/agent";
$headerList = array("Host:api.ciaapp.cn",
                "Accept:application/json",
                "Content-Type:application/json;charset=utf-8",
                "appId:{$appID}",
                "authKey:{$authKey}",
                "pn:{$pn}"
            );
//使用 cURL  的 POST 调用 api

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_TIMEOUT,100);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headerList);
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$returnData = curl_exec($ch);
//对返回的 json 格式的字符串进行解析，并截取 authCode 后四位作为验证码
$return = json_decode($returnData);
$returnCode = $return->authCode;
$code = substr($returnCode,-4);
curl_close($ch);
echo $code;
?>

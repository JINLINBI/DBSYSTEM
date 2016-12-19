  //定义全局变量，用来保存验证码
  var result;
  function getCode(){
    //从 input 输入框获取输入的手机号
    var number = document.getElementById("code").value;
    //将手机号 AJAX POST 到 php 实现的后台程序，将返回的验证码赋值给 result。
    $.post('public/php/agent.php',{'number':number},function(data){
      alert("发送成功!");
      result = data;
    });
  }
  function Authenticate(){
    //从 input 输入框获取输入的验证码
    var code = document.getElementById("code").value;
    //验证获取的验证码是否正确
    if(code===result){
      alert("注册成功!");
    }
    else{
	if(code!=' ')
      alert("注册失败!");
    }
  }
  function changing(){
	//document.getElementById("codeimg").src="/public/php/captcha.php?"+Math.random();
	var codelink="/public/php/captcha.php?"+Math.random();
	document.getElementById("codeimg1").src=""+codelink;
	document.getElementById("codeimg2").src=""+codelink;
}

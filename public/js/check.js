$(document).ready(function() {
    var nameFlag = true;    //准备一个用户名的可用性标识
    $('#username').keyup(function() {    //用户输入一个字符就触发响应
        var length = $(this).val().length; 
        if ( length >= 2 && length <= 20 ) {    //判断用户名长度 2至20位之间
            //发送用户名，检测的类型为 name
            $.post('##', {username: $(this).val(),type:'name'}, function(data, textStatus, xhr) {
                if (textStatus == 'success') {
                    if (data == '1') {    //如果后台返回1，则表示此用户名已被注册
                        $('#dis_un').text('UserName is already registered');    //给出错误提示
                        nameFlag = false;
                    }else{    //用户名可以使用
                        $('#dis_un').text('');    //去掉错误提示文字
                        nameFlag = true;
                    }
                }
            });
        }else{    //长度不符合则不进行检测
            $('#dis_un').text('');
        }
    });
	var emailFlag = true;    //准备一个邮箱的可用性标识
$('#remail').blur(function() {    //注册邮箱失去焦点才检测
        if ($(this).val() != '') {    //输入不为空就检测
            var reg = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;    //正则表达式判断邮箱格式
            if (reg.test($(this).val())) {    //是邮箱格式
                $.post('##', {email: $(this).val(),type: 'email'}, function(data, textStatus, xhr) {
                    if (textStatus == 'success') {
                        if (data == '1') {    //后台返回1 表示已被注册
                            $('#dis_em').text('E-mail is already registered');
                            emailFlag = false;
                        }else{    //邮箱可用
                            $('#dis_em').text('');
                            emailFlag = true;
                        }
                    }
                });
            }else{    //不是邮箱格式
                $('#dis_em').text('E-mail format is incorrect');
                emailFlag = false;
            }
        }else{    //为空，不显示提示文字
            $('#dis_em').text('');
        }
    });
	var pwdFlag = true;   //准备一个密码的可行性标识    
$('#password').blur(function(){    //密码检测
        if ($(this).val() == '') {
            $('#dis_pwd').text('Password cannot be empty');
        }else if($(this).val().length < 6){
            $('#dis_pwd').text('Passwords must be at least six');
        }else{
            $('#dis_pwd').text('');
        }
    });

    $('#confirm').blur(function() {    //确认密码检测
        var val = $('#password').val();
        if (val != '') {
            if ($(this).val() == '') {
                $('#dis_con_pwd').text('Please confirm your password');
                pwdFlag = false;
            }else if($(this).val() != val){
                $('#dis_con_pwd').text('Confirm password inconsistent');
                pwdFlag = false;
            }else{
                $('#dis_con_pwd').text('');
                pwdFlag = true;
            }
        }else{
            $('#dis_con_pwd').text('');
            pwdFlag = false;
        }
    });
	    $('#reg').click(function() {
        if (!(nameFlag && emailFlag && pwdFlag)) {    //用户名标识 && 邮箱标识 && 密码标识
            alert('Please check page info!');
            return false;
        }
    });

});

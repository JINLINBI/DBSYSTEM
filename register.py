#coding:utf-8
from flask import *
from func.process import write_data,send_email,verify_email
app=Flask(__name__)
@app.route("/",methods=['POST','GET'])
def show_index():
    msg='fuck'
    return render_template('index.html',msg=msg)

@app.route("/register",methods=['POST','GET'])
def do_register():
    """获取用户名和邮箱信息,写入数据库,并发送请求
    : return :
    """
    if request.method=='POST':
        #获取用户名和邮箱信息
        name=request.form['name']
        email=request.form['email']

        #将写入数据库
        outcome=write_data(name,email)
        if outcome is False:
            return redirect(url_for('error'))
       #发送邮件
        send_email(name,email)
        return redirect(url_for('wait_verifyed'))
    return render_template('register.html')
@app.route("/error")
def error():
    msg="Your email have already existed!"
    return render_template('display.html',msg=msg)
@app.route("/do_verification",methods=['GET'])
def do_verification():
    """
    进行邮箱认证
    :return :
    """
    #获取GET请求的参数token与authcode的值
    token=request.args.get('token')
    authcode=request.args.get('authcode')
    #调用verify_email函数进行认证
    if token is not None and authcode is not None and verify_email(token,authcode):
        return redirect(url_for('success'))
    else:
        return redirect(url_for('fail'))
@app.route("/success")
def success():
    msg="success"
    return render_template('display.html',msg=msg)
@app.route("/fail")
def fail():
    msg="Too late!Time Out!"
    return render_template('display.html',msg=msg)
@app.route("/wait_verifyed")
def wait_verifyed():
    msg="Our verifycation link has sent to your email,please check your E-mail!"
    return render_template('display.html',msg=msg)
def helloworld():
    pass
if __name__=="__main__":
    #在调试模式下启动本地开发服务器
    app.run(debug=True)


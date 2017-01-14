<?php
namespace Home\Controller;
use Think\Controller;
header('Content-Type:text/html; charset=utf-8');
class LoginController extends Controller {
    public function login(){
        $this->show();
        $email = I('post.email');
        $password = I('post.password');

        if(I('post.')){
            if(!empty($email) && !empty($password)){
                if($email == "admin" && $password == "admin"){
                    echo '<script>alert("登录成功");</script>';
                    echo '<script>window.location.href="http://115.29.109.27/MonkeyGuard/index.php/Home/Index/index";</script>';
                }
                else{
                    echo '<script>alert("用户名或密码错误");</script>';
                }
            }
            else{
                echo '<script>alert("输入用户名和密码");</script>';
            }
        }
    }
}
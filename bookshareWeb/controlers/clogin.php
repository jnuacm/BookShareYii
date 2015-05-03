<?php
    require "../models/UserModel.php";
    require "AES.php";
    require "filter_sqli.php";
    session_start();
    $username = $_POST["username"];
    $username = filter_sqli($username);
    $password = $_POST["password"];
    $vcode = $_POST["vcode"];
    
    
    if($vcode == $_SESSION["vcode"]){
        $user = new User(0,0,0,0,0,0);
        $user->SelectUserByName($username);
        if(null != $user->getUserName()){
            if($password == $user->getUserPassword()){
                setcookie("username",$username,time()+3600,"/");
                setcookie("password",AESEncrypt($password),time()+3600,"/");
                setcookie("avatar",$user->getUserAvatar(),time()+3600,"/");
                header("Location: ../views/vmain.php");
                exit();
            }else{
                $_SESSION["vcode"] = null;
                $_SESSION['errInfo'] = "登录错误：";
                $_SESSION['errInfoDetail'] = "您输入的密码错误，请重新输入！";
                $_SESSION['goBack'] = "vlogin.php";
                header("Location: ../views/err_info.php");
                exit();
            }
        }else{
            $_SESSION["vcode"] = null;
            $_SESSION['errInfo'] = "登录错误：";
            $_SESSION['errInfoDetail'] = "您输入的帐号不存在或包含敏感词汇，请重新输入！";
            $_SESSION['goBack'] = "vlogin.php";
            header("Location: ../views/err_info.php");
            exit();
        }
    }else{
        $_SESSION["vcode"] = null;
        $_SESSION['errInfo'] = "验证码错误：";
        $_SESSION['errInfoDetail'] = "您输入的验证码不正确，请重新输入！";
        $_SESSION['goBack'] = "vlogin.php";
        header("Location: ../views/err_info.php");
        exit();
    }

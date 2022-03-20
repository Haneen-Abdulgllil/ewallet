<?php
require_once('functions.php');


//for regiester new user
if(isset($_GET['signup'])){
$response = validateSignup($_POST); // calling validating function from functions.php

}



//for loging user
if(isset($_GET['login'])){
print_r($_POST);
$userdata = checkUser($_POST['mobile_or_email'],$_POST['password']);

if(count($userdata)>0){
    $_SESSION['userdata']=$userdata;
    $_SESSION['Auth']=true;
    header("location:../../");
}else{
    $_SESSION['error']['field'] = 'nouser' ;
    $_SESSION['error']['msg'] = 'User not registered !' ;
    header("location:../../?login");
}

}


//for loging out user
if(isset($_GET['logout'])){
session_destroy();
header("location:../../?login");
}


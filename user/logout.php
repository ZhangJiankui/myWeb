<?php
session_start();

//注销登录
if (isset($_SESSION['SID'])) {    //如果已经登陆){
    unset($_SESSION['SID']);
    echo '注销登录成功！点击此处返回<a href="/index.php">主页</a>';
    exit;
} else {
    exit("你不是还没登陆吗，为什么要注销？？？<br>");  
}
?>


<!DOCTYPE html>
<!--
这是计软义工的网站，没什么好说的
-->
<?php
session_start();    //开始会话，记住状态
?>

<html>
    <head>
        <title>注销登陆</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/stylesheet/mainstyle.css" />
    </head>
    <body>
        <a href="/index.php" ><img src="/images/logo.png" alt="深大计软义工协会" width="380" height="101" /> </a><br>
        <?php
//注销登录
        if (isset($_SESSION['SID'])) {    //如果已经登陆){
            unset($_SESSION['SID']);
            echo '注销登录成功！点击此处返回<a href="/index.php">主页</a>';
        } else {
            echo "你不是还没登陆吗，为什么要注销？？？<br>";
        }
        ?>

        <br>
        <br>
        <br>
        <h2><a href="/about/about.html">关于我们</a> </h2>
        <p>计软义工协会@copy left by no body</p>
        <p>power by 计软义工技术部</p><img src="/images/tech.gif" /> <br>

    </body>
</html>
<!DOCTYPE html>
<!--
这是计软义工的网站，没什么好说的
-->
<?php
session_start();    //开始会话，记住状态
?>

<html>
    <head>
        <title>管理系统</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php
        //检查是否登陆
        $isLogin = false;
        if (isset($_SESSION['MID'])) {    //如果已经登陆
            $MID = $_SESSION['MID'];
            $isLogin = true;
            echo  $MID . '</a> 已经登陆 ';
            echo '<a href="/manager/managerLogout.php">注销</a>';
        } else {
            echo '<a href="/manager/managerLogin.php">登陆</a> <br>';
            exit;
        }
        ?>           
        <a href="/manager/manageBorrowList.php"><h2>查看借书申请</h2></a>
        <a href="/manager/manageDonateList.php"><h2>查看捐书申请</h2></a>
        <a href="/manager/managebook.php"><h2>查看书库</h2></a>
        <a href="/index.php"><h2>主页</h2></a>
        <br>
        <br>
        <br>
        <a href="/about/about.html"><h2>关于我们</h2></a> 
        <p>计软义工协会@copy left by no body</p> <br>
    </body>
</html>

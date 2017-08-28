<!DOCTYPE html>
<!--
这是计软义工的网站，没什么好说的
-->
<?php
session_start();    //开始会话，记住状态
?>

<html>
    <head>
        <title>我要管理</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/stylesheet/mainstyle.css" />
    </head>
    <body>
        <a href="/index.php" ><img src="/images/logo.png" alt="深大计软义工协会" width="380" height="101" /> </a><br>
        <?php
        //检查是否登陆
        $isLogin = false;
        if (isset($_SESSION['MID'])) {    //如果已经登陆
            $MID = $_SESSION['MID'];
            $isLogin = true;
            echo $MID . '</a> 已经登陆 ';
            echo '<a href="/manager/managerLogout.php">注销</a>';
            ?>           
            <h2><a href="/manager/manageBorrowList.php">查看借书申请</a></h2>
            <h2><a href="/manager/manageDonateList.php">查看捐书申请</a></h2>
            <h2><a href="/manager/managebook.php">查看书库</a></h2>
            <h2><a href="/index.php">主页</a></h2>

        <?php
        } else {
            echo '<a href="/manager/managerLogin.php">登陆</a> <br>';
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
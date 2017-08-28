<!DOCTYPE html>
<!--
这是计软义工的网站，没什么好说的
-->
<?php
session_start();    //开始会话，记住状态
?>

<html>
    <head>
        <title>书库主页</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/stylesheet/mainstyle.css" />
    </head>
    <body>
        <a href="/index.php" ><img src="/images/logo.png" alt="深大计软义工协会" width="380" height="101" /> </a><br>
        <h1>这是书库主页哦</h1>
        <?php
        //检查是否登陆
        $isLogin = false;
        if (isset($_SESSION['SID'])) {    //如果已经登陆
            $SID = $_SESSION['SID'];
            $isLogin = true;
            echo '<a href="/user/my.php">'.$SID.'</a> 已经登陆 ';
            echo '<a href="/user/logout.php">注销</a><br>';
            echo '<b>我要看看<a href="/book/myBook.php">我的书库记录</a></b> <br>';
        } else {
            echo '<a href="/user/login.php">登陆</a> <br>';
            echo '<a href="/user/reg.php">注册</a> <br>';
            echo '<a href="/user/forget.php">忘记密码？</a> <br>';
        }
        ?>
        
        <br>不玩了，我只想回到<a href="/index.php">主页</a> <br>
        <h1>这里应该会几本书的图片，真的</h1>

        <h2><a href="bookBorrow.php">我要借书</a></h2>
        <h2><a href="bookDonate.php">我要捐书</a></h2>
        <h2><a href="bookList.php">看看有什么书</a></h2>
        
        <br>
        <br>
        <br>
        <h2><a href="/about/about.html">关于我们</a> </h2>
        <p>计软义工协会@copy left by no body</p>
        <p>power by 计软义工技术部</p><img src="/images/tech.gif" /> <br>

    </body>
</html>

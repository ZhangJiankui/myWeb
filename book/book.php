<!DOCTYPE html>
<!--
这是计软义工的网站，没什么好说的
-->
<?php
session_start();    //开始会话，记住状态
?>

<html>
    <head>
        <title>书库的主页</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>这是书库主页哦</h1>
        <?php
        //检查是否登陆
        $isLogin = false;
        if (isset($_SESSION['SID'])) {    //如果已经登陆
            $SID = $_SESSION['SID'];
            $isLogin = true;
            echo '<a href="/user/my.php">'.$SID.'</a> 已经登陆 ';
            echo '<a href="/user/logout.php">注销</a>';
        } else {
            echo '<a href="/user/login.php">登陆</a> <br>';
            echo '<a href="/user/reg.php">注册</a> <br>';
            echo '<a href="/user/forget.php">忘记密码？</a> <br>';
        }
        ?>
        <br>我要看看<a href="/book/myBook.php">我的书库记录</a> <br>
        <br>不玩了，我只想回到<a href="/index.php">主页</a> <br>
        <h1>这里应该会几本书的图片，真的</h1>

        <a href="bookBorrow.php"><h2>我要借书</h2></a>
        <a href="bookDonate.php"><h2>我要捐书</h2></a>
        <a href="bookList.php"><h2>看看有什么书</h2></a>
        
        <br>
        <br>
        <br>
        <a href="/about/about.html"><h2>关于我们</h2></a>
        <p>计软义工协会@copy left by no body</p> <br>

    </body>
</html>

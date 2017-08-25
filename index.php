 
<!DOCTYPE html>
<!--
这是计软义工的网站，没什么好说的
-->
<?php
session_start();    //开始会话，记住状态
?>

<html>
    <head>
        <title>真正的主页</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>这是计软义工协会的网站主页哦</h1>
  
        <?php
        //检查是否登陆
        $isLogin = false;
        if (isset($_SESSION['SID'])) {    //如果已经登陆
            $SID = $_SESSION['SID'];
            $isLogin = true;
            echo "<a href=\"/user/my.php\">$SID</a> 已经登陆 ";
            echo '<a href="/user/logout.php">注销</a>';
        } else {
            echo '<a href="/user/login.php">登陆</a> <br>';
            echo '<a href="/user/reg.php">注册</a> <br>';
            echo '<a href="/user/forget.php">忘记密码？</a> <br>';
        }
        ?>     
        
        <br><br><br><a href="/about/aboutFace.html"><b style="color:red">热门！</b>这什么鬼网站为什么这么丑？</a> 
        <h1>这里是很好看的大图片，真的</h1>
        

        
        
        <a href="/about/aboutUSE.html"><h2>怎么使用这个网站</h2></a> 
        <a href="book/book.php"><h2>计软书库</h2></a> 
        <a href="other/other.php"><h2>其他功能</h2></a>
        <br>
        <br>
        <br>
        <a href="about/about.html"><h2>关于我们</h2></a> 
        <a href="/manager/manager.php"><h2>管理入口</h2></a>
        <a href="https://zhangjiankui.gitbooks.io/myweb/content/"><h2>网站开发文档</h2></a>
        <p>计软义工协会@copy left by no body</p> <br>

    </body>
</html>



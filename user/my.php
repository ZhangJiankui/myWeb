<!DOCTYPE html>
<!--
这是计软义工的网站，没什么好说的
-->
<?php
session_start();    //开始会话，记住状态
?>

<html>
    <head>
        <title>我自己</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/stylesheet/mainstyle.css" />
    </head>
    <body>
        <a href="/index.php" ><img src="/images/logo.png" alt="深大计软义工协会" width="634" height="168" /> </a><br>


        <?php
        //检测是否登录，若没登录则转向登录界面
        if (isset($_SESSION['SID'])) {  //如果已经登陆
            //包含数据库连接文件
            require'D:\wamp64\www\conn.php';
            $SID = $_SESSION['SID'];
            $user_query = $conn->query("select * from users where SID=$SID limit 1");
            $row = mysqli_fetch_array($user_query);
//            echo '学号：', $SID, '<br>';
//            echo '姓名：', $row['name'], '<br>';
//            echo '注册时间：', $row['regTime'], '<br>';
//            echo '<br> <a href="/user/myEdit.php">修改密码</a><br>';
            //需要注销入口
        ?>
        
        <h3 style="color:green">你的基本信息：</h3>
        <p>学号：<?php echo $SID;?></p>
        <p>名字：<?php echo $row['name'];?></p>
        <p>注册时间：<?php echo $row['regTime'];?></p>
        <p><a href="/user/myEdit.php">修改密码</a></p>
        <p><a href="logout.php">注销</a><p>
              
        <?php
        } else {
            echo '<h3 style="color:red">请先登陆哦!!</h3>';
            echo '你可以<a href="login.php">登录</a><br>';
            echo '也可以<a href="reg.php">注册</a><br>';
            echo '或者<a href="login.php">忘记密码了？</a><br>';
            //可能需要跳转到登陆页面
        }
        ?>
        
        
        <a href="/index.php">主页</a><br>
        <a href="/book/book.php">书库</a><br>
        

        <br>
        <br>
        <br>
        <h2><a href="/about/about.html">关于我们</a> </h2>
        <p>计软义工协会@copy left by no body</p>
        <p>power by 计软义工技术部</p><img src="/images/tech.gif" /> <br>

    </body>
</html>

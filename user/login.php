<!DOCTYPE html>
<!--
这是计软义工的网站，没什么好说的
-->
<?php
session_start();    //开始回话，记住状态
?>
<html>
    <head>
        <title>我要登陆</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/stylesheet/mainstyle.css" />
    </head>
    <body>
        <a href="/index.php" ><img src="/images/logo.png" alt="深大计软义工协会" width="380" height="101" /> </a><br>

        <?php
        $SID = $passwd = "";    //初始化为空
        $errMeg = "";

        //检测是否登录，若没登录则转向登录界面
        if (isset($_SESSION['SID'])) {
            echo '你已经登陆了';
            echo '可是直接返回上一页哦<br>';
            echo '当然也可以去到<a href="/index.php">主页</a> <br>';
            exit;
            //可能需要跳转到主页
        } else {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $SID = htmlspecialchars($_POST['SID']);
                $passwd = htmlspecialchars($_POST['passwd']);

                //包含数据库连接文件
                require'D:\wamp64\www\conn.php';
                //检测密码是否正确
                $check_query = $conn->query("select passwd from users where SID=$SID  limit 1");
                //要先判断$check_query有没料，不然会出警告
                if (!is_bool($check_query) && $row = $check_query->fetch_assoc()) {
                    //如果密码正确
                    if (strcmp($row['passwd'], MD5($passwd)) == 0) {  //因为数据库里的密码是MD5过的
                        //登录成功
                        $_SESSION['SID'] = $SID;
                        $expire = time() + 360; //cookie的有效时间
                        setcookie("user", "$SID", $expire); //设置cookie

                        if (!$conn->query("UPDATE  users SET lastLogin=now()  WHERE SID=$SID ")) {
                            echo "更新登陆时间失败" . $conn->error . '<br>';
                        }
                        echo $SID, ' 欢迎你！进入 <a href="my.php">用户中心</a><br />';
                        echo '或者回到<a href="/index.php">主页</a><br />';
                        exit;
                    } else {   //如果密码不等
                        $errMeg = "学号或密码错误";
                    }
                } else { //如果查无账户
                    $errMeg = "学号或密码错误";
                }
            }
        }
        ?>

        <h1>这是登陆界面</h1>
        <form action="login.php" method="post">
            学号: <input type="text" name="SID" value = "<?php echo $SID ?>"> </br>
            密码: <input type="password" name="passwd" value = "<?php echo $passwd ?>"> </br>
            <input type="submit" value="提交">
        </form>
        <?php
        echo "<p style=\"color:red\">$errMeg</p>";
        ?>
        <br>
        <br>
        <br>
        <a href="forget.php">忘记密码？</a> <br>
        嘤嘤嘤登陆好麻烦呀我要回到<a href="/index.php">主页</a> <br>

        <br>
        <br>
        <br>
        <h2><a href="/about/about.html">关于我们</a> </h2>
        <p>计软义工协会@copy left by no body</p>
        <p>power by 计软义工技术部</p><img src="/images/tech.gif" /> <br>
    </body>
</html>

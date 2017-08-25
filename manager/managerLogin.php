<!DOCTYPE html>
<!--
这是计软义工的网站，没什么好说的
-->
<?php
session_start();    //开始回话，记住状态
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>管理员登陆</title>
    </head>
    <body>

        <?php
        $MID = $passwd = "";    //初始化为空
        $errMeg = "";

//检测是否登录，若没登录则转向登录界面
        if (isset($_SESSION['MID'])) {
            echo '你已经登陆了';
            echo '可是直接返回上一页哦<br>';
            echo '当然也可以去到<a href="/index.php">主页</a> <br>';
            exit;
            //可能需要跳转到主页
        } else {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $MID = htmlspecialchars($_POST['MID']);
                $passwd = htmlspecialchars($_POST['passwd']);

                //包含数据库连接文件
                require'D:\wamp64\www\conn.php';
                //检测用户名及密码是否正确
                $check_query = $conn->query("select MID,passwd from managers where MID=$MID  limit 1");
                //要先判断$check_query有没料，不然会出警告
                if (!is_bool($check_query) && $row = $check_query->fetch_assoc()) {
                    //如果密码正确
                    
                    if (strcmp($row['passwd'], MD5($passwd)) == 0) {  //因为数据库里的密码是MD5过的
                        //登录成功
                        $_SESSION['MID'] = $MID;
                        $expire = time() + 360; //cookie的有效时间
                        setcookie("manager", "$MID", $expire); //设置cookie

                        echo $MID, ' 欢迎你！进入 <a href="/manager/manager.php">管理中心</a><br />';
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

        <h1>这是管理员登陆界面</h1>
        <form action="managerLogin.php" method="post">
            工号: <input type="text" name="MID" value = "<?php echo $MID ?>"> </br>
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
        不搞了，回到<a href="/index.php">主页</a> <br>
        
        <br>
        <br>
        <br>
        <a href="/about/about.html"><h2>关于我们</h2></a>
        <p>计软义工协会@copy left by no body</p> <br>
    </body>
</html>

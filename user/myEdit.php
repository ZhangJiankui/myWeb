<!DOCTYPE html>
<!--
这是计软义工的网站，没什么好说的
-->
<?php
session_start();    //开始会话，记住状态
?>

<html>
    <head>
        <title>我要修改密码</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/stylesheet/mainstyle.css" />
    </head>
    <body>
        <a href="/index.php" ><img src="/images/logo.png" alt="深大计软义工协会" width="380" height="101" /> </a><br>
        <?php
//检测是否登录，若没登录则转向登录界面
        if (isset($_SESSION['SID'])) {  //如果已经登陆
            //包含数据库连接文件
            require'D:\wamp64\www\conn.php';
            $SID = $_SESSION['SID'];
            $user_query = $conn->query("select * from users where SID=$SID limit 1");
            $row = mysqli_fetch_array($user_query);
//            echo '学号：', $SID, '<br>';
//            echo '姓名：', $row['name'], '<br>';;
            //需要注销入口
            ?>
            <h3 style="color:green">学号： <?php echo $SID; ?></h3>

            <?php
            //处理表单
            $errMeg = "";   //偷懒用的错误信息提示
            if ($_SERVER["REQUEST_METHOD"] == "POST") { //如果提交了
                $passwdFormer = htmlspecialchars($_POST['passwdFormer']);   //需要加过滤器防止注入
                $passwdNew = htmlspecialchars($_POST['passwdNew']);
                $passwdConfirm = htmlspecialchars($_POST['passwdConfirm']);

                //
                //可能还需要判断表单合法性的过程
                //
                if (strcmp($passwdNew, $passwdConfirm) != 0) {
                    $errMeg = "两次密码不一样呢！";
                } else {
                    //包含数据库连接文件
                    require'D:\wamp64\www\conn.php';
                    //检测用户名及密码是否正确
                    $check_query = $conn->query("select passwd from users where SID=$SID  limit 1");
                    //要先判断$check_query有没料，不然会出警告
                    if (!is_bool($check_query) && $row = $check_query->fetch_assoc()) {
                        //如果密码正确
                        if (strcmp($row['passwd'], MD5($passwdFormer)) == 0) {  //因为数据库里的密码是MD5过的
                            //回写新密码              
                            $passwdNew = MD5($passwdNew);
                            if ($conn->query("UPDATE users SET passwd='$passwdNew'  WHERE SID=$SID ")) {    //字符型要加''符号哦
                                $errMeg = "密码修改成功！";
                            } else {
//                                var_dump($check_query);
                                echo 'ooooo' . $conn->error . "<br>";
                                $errMeg = $conn->error + '错误';
                            }
                        } else {
                            $errMeg = "原来的密码错啦";
                        }
                    } else { //如果读数据库失败
                        $errMeg = $conn->error + '错误';
                    }
                }
            }
            ?>
            <form action="myEdit.php" method="post"> 
                原密码：<input type="password" name="passwdFormer" ><br> 
                新密码：<input type="password" name="passwdNew" > <br> 
                再确认：<input type="password" name="passwdConfirm"> <br>
                <input type="submit" value="提交">
            </form>

            <h3 style="color:red"><?php echo $errMeg; ?></h3>

            <br><a href="my.php">算了</a>

            <?php
        } else {
            echo "请先登陆哦";
            echo '你可以<a href="login.php">登录</a><br>';
            echo '也可以<a href="reg.php">注册</a><br>';
            echo '或者<a href="forget.php">忘记密码了？</a><br>';
     
            //可能需要跳转到登陆页面
        }
        ?>

        <br>
        <br>
        <a href="/index.php">主页</a><br>
        <a href="/book/book.php">书库</a><br>
        <a href="logout.php">注销</a>

        <br>
        <br>
        <br>
        <h2><a href="/about/about.html">关于我们</a> </h2>
        <p>计软义工协会@copy left by no body</p>
        <p>power by 计软义工技术部</p><img src="/images/tech.gif" /> <br>

    </body>
</html>
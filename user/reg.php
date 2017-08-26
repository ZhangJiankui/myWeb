<!DOCTYPE html>
<!--
这是计软义工的网站，没什么好说的
-->

<html>
    <head>
        <title>我要注册</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/stylesheet/mainstyle.css" />
    </head>
    <body>
        <a href="/index.php" ><img src="/images/logo.png" alt="深大计软义工协会" width="634" height="168" /> </a><br>


        <?php
        $SID = $name = $passwd = $address = $tel = "";
        $SIDErr = $nameErr = $passwdErr = $addressErr = $telErr = "";   //可能可以用于表单检查
        $errMeg = "";   //偷懒用的错误信息提示
        $regFailed = false;
        if ($_SERVER["REQUEST_METHOD"] == "POST") { //如果提交了
            $SID = htmlspecialchars($_POST['SID']);   //需要加过滤器防止注入
            $name = htmlspecialchars($_POST['name']);
            $passwd = htmlspecialchars($_POST['passwd']);
            $passwdConfirm = htmlspecialchars($_POST['passwdConfirm']);
            $address = htmlspecialchars($_POST['address']);
            $tel = htmlspecialchars($_POST['tel']);

            //
            //可能还需要判断表单合法性的过程
            //
            if (strcmp($passwd, $passwdConfirm) != 0) {
                $regFailed = true;
                $errMeg = "两次密码不一样呢！";
            } else {
                //包含数据库连接文件
                require'D:\wamp64\www\conn.php';

                //检测用户是否已经注册
                $check_query = $conn->query("select SID from users where SID=$SID limit 1");
                //要先判断$check_query有没料，不然会出警告
                if (!is_bool($check_query) && $row = $check_query->fetch_assoc()) {
                    $regFailed = true;
                    $errMeg = "这个学号已经被注册啦，什么你才是本人";
                } else {

                    //检查学号和名字是否匹配
                    $check_query = $conn->query("select SID,name from students where SID=$SID limit 1");
                    //要先判断$check_query有没料，不然会出警告
                    if (!is_bool($check_query)  && $row = $check_query->fetch_assoc()) {
                        if (strcmp(trim($row['name']), $name) != 0) { //加trim()是为了去空格
                            $regFailed = true;
                            $errMeg = "名字和学号不匹配呢,什么你明明都填对了？";
                        } else {
                            //到这里就匹配完成啦

                            $passwd = MD5($passwd);
                            //写入数据
                            $sql = "INSERT INTO users(SID,name,passwd,address,tel,regTime)VALUES('$SID', '$name', '$passwd', '$address', '$tel', now())";
                            if ($conn->query($sql)) {
                                exit('用户注册成功！点击此处<a href="login.php">登录</a><br>或者你想先回到<a href="/index.php">主页</a>？');
                            } else {
                                $regFailed = true;
                                $errMeg = "狗咩呢！注册失败了,原因是这个：$conn->error<br>要不要告诉管理员呢";
                            }
                        }
                    } else {   //查无此学号
                        $regFailed = true;
                        $errMeg = "不存在学号呢，什么你明明都填对了？";
                    }
                }
            }
        }
        ?>
        <h1>这里是注册页面</h1>
        <h2 style="color:red">姓名一定要与学号匹配哦</h2>
        <p>我们会对比数据库中的学号姓名</p>
        <p>如果你写的学号和姓名没对应，那么就不给通过，不信可以试试</p>
        如果上两句没有解释清楚，点击<a href="/about/aboutSID.html">这里</a>看看是怎么回事<br>
        <p>因为懒得写表单检查，所以<b style="color:red">求求你写上正常的信息</b></p>
        <br>
        <br>
        
        <!--表单-->
        <form action="reg.php" method="post">
            学号: <input type="text" name="SID" value="<?php echo $SID ?>"> </br>
            名字: <input type="text" name="name" value="<?php echo $name ?>"> </br>
            密码: <input type="password" name="passwd" value="<?php echo $passwd ?>"> </br>
            确认: <input type="password" name="passwdConfirm" value=""> </br>
            宿舍: <input type="text" name="address" value="<?php echo $address ?>"> </br>
            电话: <input type="text" name="tel" value="<?php echo $tel ?>"> </br>
            <input type="submit" value="提交">
        </form>

<?php
if ($regFailed) {
    echo '<b style="color:red">'.$errMeg.'</b>';
    echo '<br>点击<a href="forget.php">这里</a>联系某人吧<br>';
}
?>
        <br>
        <br>
        <br>
        <br>

        呜呜呜我不想注册了，我要回到<a href="/index.php">主页</a>
        <br>
        <br>
        <br>
        <h2><a href="/about/about.html">关于我们</a> </h2>
        <p>计软义工协会@copy left by no body</p>
        <p>power by 计软义工技术部</p><img src="/images/tech.gif" /> <br>

    </body>
</html>





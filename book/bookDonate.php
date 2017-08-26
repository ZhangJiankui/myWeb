 
<!DOCTYPE html>
<!--
这是计软义工的网站，没什么好说的
-->
<?php
session_start();    //开始会话，记住状态
?>

<html>
    <head>
        <title>我要捐书</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/stylesheet/mainstyle.css" />
        <script src="/jquery/jquery-3.2.1.js">
        </script>
        <script>    //响应增加和减少的按钮
            var index = 1;  //初始的输入框数
            $(document).ready(function () {
                $("#add").click(function () {   //按了增加
                    $("#book" + index).after("<br id=\"br" + (++index) + "\">" +
                            "<label id=\"label" + index + "\">第" + index + "本书：</label>" +
                            "<input id=\"book" + index + "\" type=\"text\" name=\"q[]\" >");
                });
                $("#delete").click(function () {    //按了减少
                    if (index > 1) {
                        $("#book" + index).remove();
                        $("#label" + index).remove();
                        $("#br" + index).remove();
                        index--;
                    } else {
                        alert("不能再少了哦");
                    }
                });
            });
        </script>
    </head>
    <body>
        <a href="/index.php" ><img src="/images/logo.png" alt="深大计软义工协会" width="634" height="168" /> </a><br>

        <?php
        //检查是否登陆
        $isLogin = false;
        if (isset($_SESSION['SID'])) {    //如果已经登陆
            $SID = $_SESSION['SID'];
            $isLogin = true;
            echo '<a href="/user/my.php">' . $SID . '</a> 已经登陆 ';
            echo '<a href="/user/logout.php">注销</a>';
            ?>    



            <?php
            //在这里对提交的书单进行处理
            $errMeg = "";   //偷懒用的错误信息提示
            $isOK = false;  //有没操作成功
            if ($_SERVER["REQUEST_METHOD"] == "POST") { //如果提交了
                $q = isset($_POST['q']) ? $_POST['q'] : '';      //是不是应该防止代码注入
                if (is_array($q)) {

                    //包含数据库连接文件
                    require'D:\wamp64\www\conn.php';
                    foreach ($q as $val) {  //对于每个书名
                        //
                    //可能需要判断书名的合法性
                        //
                    
                    //写入数据
                        $sql = "INSERT INTO books_donate_log(SID,bookName,status,startTime )VALUES('$SID', '$val', '申请', now())";
                        if ($conn->query($sql) == true) {
                            echo '<br>成功登记书本： ' . $val . '，可以主要联系管理员或者等管理员联系哦！';
                        } else {
                            echo '<br> <p style="color:red">书本： ' . $val . ' 登记失败，原因是这个：' . $conn->error . '<br>要不要告诉管理员呢 ！';
                        }
                    }
                    $isOK = true;
                }
                if (!$isOK) {
                    echo '<br> <p style="color:red">怎么回事？ ！';
                }
                echo '<br><a href="/index.php">主页</a><br>';
                echo '<a href="/book/book.php">书库</a><br>';
                echo '<a href="/book/bookDonate.php">我要继续捐书</a><br>';

                exit;
            }
            ?>

            <h1>捐书有益身心健康</h1>  
            <p>--------伟大的革命家毛泽东同志</p><br><br><br>


            <h3>在下面的框框中输入每一本书的name，或者点击按钮增减数量</h3>
            <p>然后点击提交告诉我们，相信大家都是善良的，绝对不会乱填乱提交</p>
            <p>不不不，<b style="color:red">求求你了，请不要乱填乱点</b></p>
            <button id="add">再多一本</button>
            <button id="delete">嗯少一本</button>   <br><br><br>
            <form action="bookDonate.php" method="post">
                <label id="label1">第1本书：</label><input id="book1" type="text" name="q[]" >  <br id="br1">

                <br><br>
                <input type="submit" value="提交">
            </form>
            <br>是不是可以无限点增加按钮呀？
            <br>是不是可以在书名里注入代码玩玩呀？
            <h2><a href="/index.php">主页</a></h2>

        <?php
        } else {
            echo '<h1 style="color:red">不登录是不行的哦</h1>';
            echo '你可以试试<a href="/user/login.php">登陆</a> <br>';
            echo '也可以试试<a href="/user/reg.php">注册</a> <br>';
            echo '然而你已经<a href="/user/forget.php">忘记密码？</a> <br>';
            echo '不行就回到<a href="/index.php">主页</a> <br>';
            exit;
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



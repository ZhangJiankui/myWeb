<!DOCTYPE html>
<!--
这是计软义工的网站，没什么好说的
-->
<?php
session_start();    //开始会话，记住状态
?>

<html>
    <head>
        <title>管理系统</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php
        //检查是否登陆
        $isLogin = false;
        if (isset($_SESSION['MID'])) {    //如果已经登陆
            $MID = $_SESSION['MID'];
            $isLogin = true;
            echo $MID . '</a> 已经登陆 ';
            echo '<a href="/manager/managerLogout.php">注销</a>';
        } else {
            echo '<a href="/manager/managerLogin.php">登陆</a> <br>';
            exit;
        }
        ?>  
<!--表单头放这里是有原因的哦-->
        <form action="/manager/manageDonateOne.php" method="post">  
            <?php
            $errMeg = "";   //偷懒用的错误信息提示
            $isOK = false;  //有没操作成功
            if ($_SERVER["REQUEST_METHOD"] == "GET") { //响应勾选完书之后的提交(get请求)
                $ID = isset($_GET['ID']) ? $_GET['ID'] : '';      //是不是应该防止代码注入
                //包含数据库连接文件
                require'D:\wamp64\www\conn.php';

                //读取借书记录
                $check_query = $conn->query("select * from books_donate_log where ID=$ID  limit 1");
                if ($row = $check_query->fetch_assoc()) {
                    echo '<br>记录信息：<br> ID: <input type="text" name="ID" value="' . $row['ID'] . '"readonly ><br>';
                    echo '书名: ' . $row['bookName'] . '<br>';
                    echo '状态: ' . $row['status'] . '<br>';
                    echo '开始时间: ' . $row['startTime'] . '<br>';
                    echo '处理时间: ' . $row['dealTime'] . '<br>';
                    echo '备注: ' . $row['remark'] . '<br><br><br>';

                    $SID = $row['SID'];

                    //读取学生信息
                    $check_query = $conn->query("select * from users where SID=$SID  limit 1");
                    if ($row = $check_query->fetch_assoc()) {
                        echo '学生信息：<br> 学号: ' . $row['SID'] . '<br>';
                        echo '名字: ' . $row['name'] . '<br>';
                        echo '地址: ' . $row['address'] . '<br>';
                        echo '电话: ' . $row['tel'] . '<br>';
                        echo '注册时间: ' . $row['regTime'] . '<br>';
                        echo '备注: ' . $row['remark'] . '<br><br><br>';
                    } else {
                        $errMeg += $conn->error;
                    }
                }
            } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $submit = isset($_POST['submit']) ? $_POST['submit'] : '';      //是不是应该防止代码注入
                $ID = $_POST['ID'];

                //包含数据库连接文件
                require'D:\wamp64\www\conn.php';
                if (strcmp($submit, "取消确认") == 0) {
                    if ($conn->query("UPDATE  books_donate_log SET status='取消',dealTime=now()  WHERE ID=$ID ")) {    //字符型要加''符号哦
                        echo "取消确认成功";
                    } else {
                        echo "更新记录状态失败" . $conn->error;
                    }
                } else if (strcmp($submit, "完成确认") == 0) {
                    if ($conn->query("UPDATE  books_donate_log SET status='完成',dealTime=now()  WHERE ID=$ID ")) {    //字符型要加''符号哦
                        echo "完成确认成功";
                    } else {
                        echo "更新记录状态失败" . $conn->error;
                    }
                } else {
                    echo '不明请求';
                }
                echo '<a href="/manager/manageDonateList.php"><h2>返回</h2></a>';

                exit;
            }
            ?>
            <a href="/manager/manageBorrowList.php"><h2>返回</h2></a>

            
            <h2 style="color: red">下面是关于这单的操作，请谨慎操作哦</h2>

            <form action="/manager/manageDonateOne.php" method="post"> 
                <input type="submit" name="submit" value="取消确认" > <br><br>
                <input type="submit" name="submit" value="完成确认" > <br><br>

            </form>
            <a href="/index.php"><h2>主页</h2></a>
            <br>
            <br>
            <br>
            <a href="/about/about.html"><h2>关于我们</h2></a> 
            <p>计软义工协会@copy left by no body</p> <br>
            </body>
            </html>

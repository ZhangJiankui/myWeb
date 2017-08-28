<!DOCTYPE html>
<!--
这是计软义工的网站，没什么好说的
-->
<?php
session_start();    //开始会话，记住状态
?>

<html>
    <head>
        <title>某单借书</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/stylesheet/mainstyle.css" />
    </head>
    <body>
        <a href="/index.php" ><img src="/images/logo.png" alt="深大计软义工协会" width="380" height="101" /> </a><br>
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
        <form action="/manager/manageBorrowOne.php" method="post"> 
            <?php
            $errMeg = "";   //偷懒用的错误信息提示
            $isOK = false;  //有没操作成功
            if ($_SERVER["REQUEST_METHOD"] == "GET") { //响应勾选完书之后的提交(get请求)
                $ID = isset($_GET['ID']) ? $_GET['ID'] : '';      //是不是应该防止代码注入
                //包含数据库连接文件
                require'D:\wamp64\www\conn.php';

                //读取借书记录
                $check_query = $conn->query("select * from books_borrow_log where ID=$ID  limit 1");
                if ($row = $check_query->fetch_assoc()) {
                    echo '<br>记录信息：<br> ID: <input type="text" name="ID" value="' . $row['ID'] . '"readonly > <br>';
                    echo '书名: ' . $row['bookName'] . '<br>';
                    echo '状态: ' . $row['status'] . '<br>';
                    echo '开始时间: ' . $row['startTime'] . '<br>';
                    echo '处理时间: ' . $row['dealTime'] . '<br>';
                    echo '归还时间: ' . $row['returnTime'] . '<br>';
                    echo '备注: ' . $row['remark'] . '<br><br><br>';

                    $bookID = $row['bookID'];
                    $SID = $row['SID'];

                    //读取书本信息
                    $check_query = $conn->query("select * from books where ID=$bookID  limit 1");
                    if ($row = $check_query->fetch_assoc()) {
                        echo '书本信息：<br> ID: <input type="text" name="bookID" value="' . $row['ID'] . '" readonly><br>';
                        echo '书名: ' . $row['bookName'] . '<br>';
                        echo '版本: ' . $row['version'] . '<br>';
                        echo '库存: <input type="text" name="number" value="' . $row['number'] . '" readonly ><br>';
                        echo '预约: <input type="text" name="orderNum" value="' . $row['orderNum'] . '" readonly ><br>';
                        echo '备注: ' . $row['remark'] . '<br><br><br>';
                    } else {
                        $errMeg += $conn->error;
                    }

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
                $bookID = $_POST['bookID'];
                $number = $_POST['number'];
                $orderNum = $_POST['orderNum'];
                //包含数据库连接文件
                require'D:\wamp64\www\conn.php';

                if (strcmp($submit, "取消确认") == 0) {
                    if ($conn->query("UPDATE  books_borrow_log SET status='取消',dealTime=now()  WHERE ID=$ID ")) {    //字符型要加''符号哦
                        $orderNum--;
                        if ($conn->query("UPDATE  books SET orderNum=$orderNum  WHERE ID=$bookID ")) {
                            echo "取消确认成功";
                        } else {
                            echo "更新预约数失败" . $conn->error;
                        }
                    } else {
                        echo "更新记录状态失败" . $conn->error;
                    }
                } else if (strcmp($submit, "完成确认") == 0) {
                    if ($conn->query("UPDATE  books_borrow_log SET status='完成',dealTime=now()  WHERE ID=$ID ")) {    //字符型要加''符号哦
                        $orderNum--;
                        $number--;
                        if ($conn->query("UPDATE  books SET orderNum=$orderNum, number=$number WHERE ID=$bookID ")) {
                            echo "完成确认成功";
                        } else {
                            echo "更新预约数和库存失败" . $conn->error;
                        }
                    } else {
                        echo "更新记录状态失败" . $conn->error;
                    }
                } else if (strcmp($submit, "归还确认") == 0) {
                    if ($conn->query("UPDATE  books_borrow_log SET status='归还',returnTime=now()  WHERE ID=$ID ")) {    //字符型要加''符号哦                
                        $number++;
                        if ($conn->query("UPDATE  books SET  number=$number WHERE ID=$bookID ")) {
                            echo "归还确认成功";
                        } else {
                            echo "更新库存失败" . $conn->error;
                        }
                    } else {
                        echo "更新记录状态失败" . $conn->error;
                    }
                } else {
                    echo '不明请求';
                }
                echo '<h2><a href="/manager/manageBorrowList.php">返回</a></h2>';
                exit;
            }
            ?>
            <h2><a href="/manager/manageBorrowList.php">返回</a></h2>


            <h2 style="color: red">下面是关于这单的操作，请谨慎操作哦</h2>

            <input type="submit" name="submit" value="取消确认" > <br><br>
            <input type="submit" name="submit" value="完成确认" > <br><br>
            <input type="submit" name="submit" value="归还确认" > <br><br>

        </form>
        <h2><a href="/index.php">主页</a></h2>
        <br>
        <br>
        <br>
        <h2><a href="/about/about.html">关于我们</a> </h2>
        <p>计软义工协会@copy left by no body</p>
        <p>powered by 计软义工技术部</p><img src="/images/tech.gif" /> <br>
    </body>
</html>

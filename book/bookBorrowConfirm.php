<!DOCTYPE html>
<!--
这是计软义工的网站，没什么好说的
-->
<?php
session_start();    //开始会话，记住状态
?>

<html>
    <head>
        <title>借书确认</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/stylesheet/mainstyle.css" />
    </head>
    <body>
        <a href="/index.php" ><img src="/images/logo.png" alt="深大计软义工协会" width="634" height="168" /> </a><br>

        <?php
        //登陆检测
        //检查是否登陆
        $isLogin = false;
        if (isset($_SESSION['SID'])) {    //如果已经登陆
            $SID = $_SESSION['SID'];
            $isLogin = true;
            echo '<a href="/user/my.php">' . $SID . '</a> 已经登陆 ';
            echo '<a href="/user/logout.php">注销</a><br>';
            ?>      


            <?php
            $errMeg = "";   //偷懒用的错误信息提示
            $isOK = false;  //有没操作成功
            if ($_SERVER["REQUEST_METHOD"] == "GET") { //响应勾选完书之后的提交(get请求)
                $q = isset($_GET['q']) ? $_GET['q'] : '';      //是不是应该防止代码注入

                if (is_array($q)) {

                    //输出表格头
                    echo '<h3>你选择了一下书本，点击提交确认或点击取消放弃</h3>';
                    echo '<form action="bookBorrowConfirm.php" method="post">';
                    echo '<table border="1">';
                    echo '<tr>';
                    echo '<th>ID</th>';
                    echo '<th>书名</th>';
                    echo '</tr>';

                    //包含数据库连接文件
                    require'D:\wamp64\www\conn.php';
                    foreach ($q as $val) {  //对于每个书名
                        //
                    //可能需要判断书名的合法性
                        //
                    
                    //写入数据
                        $check_query = $conn->query("select ID,bookName from books where ID=$val  limit 1");
                        ;
                        if ($row = $check_query->fetch_assoc()) {
                            echo '<tr> ';
                            echo '<td> <input type="text" name="ID[]" value="' . $row['ID'] . '" readonly> </td> ';
                            echo '<td> <input type="text" name="bookName[]" value="' . $row['bookName'] . '" readonly> </td> ';
                            echo '</tr> ';
                        }
                    }
                    echo '</table> ';
                    echo '<input type="submit" value="提交"> ';
                    echo '</form> ';
                    echo '<a href="bookBorrow.php">取消</a><br><br>';
                    $isOK = true;
                }
                if (!$isOK) {
                    echo '<br> <p style="color:red">怎么回事？ ！';
                }
                echo '<br><a href="/index.php">主页</a><br>';
                echo '<a href="/book/book.php">书库</a><br>';
                echo '<a href="/book/bookBorrow.php">我要继续借书</a><br>';
                exit;
            } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $ID = isset($_POST['ID']) ? $_POST['ID'] : '';      //是不是应该防止代码注入
                $bookName = isset($_POST['bookName']) ? $_POST['bookName'] : '';      //是不是应该防止代码注入

                if (is_array($ID) && is_array($bookName)) {
                    //包含数据库连接文件
                    require'D:\wamp64\www\conn.php';

                    for ($i = 0; $i < count($ID); $i++) {  //对于每个书名
                        //登记申请
                        $sql = "INSERT INTO books_borrow_log(SID,bookName,bookID,status,startTime )VALUES('$SID', '$bookName[$i]', '$ID[$i]','申请', now())";
                        if ($conn->query($sql) == true) {
                            echo '<br>成功申请书本： ' . $bookName[$i] . '，可以主要联系管理员或者等管理员联系哦！';
                        } else {
                            echo '<br> <p style="color:red">书本： ' . $bookName[$i] . ' 申请失败，原因是这个：' . $conn->error . '<br>要不要告诉管理员呢 ！';
                        }

                        //更新该书的预约数
                        $check_query = $conn->query("select orderNum from books where ID=$ID[$i]  limit 1");
                        if (!is_bool($check_query) && $row = $check_query->fetch_assoc()) {

                            $orderNum = $row['orderNum'] + 1;
                            //写回预约数
                            if ($conn->query("UPDATE books SET orderNum = $orderNum  WHERE ID =$ID[$i] ")) {
                                echo '<br>更新' . $bookName[$i] . '成功<br><br>';
                            } else {
                                echo $conn->error . '错误<br>';
                            }
                        } else {
                            echo $conn->error . '错误<br>';
                        }
                    }
                }
            }
            ?>




            <br>
            <br>
            <a href="/book/bookBorrow.php">我还要借</a> <br>
            <a href="/index.php">不借了，我走</a> <br>

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


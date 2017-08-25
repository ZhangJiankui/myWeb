 
<!DOCTYPE html>
<!--
这是计软义工的网站，没什么好说的
-->
<?php
session_start();    //开始会话，记住状态
?>

<html>
    <head>
        <title>我要借书</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>

        <?php
        //登陆检测
        //检查是否登陆
        $isLogin = false;
        if (isset($_SESSION['SID'])) {    //如果已经登陆
            $SID = $_SESSION['SID'];
            $isLogin = true;
            echo '<a href="/user/my.php">' . $SID . '</a> 已经登陆 ';
            echo '<a href="/user/logout.php">注销</a>';
        } else {
            echo '<h1 style="color:red">不登录是不行的哦</h1>';
            echo '你可以试试<a href="/user/login.php">登陆</a> <br>';
            echo '也可以试试<a href="/user/reg.php">注册</a> <br>';
            echo '然而你已经<a href="/user/forget.php">忘记密码？</a> <br>';
            echo '不行就回到<a href="/index.php">主页</a> <br>';
            exit;
        }
        ?>      

        <h1>借书需克制，过多将会严重影响您的健康</h1> 
        <p>--------------------------------教育家、著名医师杨永信教授</p><br><br>

        <h3>勾选想要的书，最后点提交即可（提交按钮在最底下）</h3>

        <form action="bookBorrowConfirm.php" method="get"> 
            <table border="1">
                <tr>
                    <th>选择</th>
                    <th>书名</th>
                    <th>版本</th>
                    <th>库存</th>
                    <th>预约</th>
                    <th>备注</th>
                </tr>

                <?php
                //查询书库表单获取书单
                require'D:\wamp64\www\conn.php';
                $books_query = $conn->query("select * from books");
                if ($books_query->num_rows > 0) {
                    //输出表单
                    while ($row = $books_query->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo '<input type="checkbox" name="q[]" value="' . $row['ID'] . '">'; ?></td>
                            <td><?php echo $row['bookName']; ?></td>
                            <td><?php echo $row['version']; ?></td>
                            <td><?php echo $row['number']; ?></td>
                            <td><?php echo $row['orderNum']; ?></td>
                            <td><?php echo $row['remark']; ?></td>
                        </tr> 
                        <?php
                    }
                } else {
                    echo "0 结果<br>";
                }
                ?>

            </table>
            <input type="submit" value="提交"> <br><br>           
        </form>

        <br><br>
        <a href="/index.php">不借了，我走</a>



        <br>
        <br>
        <br>
        <a href="/about/about.html"><h2>关于我们</h2></a> 
        <p>计软义工协会@copy left by no body</p> <br>
    </body>
</html>



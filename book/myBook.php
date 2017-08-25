 
<!DOCTYPE html>
<!--
这是计软义工的网站，没什么好说的
-->
<?php
session_start();    //开始会话，记住状态
?>

<html>
    <head>
        <title>我的书库记录</title>
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
        
        <h1>冲黄钻可以偷偷看别人的记录哦</h1> 
        <p>--------------------------------公司总裁马化腾先生</p><br><br>

        <h3>借书记录</h3>  
        <table border="1">
            <tr>     
                <th>书名</th>
                <th>书ID</th>
                <th>状态</th>
                <th>申请时间</th>
                <th>处理时间</th>
                <th>归还时间</th>
            </tr>
            <?php
            //查询书库表单获取书单
            require'D:\wamp64\www\conn.php';
            $log_query = $conn->query("select * from books_borrow_log where SID = $SID");
            if ($log_query->num_rows > 0) {
                //输出表单
                while ($row = $log_query->fetch_assoc()) {              
                    ?>
                    <tr>    
                        <td><?php echo $row['bookName']; ?></td>
                        <td><?php echo $row['bookID']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['startTime']; ?></td>
                        <td><?php echo $row['dealTime']; ?></td>
                        <td><?php echo $row['returnTime']; ?></td>
                    </tr> 
                    <?php
                }
            } else {
                echo "0 结果<br>";
            }
            ?>
        </table>
      
        <br><br>
        
        <h3>捐书记录</h3>  
        <table border="1">
            <tr>     
                <th>书名</th>
                <th>状态</th>
                <th>申请时间</th>
                <th>处理时间</th>
            </tr>
            <?php
            //查询书库表单获取书单
            require'D:\wamp64\www\conn.php';
            $log_query = $conn->query("select * from books_donate_log where SID = $SID");
            if ($log_query->num_rows > 0) {
                //输出表单
                while ($row = $log_query->fetch_assoc()) {              
                    ?>
                    <tr>    
                        <td><?php echo $row['bookName']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['startTime']; ?></td>
                        <td><?php echo $row['dealTime']; ?></td>
                    </tr> 
                    <?php
                }
            } else {
                echo "0 结果<br>";
            }
            ?>
        </table>
        <br><br>
        <a href="/index.php">主页</a><br>
        <a href="/book/book.php">书库</a><br>
        
              
        <br>
        <br>
        <br>
        <a href="/about/about.html"><h2>关于我们</h2></a> 
        <p>计软义工协会@copy left by no body</p> <br>
    </body>
</html>



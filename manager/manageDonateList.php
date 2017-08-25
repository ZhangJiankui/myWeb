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
            echo  $MID . '</a> 已经登陆 ';
            echo '<a href="/manager/managerLogout.php">注销</a>';
        } else {
            echo '<a href="/manager/managerLogin.php">登陆</a> <br>';
            exit;
        }
        ?>  
        
        <h3>借书记录</h3>  
        
        <form action="/manager/manageDonateOne.php" method="get"> 
        <table border="1">
            <tr>
                <th>学号</th>
                <th>书名</th>
                <th>状态</th>
                <th>申请时间</th>
                <th>处理时间</th>            
                <th>查看</th>
            </tr>
            <?php
            //查询书库表单获取书单
            require'D:\wamp64\www\conn.php';
            $log_query = $conn->query("select * from books_donate_log  ORDER BY startTime DESC");
            if ($log_query->num_rows > 0) {
                //输出表单
                while ($row = $log_query->fetch_assoc()) {              
                    ?>
                    <tr>
                        <td><?php echo $row['SID']; ?></td>
                        <td><?php echo $row['bookName']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['startTime']; ?></td>
                        <td><?php echo $row['dealTime']; ?></td>
                        <td><?php echo '<input type="submit" name = "ID" value="'.$row['ID'].'">'; ?></td>
                    </tr> 
                    <?php
                }
            } else {
                echo "0 结果<br>";
            }
            ?>
        </table>
          
        </form>
        <a href="/index.php"><h2>主页</h2></a>
        <br>
        <br>
        <br>
        <a href="/about/about.html"><h2>关于我们</h2></a> 
        <p>计软义工协会@copy left by no body</p> <br>
    </body>
</html>

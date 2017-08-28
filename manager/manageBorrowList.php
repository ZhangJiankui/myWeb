<!DOCTYPE html>
<!--
这是计软义工的网站，没什么好说的
-->
<?php
session_start();    //开始会话，记住状态
?>

<html>
    <head>
        <title>借书列表</title>
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
            ?>  

            <h3>借书记录</h3>  

            <form action="/manager/manageBorrowOne.php" method="get"> 
                <table border="1">
                    <tr>
                        <th>学号</th>
                        <th>书名</th>
                        <th>书ID</th>
                        <th>状态</th>
                        <th>申请时间</th>
                        <th>处理时间</th>
                        <th>归还时间</th>               
                        <th>查看</th>
                    </tr>
                    <?php
                    //查询书库表单获取书单
                    require'D:\wamp64\www\conn.php';
                    $log_query = $conn->query("select * from books_borrow_log ORDER BY startTime DESC ");
                    if ($log_query->num_rows > 0) {
                        //输出表单
                        while ($row = $log_query->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row['SID']; ?></td>
                                <td><?php echo $row['bookName']; ?></td>
                                <td><?php echo $row['bookID']; ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <td><?php echo $row['startTime']; ?></td>
                                <td><?php echo $row['dealTime']; ?></td>
                                <td><?php echo $row['returnTime']; ?></td>
                                <td><?php echo '<input type="submit" name = "ID" value="' . $row['ID'] . '">'; ?></td>
                            </tr> 
                            <?php
                        }
                    } else {
                        echo "0 结果<br>";
                    }
                    ?>
                </table>

            </form>
            <h2><a href="/index.php">主页</a></h2>
        <?php
        } else {
            echo '<a href="/manager/managerLogin.php">登陆</a> <br>';
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

<!DOCTYPE html>
<!--
这是计软义工的网站，没什么好说的
-->
<?php
session_start();    //开始会话，记住状态
?>

<html>
    <head>
        <title>我要管理书库</title>
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
            <table border="1">
                <tr>
                    <th>序号</th>
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
                        //echo $row['ID'], "   ", $row['bookName'], "    ", $row['version'], " ", $row['number'], "  ", $row['orderNum'], "<br>";
                        ?>

                        <tr>
                            <td><?php echo $row['ID']; ?></td>
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
            <a href="/index.php"><h2>主页</h2></a>

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

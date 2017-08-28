<!DOCTYPE html>
<html>
    <head>
        <title>有关使用</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/stylesheet/mainstyle.css" />
        <script type="text/javascript">
            function mouseOver()
            {
                document.b1.src = "images/aboutUSE2.gif"
            }
            function mouseOut()
            {
                document.b1.src = "images/aboutUSE1.jpg"
            }
        </script>
    </head>
    <body>
        <img border="0"  src="images/aboutUSE1.jpg" name="b1" width="300" height="300" onmouseover="mouseOver()" onmouseout="mouseOut()" />

        <br><br>
        <h2>要给他们说说这网站有多坑</h2>
        <form action="aboutUSE.php" method="post">
            <p>认认真真写个响亮的大名：</p>
            <input type="text" name="author" size="40"> </br>
            <p>滔滔不绝书下行云流水的话语：</p>
            <textarea rows="5" cols="30" name="message"></textarea> </br>
            <input type="submit" value="提交">
        </form>
        <?php
        //处理提交的留言
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $author = htmlspecialchars($_POST['author']);
            $message = htmlspecialchars($_POST['message']);

            if (empty($author) || empty($message)) {
                echo '<h3 style="color:red">不能空着提交哦！</h3>';
            } else {
                //包含数据库连接文件
                require'D:\wamp64\www\conn.php';

                $sql = "INSERT INTO messages_aboutuse(author, message, postTime)VALUES( '$author', '$message',  now())";
                //要先判断$check_query有没料，不然会出警告
                if ($conn->query($sql)) {
                    echo '<h3 style="color:green">发表成功！</h3>';
                } else {
                    echo '<h3 style="color:red">发表过程中出问题啦！原因是这个：' . $conn->error . ';要不要告诉管理员呢</h3>';
                }
            }
        }
        ?>

        <h2>他们这么说：</h2>

        <?php
        //列出留言
        require'D:\wamp64\www\conn.php';
        $messages_query = $conn->query("select * from messages_aboutuse order by postTime desc");
        if ($messages_query->num_rows > 0) {
            //输出表单
            while ($row = $messages_query->fetch_assoc()) {
                echo '<p style="color:blue">#' . $row['ID'] . '楼&nbsp&nbsp' . $row['author'] . '&nbsp发表于：' . $row['postTime'] . '</p>';
                echo '<pre>' . $row['message'] . '</pre><br>';
            }
        } else {
            echo "怎么没人说话<br>";
        }
        ?>

    </body>
</html>
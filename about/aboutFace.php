<!DOCTYPE html>
<html>
    <head>
        <title>有关面子</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="/stylesheet/mainstyle.css" />
    </head>
    <body>

        <h1>网站为什么这么丑</h1>
        <p><em>张建葵 2017/8/22 15:59:38</em></p>
        <hr />
        <p>对于这个问题，将从一下几点回答：  
        </p>
        <ul>
            <li><strong>这是为了方便你；</strong>  
            </li>
            <li><strong>这是一种简约美；</strong> </li>
            <li><strong>这是作者的深思熟虑。</strong></li>
        </ul>
        <h2>这是为了方便你</h2>
        <p>别看某些网站看着很炫，比如<a href="http://globe.cid.harvard.edu/?mode=gridSphere&amp;id=JM">这个网站</a>,如果你真的点了进去的话你会发现<strong>酷炫的背后其实在消耗你大量的计算资源</strong>：  
        </p>
        <ul>
            <li>大量的图片会占用你的网络带宽，严重影响你的网速；</li>
            <li>复杂的javaScript等脚本代码会让你的浏览器疲于运行，甚至可能会奔溃罢工；</li>
            <li>过多的元素可能会分散你的注意力，影响你的专注度。 </li>
        </ul>
        <p>那些网页明知会对你造成这样的影响，为什么还要这么做呀？事实上是<strong>他们根本就不关心对你的不良影响，而是只在乎网页给自己带来的效益。</strong><br />
            漂亮酷炫的网页能够给自己带来更多的关注和人气，所以才不管对你造成的不良影响呢。  
        </p>
        <h2>这是一种简约美</h2>
        <p>现在的网络，完全不缺乏酷炫的网页，可以说满大街都是这样的网页，不少人都感叹这已经审美疲劳了。<br />
            为了应对这个局面，大部分都开发者都是开发更酷炫的网页，而不顾其可能造成的不良影响。<strong>这个方向已经错了，这是一种恶性循环，这样下去网页对资源的需求将会无比巨大，终有一天网络带宽全被占了怎么办，浏览器无法承担巨大脚本运算怎么办，这终将是一场灾难。</strong>  
        </p>
        <p>所以，出现了一群人，他们致力于简化网页，向世人宣扬<code>简约美</code>，期望能够阻止这场必然的灾难。但是他们的力量还太过弱小了，因为简约的网站往往无法吸引到更多的关注，他们无法从中获取足够支持以继续这场运动。  
        </p>
        <p>鉴于这样的局面，本网站决定放弃酷炫可能带来的丰厚收益，转而投身<code>简约美</code>。为了人类的未来社会的发展用这样的页面来向世人证明<code>简约美</code>的价值。  
        </p>
        <h2>这是作者的深思熟虑</h2>
        <p>鉴于上述的两个原因。<br />
            作者陷入了沉思，觉得写界面太麻烦了，还是这样写写凑合着用吧。  
        </p>

        <br><br>
        <h2>想说些什么吗</h2>
        <form action="aboutFace.php" method="post">
            <p>随便写个昵称：</p>
            <input type="text" name="author" size="40"> </br>
            <p>随便写两句话：</p>
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

                $sql = "INSERT INTO messages_aboutface(author, message, postTime)VALUES( '$author', '$message',  now())";
                //要先判断$check_query有没料，不然会出警告
                if ($conn->query($sql)) {
                    echo '<h3 style="color:green">发表成功！</h3>';
                } else {
                    echo '<h3 style="color:red">发表过程中出问题啦！原因是这个：' . $conn->error . ';要不要告诉管理员呢</h3>';
                }
            }
        }
        ?>

        <h2>他们的留言：</h2>

        <?php
        //列出留言
        require'D:\wamp64\www\conn.php';
        $messages_query = $conn->query("select * from messages_aboutface order by postTime desc");
        if ($messages_query->num_rows > 0) {
            //输出表单
            while ($row = $messages_query->fetch_assoc()) {
                echo '<p style="color:blue">#' . $row['ID'] . '楼&nbsp&nbsp' . $row['author'] . '&nbsp发表于：' . $row['postTime'] . '</p>';
                echo '<pre>' . $row['message'] . '</pre><br>';
            }
        } else {
            echo "还没有留言哦<br>";
        }
        ?>


    </body>
</html>
<!-- This document was created with MarkdownPad, the Markdown editor for Windows (http://markdownpad.com) -->

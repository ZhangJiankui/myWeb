<!DOCTYPE html>
<!--
这是计软义工的网站，没什么好说的
-->
<?php
session_start();

//检测是否登录，若没登录则转向登录界面
if (isset($_SESSION['SID'])) {  //如果已经登陆
    //包含数据库连接文件
    require'D:\wamp64\www\conn.php';
    $SID = $_SESSION['SID'];
    $user_query = $conn->query("select * from users where SID=$SID limit 1");
    $row = mysqli_fetch_array($user_query);
    echo '用户信息：<br>';
    echo '学号：', $SID, '<br>';
    echo '姓名：', $row['name'], '<br>';
    echo '注册时间：', $row['regTime'], '<br>';
    
    echo '<br> <a href="/user/myEdit.php">修改密码</a><br>';
    //需要注销入口
} else {
    echo "请先登陆哦";
    echo '你可以<a href="login.php">登录</a><br>';
    echo '也可以<a href="reg.php">注册</a><br>';
    echo '或者<a href="login.php">忘记密码了？</a><br>';
    echo '不不我要回到<a href="/index.php">主页</a><br>';
    exit;
    //可能需要跳转到登陆页面
}
?>
<a href="/index.php">主页</a><br>
<a href="/book/book.php">书库</a><br>
<a href="logout.php">注销</a>

<br>
<br>
<br>
<a href="/about/about.html"><h2>关于我们</h2></a> 
<p>计软义工协会@copy left by no body</p> <br>

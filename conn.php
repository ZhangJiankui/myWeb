<!--连接数据库-->
<?php
// 创建连接
$conn = new mysqli("localhost", "*****", "*****", "*****");
 
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 
//设置字符集为UTF8，统一使用utf8不然乱码
$conn->query("SET NAMES UTF8");
//echo "连接成功";
?>

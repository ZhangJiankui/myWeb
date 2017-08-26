<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//检测用户是否已经注册
$query_result = $conn->query("SELECT column_name(s) FROM table_name
                                WHERE column_name operator value");
if (!is_bool($query_result) ) { //如果查询失败会返回bool类型false
     while ($row = $query_result->fetch_assoc()) { //读取每行
         //$row就是每行的值
     }  
} else {
    //查询失败
}
if ($conn->query("UPDATE table_name SET column1=value, column2=value2,...
                    WHERE some_column=some_value ")) {
   //更改成功
} else {
    //更改失败
}

$check_query = $conn->query("select passwd from users where SID=$SID  limit 1");
if (!is_bool($check_query) && $row = $check_query->fetch_assoc()) {
    //如果密码正确
    if (strcmp($row['passwd'], MD5($passwdFormer)) == 0) {  //因为数据库里的密码是MD5过的
        //回写新密码              
     
    } else {
        //原密码错误
    }
} else { //如果读数据库失败
    
}
$passwdNew = MD5($passwdNew);
if ($conn->query("UPDATE users SET passwd='$passwdNew'  WHERE SID=$SID ")) {    //字符型要加''符号哦
    //修改成功
} else {
    //修改失败
}

if (isset($_SESSION['SID'])) {    //如果已经登陆
    $SID = $_SESSION['SID'];
    //$SID就是已经登陆的用户学号
} else {
    //还没登陆
}

 //查询书库表单获取书单
$books_query = $conn->query("select * from books");
if ($books_query->num_rows > 0) {
    //输出表单
    while ($row = $books_query->fetch_assoc()) {
        //输出每行
    }
} else {
    //0结果
}

$q = isset($_POST['q']) ? $_POST['q'] : '';   //$q是POST进来的书名数组
if (is_array($q)) { 
    //包含数据库连接文件
    require'D:\wamp64\www\conn.php';                 
    foreach ($q as $val) {  //对于每个书名
        //判断书名合法性
        //插入申请记录数据
        $sql = "INSERT INTO books_donate_log(SID,bookName,status,startTime )VALUES('$SID', '$val', '申请', now())";
        if ($conn->query($sql) == true) {
            //成功
        } else {
            //失败
        }                                  
    }
    $isOK = true;
}
if(!$isOK) {
    //错误信息
}

for ($i = 0; $i < count($ID); $i++) {  //对于每个书名
    //登记申请
    $sql = "INSERT INTO books_borrow_log(SID,bookName,bookID,status,startTime )VALUES('$SID', '$bookName[$i]', '$ID[$i]','申请', now())";
    if ($conn->query($sql) == true) {
        //成功
    } else {
        //失败
    }
    //更新该书的预约数
    $check_query = $conn->query("select orderNum from books where ID=$ID[$i]  limit 1");
    if (!is_bool($check_query) && $row = $check_query->fetch_assoc()) {
        $orderNum = $row['orderNum'] + 1;
        //写回预约数
        if ($conn->query("UPDATE books SET orderNum = $orderNum  WHERE ID =$ID[$i] ")) {
            //成功
        } else {
            //失败
        }
    } else {
        //错误
    }
}
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
<script src="/jquery/jquery-3.2.1.js">
</script>
<script>    //响应增加和减少的按钮
    var index = 1;  //初始的输入框数
    $(document).ready(function () {
        $("#add").click(function () {   //按了增加
            $("#book" + index).after("<br id=\"br" + (++index) + "\">" +
                    "<label id=\"label" + index + "\">第" + index + "本书：</label>" +
                    "<input id=\"book" + index + "\" type=\"text\" name=\"q[]\" >");
        });
        $("#delete").click(function () {    //按了减少
            if (index > 1) {
                $("#book" + index).remove();
                $("#label" + index).remove();
                $("#br" + index).remove();
                index--;
            } else {
                alert("不能再少了哦");
            }
        });
    });
</script>

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
                    <td><?php echo '<input type="checkbox" name="q[]" value="'.$row['ID'].'">'; ?></td>
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
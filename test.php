<!DOCTYPE html>
<html>
    <head>
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
    </head>
    <body>

        <h1>我的第一段 JavaScript</h1>

        <button id="add">再多一本</button>
        <button id="delete">嗯少一本</button>   <br><br><br>
        <form action="welcome.php" method="post">
            <label id="label1">第1本书：</label><input id="book1" type="text" name="q[]" >  <br id="br1">
          
            <br><br>
            <input type="submit" value="提交">
        </form>




    </body>
</html>

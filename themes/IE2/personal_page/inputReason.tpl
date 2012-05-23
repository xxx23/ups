<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- author: carlcarl -->
<html>
<head>
    <title>社群申請-輸入加入理由</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
    <link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../script/jquery-1.3.2.min.js"></script>
{literal}
    <script type="text/javascript">
        $(document).ready(function(){

        $('#reason').keyup(function(){
            if($('#reason').val() != '')
            {
               $('#submit').attr('disabled','');
            }
            else if($('#reason').val() == '')
            {
               $('#submit').attr('disabled','disabled');
            }

        });
        });
    </script>
{/literal}
</head>

<body>
    {*$begin_course_cd*}
    <h1>{$begin_course_name}-加入社群申請</h1>
    <h2>請輸入申請理由</h2>
    </br>
    <div class="describe">如欲加入此社群討論版，請<b style="color:red;">詳述</b>申請理由後送出申請，由該課程教師審核通過即可加入。</div>
    <form method="post" action="processJoin.php?course={$begin_course_cd}&name={$begin_course_name}">
        <div align="center">
        <textarea cols="70" rows="10" name="reason" id="reason"></textarea>
        <br />
        <input type="submit" value="送出" disabled="disabled" id="submit" />
        <input type="button" value="回上一頁" onclick="window.location.href='group.php'">
        </div>
   </form>

</body>
</html>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>觀看帳號</title>
<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/JavaScript">
<!--
{literal}
function doCheckAll(string){
        var nodes = document.getElementsByName(string);

        if(nodes.item(0).checked){
                for(var i=0; i < nodes.length ; i++)
                        nodes.item(i).checked = false;
        }else{
                for(var i=0; i < nodes.length ; i++)
                        nodes.item(i).checked = true;
        }
}

function doSubmit(flag){
        document.myform.submit();
        /*switch(id){
                case 'state':

                        break;
                case 'validate':

                        break;
                default:

                        break;
        }*/
}
{/literal}
-->
</script>
</head>

<body>
<h1>編輯不核准原因</h1>
  <!-- 內容說明
<p class="intro">
說明：<br />
</p>
 -->
  <!--功能部分 -->
  <form method="post" name="myform" action="./adm_check_select_course_stu.php?action=update_reason&begin_course_cd={$begin_course_cd}&personal_id={$personal_id}">
  <table class="datatable">
    <tr>
      <th>不核准原因</th>
    </tr>
    <tr>
      <td><textarea id ="note" name="note">{$note_data}</textarea></td>
    </tr>

  </table>
	<input type="button" value="確認" onClick="doSubmit(1)" />
	<input type="button" value="返回" onClick="location.href='./adm_check_select_course_stu.php?begin_course_cd={$begin_course_cd}'" />
  </form>
</body>
</html>

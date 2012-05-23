<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>課程管理頁面</title>

<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />

{literal}
<script type="text/JavaScript">
function Check_create()
{	
	if(document.getElementById("create_course_name").value == ""){
		alert("請輸入課程名稱!");
		return false;
	}
}
</script>
{/literal}
</head>
<body id="tabA">

<div class="inner_contentA" id="inner_contentA">
    <form name="create_course" action="course_manage_personal.php" method="post">
      <h1>新增課程大綱</h1>
      請輸入以下資料：
      <ul>
       	<li>課程名稱：
          <input type="text" name="course_name" id="create_course_name">
        </li>
        <li>開放旁聽：
          <select name="need_validate_select" id="create_need_validate_select">
	  {html_options values=$need_validate_select_options_values selected=$need_validate_select_options_selected output=$need_validate_select_options_output}
          </select>
        </li>
        <li>課程科目時程單位：
          <select name="schedule_unit" id="create_schedule_unit">
          {html_options values=$schedule_unit_options_values selected=$schedule_unit_options_selected output=$schedule_unit_options_output}  
          </select>
        </li>
      </ul>
      <p class="al-left">
        <span class="msg">{$create_status}</span><input name="submit_create" type="submit" class="btn" onClick="return Check_create();" value="新增">
    </form>

    <h1>編輯課程大綱</h1> 
    <form action="modify_personal_course.php" name="modify_course" id="modify_course" method="post">
    	<select name="course_list" id="course_list">
     	{html_options values=$course_list_options_values selected=$course_list_options_selected output=$course_list_options_output}
    	</select>
	<input name="submit_modify" type="submit" class="btn" value="編輯" />
    </form>
    <br/>
    <h1>刪除課程大綱</h1>
    <form action="delete_personal_course.php" name="delete_course" id="delete_course" method="post">
    <select name="course_delete_list" id="course_delete_list">
     	{html_options values=$course_list_options_values selected=$course_list_options_selected output=$course_list_options_output}
    </select>
    <input name="submit_delete" type="submit" class="btn" value="刪除" onclick="return confirm('您確認要刪除此課程?');">
    </form>
</div>
</body>
</html>

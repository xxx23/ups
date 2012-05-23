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
<script type="text/javascript" src="{$tpl_path}/script/default.js"></script>

<script type="text/javaScript">
<!--
{literal}
function display(option){
	document.getElementById("inner_contentA").style.display="none";
	document.getElementById("inner_contentB").style.display="none";
	document.getElementById("inner_contentC").style.display="none";
	if(option == 1){
		document.getElementById("inner_contentA").style.display = "";
		document.getElementsByTagName("body")[0].id = "tabA";
	}
	else if(option == 2){
		document.getElementById("inner_contentB").style.display = "";
		document.getElementsByTagName("body")[0].id = "tabB";
	}
	else{
		document.getElementById("inner_contentC").style.display = "";
		document.getElementsByTagName("body")[0].id = "tabC";
	}
}

function Check_create()
{	
	if(document.getElementById("create_course_name").value == ""){
		alert("請輸入課程名稱!");
		return false;
	}
}

function doResizeIframe(name)
{
	var frame;
	var frame2;
	var frame3;
	frame = document.getElementById(name);
	if(frame)
		ResizeIframe(frame);
	if(window.parent)
	{
		frame2 = window.parent.document.getElementById('information');
		frame3 = window.parent.document.getElementById('other');
	}

	if(frame2)
		ResizeIframe2(frame2,frame.contentWindow.document.body.scrollWidth,frame.contentWindow.document.body.scrollHeight+160);
	if(frame3)
		ResizeIframe2(frame3,frame.contentWindow.document.body.scrollWidth,frame.contentWindow.document.body.scrollHeight+160);
}
{/literal}
</script>
</head>
<body id="tabA">
<div class="tab">
  <ul id="tabnav">
    <li class="tabA" onClick="display(1)">編輯課程資訊</li>
    <li class="tabB" onClick="display(2);doResizeIframe('tea_course_intro');">課程大綱</li>
    <li class="tabC" onClick="display(3);doResizeIframe('tea_course_intro2');">選課須知</li>
    <li class="tabD"><a href="course_manage_personal.php">我的課程資訊</a></li>
  </ul>
</div>
<div class="inner_contentA" id="inner_contentA">
    <form name="create_course" action="modify_personal_course.php" method="post">
      <h1>編輯課程資訊</h1>
      請輸入以下資料：
      <ul>
       	<li>課程名稱：
          <input type="text" name="course_name" id="create_course_name" value="{$course_name}">
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
        <span class="msg">{$modify_status}</span><input name="submit_modify2" type="submit" class="btn" onClick="return Check_create();" value="確認修改">
	<input name="course_cd" id="course_cd" type="hidden" value="{$course_cd}" />
    </form>
</div>

<div class="inner_contentB" id="inner_contentB" style="display:none;">
    <h1>課程大網</h1>	
    <iframe frameborder="0" height="20000" name="tea_course_intro" id="tea_course_intro" src="./tea_course_intro.php{$op_course_cd}"></iframe>
</div>

<div class="inner_contentC" id="inner_contentC" style="display:none;">
    <h1>選課須知</h1>
    <iframe frameborder="0" height="20000" name="tea_course_intro2" id="tea_course_intro2" src="./tea_course_intro2.php{$op_course_cd}"></iframe>
</div>
</body>
</html>

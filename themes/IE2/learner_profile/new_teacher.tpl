<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="{$tpl_path}/css/font_style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/layout.css" rel="stylesheet" type="text/css" />
<title>新增教師</title>
<script src="../script/prototype.js" type="text/javascript" ></script>
<script language="JavaScript" type="text/JavaScript">
<!--
{literal}

var serverAddress = 'update_textarea.php';

function init(){

	document.getElementById('teacher_name').setFocus;
}



{/literal}
-->
</script>
</head>

<body onLoad="init();" >
<h1>新增教師
</h1>
<form method="post" action="new_teacher.php?action=new">
<table class="datatable">
	<td width="10%">帳號</td>
	<td>
		<input type="text" id="teacher_name" name="teacher_name" value="{$valueOfTeacher_name}" />
<!--		<span id='t_loding'><img src=""></img></span>-->
	</td>
</tr>
<tr>
	<td width="10%">密碼</td>
	<td>
		<input type="text" name="password" value="{$valueOfPasseord}" />(請至少輸入八碼)
		<!--<span id='t_loding'><img src=""></img></span>-->
	</td>
</tr>
<!--
<tr>
	<td width="10%">再次確認</td>
	<td>
		<input type="password" name="password_check" value="{$valueOfPasseord}" />
		<span id='t_loding'><img src=""></img></span>
	</td>
</tr>
-->
</table>
<p class="al-left"><input type="submit" value="確定">
<input type="reset" value="重設"><input type="button" value="返回" onclick="document.location='list_teacher.php';return false;"></p>
</form>
</body>
</html>

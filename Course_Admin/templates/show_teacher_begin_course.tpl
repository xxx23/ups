<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
<script src="../script/prototype.js" type="text/javascript" ></script>
<script language="javascript">
<!--
{literal}
function checkBeginCourse(course_cd, begin_course_cd){
	if(confirm("是否確認[開課]")){
		window.location="../Course/check_begin_intro.php?begin_course_cd="+ begin_course_cd +"&course_cd="+course_cd;
	}else{
		alert("放棄確認");
	}
}

{/literal}
-->
</script>
<title>觀看開課情形</title>
</head>

<body class="ifr">
<!-- 內容說明 -->
<p class="intro">
操作說明：<br />
<span class="imp">新進課程</span>：剛開設尚未做設定的課程。<br />
按下確認，可以輸入<span class="imp">課程大綱</span>與<span class="imp">課程進度</span>。

</p>


<!-- 標題 -->
<h1>課程管理</h1>

<!--功能部分 -->
<!--新進課程-->
<font color="#FF0000">新進課程</font>
<table border="1">
	<tr>
		<td>課程編號</td><td>開課單位</td><td>開課名稱</td><td>授課教師</td><td>開課確認</td>
	</tr>
	{foreach from=$new_course_data item=course}
	<tr>
		<td>{$course.inner_course_cd}</td><td>{$course.unit_name}</td><td>{$course.begin_course_name}</td>
		<td>{$course.personal_name}</td>
		<!--<td><a href="{$course.code_path}?begin_course_cd={$course.begin_course_cd}" >確認</a></td>-->
		<td><input type="button" name="checkButton" value="確認" onClick="checkBeginCourse({$course.course_cd}, {$course.begin_course_cd});"></td>
	</tr>	
	{/foreach}
</table>
<br />
</body>
</html>

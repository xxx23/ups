<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="javascript">
<!--
{literal}
var currentPath = "../";
function goToCreateCourse(obj){
	var courseType = obj.options[obj.selectedIndex].value;
	switch(courseType){
		case 'normal' :
			var url = currentPath + "Course_Admin/tea_create_course.php";
			break;
		case 'nknu':
			var url = currentPath + "Course_Admin/tea_create_nknu_course.php";
			break;
		default:
			break;	
	}
	document.location = url;
}
{/literal}
-->
</script>

<title>確定開課</title>
</head>

<body>
<!--標題-->
<center>教師確定開課</center>
<!--內容說明-->
<div>
<br />
操作說明：<br />
	這是<font color="#0000FF">課程管理者</font>新開設給您的課程，你可以下列敘述<font color="#0000FF">完成開課流程</font>。<br />
	一. 填寫課程大綱 (這可以讓學生了解這門課的內容。)<br />
	二. 填寫課程進度 <br />
	PS : 步驟 一, 二 填寫好之後都還可以修改。<br />
	<br />
</div>
<!--功能-->
<table>
<tr>
	<td>步驟一</td>
	<td></td>
</tr>
<tr>
	<td>步驟二</td>
	<td></td>	
</tr>
</table>
</body>
</html>

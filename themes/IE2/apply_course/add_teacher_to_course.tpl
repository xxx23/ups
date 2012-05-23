<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>新增教師到開課</title>
<link href="{$tpl_path}/css/font_style_course.css" rel="stylesheet" type="text/css" />
</head>
<body>
<!-- 標題 -->
<h1>課程的資料</h1>
<!-- 內容說明 -->
<div >
<br />

</div>
<!--功能部分 -->
<div class="searchbar" style="margin-left:50px;width:85%;padding:20px;" ><table class="datatable" style="width:80%;margin-left:25px;">
<tr >
	<th width="30%" height="30">課程名稱</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$begin_course_name}</td>
</tr>
<tr>
	<th height="30">開課單位</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$begin_unit_cd}</td>
</tr>
<tr>
	<th height="30">對應內部課程號</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$inner_course_cd}</td>
</tr>
<tr>
	<th height="30">課程性質</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$property_name}</td>
<tr>
{if $attribute == 0} <!-- 表示是自學式的課程 -->
<tr>
	<th height="30">修課期限</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$month}</td>
</tr>
<!--
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>課程時數</th><td>{$take_hour}小時</td>
</tr>
-->
<tr>
	<th height="30">認証時數</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$certify}小時</td>
</tr>
<!--
<tr>
	<th><img src="{$tpl_path}/images/th_head.png" alt="" width="12" height="54" align="absmiddle"/>學習費用</th><td>{$charge}元</td>
</tr>
-->
<tr>
	<th height="30">評量標準(總分)</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$criteria_total}分</td>
</tr>
<tr>
	<th height="30">教材閱讀時數</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$criteria_content_hour}</td>
</tr>
{/if}
{if $attribute == 1} <!-- 表示是教導式的課程 -->
<tr>
	<th height="30">開課開始日期</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$d_course_begin}</td>
</tr>
<tr>
	<th height="30">開課結束日期</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$d_course_end}</td>
</tr>
<tr>
	<th height="30">開課公開日期</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$d_public_day}</td>
</tr>
<tr>
	<th height="30">選課開始日期</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$d_select_begin}</td>
</tr>
<tr>
	<th height="30">選課結束日期</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$d_select_end}</td>
</tr>
<tr>
	<th height="30">開課所屬的學年</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$course_year}</td>
</tr>
<tr>
	<th height="30">開課所屬的學期</th>
	<td height="30" valign="middle" bgcolor="#FFFFFF">{$course_session}</td>
</tr>
{/if}
</table>
</div>


<hr width="100%" style="color: #fff; background-color: #fff; border: 1px dotted #6699FF; border-style: none none dotted;">

{if !$has_teacher }

<form method="post" action="add_teacher_to_course.php?action=addTeacher">
<input type="hidden" name="course_cd" value="{$course_cd}" />
<input type="hidden" name="begin_course_cd" value="{$begin_course_cd}" />
<h1>加入授課教師</h1>
	授課教師帳號：<input type="text" name="teacher_account" value="{$teacher_account}" />
	<input type="submit" value="確定送出">
</form>


<div class="intro">
  <ol>
    <li><div id="message" style="color:#0000FF">{$message}</div></li>
    <li><div id="err_message" style="color:#FF0000;">{$err_message}</div></li>
  </ol>
</div>

<br/>
<br/>
{/if}

<form action="./begin_course_mail.php" method="get">
<h1>授課教師</h1>
<table class="datatable">
<input type="hidden" name="begin_course_cd" value="{$begin_course_cd}" />
<tr>
	<th><div align="center">人員編號</div></th>
	<th><div align="center">帳號</div></th>
	<th><div align="center">教師名稱</div></th>
	<th><div align="center">刪除</div></th>
</tr>
{foreach from=$teacher_data item=teacher}
<tr>
	<input type="hidden" name="personal_id[]" value="{$teacher.personal_id}" />
	<td><div align="center">{$teacher.personal_id}</div></td>
	<td><div align="center">{$teacher.login_id}</div></td>
	<td><div align="center">{$teacher.personal_name}</div></td>
	<td><div align="center"><a href="./add_teacher_to_course.php?action=deleteTeacher&teacher_cd={$teacher.personal_id}&course_cd={$course_cd}&begin_course_cd={$begin_course_cd}"><img src="{$tpl_path}/images/apply_course/314.gif" alt="刪除" border="0px"></a></div></td>
</tr>
{/foreach}
</table>
</form>



<br/>
<p style="text-align:right">
	<input class="btn" type="button" value="返回課程列表" onClick="location.href='begin_course_list.php';" />
</p>
<br/>
<br/>
<br/>
<br/>
<br/>

</body>
</html>

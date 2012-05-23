<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
<link href="{$tpl_path}/css/table_news.css" rel="stylesheet" type="text/css">
<script src="../script/prototype.js" type="text/javascript" ></script>
<script language="javascript">
<!--
{literal}

{/literal}
-->
</script>
<title>教師在職進修登錄</title>
</head>

<body>
<!-- 標題 -->
<center>教師在職進修登錄</center>
<!-- 內容說明 -->
<div>
<br />
操作說明：<br />
	<font color="#FF0000">尚無</font><br />
	<br />
</div>
<!--功能部分 -->
<form method="post" action="">
<table class="datatable">
<tr>
	<th>研習名稱</th>
	<td><input type="text" name="begin_course_name" value="{$begin_course_name}"></td>
</tr>
<tr>
	<td>依據文號</td>
	<td><input type="text" name="allowno" value="{$allowno}"></td>
</tr>
<tr>
	<td>課程內容大綱</td>
	<td>{$course_intro}</td>
</tr>
<tr>
	<td>上課日期</td>
	<td>{$d_course_begin}到{$d_course_end}</td>
</tr>
<tr>
	<td>報名日期</td>
	<td>{$d_select_begin}到{$d_select_end}</td>
</tr>
<tr>
	<td>課程時段</td>
	<td>
	{html_checkboxes name="timeSet" values=$timeSet_ids checked=$timeSet_id output=$timeSet_names separator=" "}
	</td>
</tr>
<tr>
	<td>詳細描述</td>
	<td>??</td>
</tr>
<tr>
	<td>班別性質</td>
	<td>
		<select name="coursekind">
		{html_options values=$coursekind_ids selected=$coursekind_id output=$coursekind_names}
		</select>
	</td>
</tr>
<tr>
	<td>課程性質</td>
	<td>
	<table>
		<tr>
			<td> 1.
			<select name="course_classify_1" id="course_classify_1" onchange="changeSelect(this.selectedIndex, this.id, 1);">
			{html_options values=$course_classify_1_ids selected=$course_classify_1_id output=$course_classify_1_names}
			</select>
			</td>
			<td> 2.
			<select name="course_classify_2" id="course_classify_2" onchange="changeSelect(this.selectedIndex, this.id, 2);">
			{html_options values=$course_classify_2_ids selected=$course_classify_2_id output=$course_classify_2_names}
			</select>				
			</td>
			<td> 3.
			<select name="course_classify_3" id="course_classify_3" onchange="changeSelect(this.selectedIndex, this.id, 3);">
			{html_options values=$course_classify_3_ids selected=$course_classify_3_id output=$course_classify_3_names}
			</select>				
			</td>
			<td> 4.
			<select name="course_classify_4" id="course_classify_4">
			{html_options values=$course_classify_4_ids selected=$course_classify_4_id output=$course_classify_4_names}
			</select>				
			</td>								
		</tr>
	</table>	
	</td>
</tr>
<tr>
	<td>研習時數 / 學分數</td>
	<td></td>
</tr>
<tr>
	<td>參加對象</td>
	<td>
	{$course_classify_1}
	<!--
		<select name="course_classify_1" id="course_classify_1" onchange="changeSelect(this.selectedIndex, this.id, 1);">
		{html_options values=$course_classify_1_ids selected=$course_classify_1_id output=$course_classify_1_names}
		</select>	-->
	</td>
</tr>
<tr>
	<td>學員繳費方式</td>
	<td>
		<select name="charge_type">
		{html_options values=$charge_type_ids selected=$charge_type_id output=$charge_type_names}
		</select>	
	</td>
</tr>
<tr>
	<td>繳費金額</td>
	<td>
	<input type="text" name="charge" value="{$charge}">
	</td>
</tr>
<tr>
	<td>開班班數</td>
	<td>??</td>
</tr>
<tr>
	<td>各班人數</td>
	<td>??</td>
</tr>
<tr>
	<td>承  辦  人</td>
	<td>??</td>
</tr>
<tr>
	<td>學校資訊</td>
	<td>??</td>
</tr>
</table>
<input type="submit" value="確定修改" />
<input type="button" value="返回" />
</form>
</body>
</html>
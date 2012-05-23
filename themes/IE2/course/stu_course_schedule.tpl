<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>{$course_name}的課程大綱</title>
<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />

<!--<script type="text/javascript" src="{$tpl_path}/script/drag.js"></script>-->
<!--<script src="../script/prototype.js" type="text/javascript" ></script>-->
<script language="JavaScript" type="text/JavaScript">
<!--
{literal}
{/literal}
-->
</script>
</head>
<body onmousemove="moveit();" onmouseup="stopdrag();" >
<!--<p class="address">目前所在位置: <a href="#">首頁</a> &gt;&gt; <a href="#">課程</a> &gt;&gt; <a href="#">課程說明</a> &gt;&gt; <a href="#">課程進度</a></p>
-->
<!-- 標題 -->
<h1>{$course_name}的課程進度表</h1>

<!--課程進度 -->
<table id="course_schedule" class="datatable">
<thead>
<tr>
	<th id="courseUnit">期數({$schedule_unit})</th>
	<th>日期</th>
	<th>內容</th>
	<th>上課方式</th>
	<th>授課教師</th>
	<th>教學活動</th>
</tr>
</thead>
<tbody>
{foreach from=$schedule_data item=schedule}
<tr class="{cycle values='tr2, '}">
	<td>第 {$schedule.schedule_index} {$schedule_unit}</td>
	<td>{$schedule.course_schedule_day}</td>
	<td>{$schedule.subject}</td>
	<td>{$schedule.course_type}</td>
	<td>{$schedule.teacher_name}</td>
	<td>{$schedule.course_activity}</td>
</tr>
{/foreach}
</tbody>
</table>


</body>
</html>
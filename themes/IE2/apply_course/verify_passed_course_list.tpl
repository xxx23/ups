<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>待審課程列表</title>
<link href="{$tpl_path}/css/font_style_course.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content_course.css" rel="stylesheet" type="text/css" />
</head>
<body>

<h1>已審核通過課程列表</h1>

<table class="datatable">
<thead>
<tr>
	<th style="width:10%; text-align:center">課程編號</th>
	<th style="width:15%; text-align:center">開課單位</th>
	<th style="width:15%; text-align:center">課程屬性</th>
	<th style="width:25%; text-align:center">開課名稱</th>
	<th style="width:20%;text-align:center">授課教師</th>
	<th style="width:20%;text-align:center">教材名稱</th>
</tr>
</thead>
{foreach from=$verify_course_data item=course}
<tr>
	<td style="text-align:center;">{$course.inner_course_cd}</td>
	<td style="text-align:center;">{$course.unit_name}</td>
	<td style="text-align:center;">{if $course.attribute eq 0}自學式{else}教導式{/if}</td>
	<td style="text-align:center;"><a href="view_course_detail.php?begin_course_cd={$course.begin_course_cd}">{$course.begin_course_name}</a></td>
	<td style="text-align:center;">{$course.personal_name}</td>
	<td style="text-align:center;">{$course.content_name}</td>
</tr>	

{foreachelse}

	<td colspan="7" style="text-align:center;"><img src="{$tpl_path}/images/apply_course/icon3.png" style="border:dashed 1px #ccc;background:#eee;">目前沒有課程。

{/foreach}
</table>

</body>
</html>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>待審課程列表</title>
<link href="{$tpl_path}/css/font_style_course.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_path}/css/content_course.css" rel="stylesheet" type="text/css" />
<script type="text/javascript"><!--
{literal}

function verfiyCourse(this_btn, begin_course_cd) {
	location.href='verify_course_detail.php?begin_course_cd=' + begin_course_cd ;
}

{/literal}
--></script>
</head>
<body>
{***************** 待審課程 *********************}

<h1>待審核課程列表</h1>

<table class="datatable">
<tr>
	<th style="text-align:center">課程編號</th>
	<th style="text-align:center">開課單位</th>
	<th style="text-align:center">課程屬性</th>
	<th style="text-align:center">開課名稱</th>
	<th style="text-align:center">授課教師</th>
	<th style="text-align:center">教材名稱</th>
	<th style="text-align:center">審核</th>
</tr>

{foreach from=$verify_course_data item=course}
<tr>
	<td style="text-align:center;">{$course.inner_course_cd}</td>
	<td style="text-align:center;">{$course.unit_name}</td>
	<td style="text-align:center;">{if $course.attribute eq 0}自學式{else}教導式{/if}</td>
	<td style="text-align:center;">{$course.begin_course_name}</td>
	<td style="text-align:center;">{$course.personal_name}</td>
	<td style="text-align:center;">{$course.content_name}</td>
	<td style="text-align:center;">
		<input class="btn" type="button" name="checkButton" value="審核"  onClick="verfiyCourse(this, {$course.begin_course_cd});">
	</td>
</tr>	

{foreachelse}

	<td colspan="7" style="text-align:center;"><img src="{$tpl_path}/images/apply_course/icon3.png" style="border:dashed 1px #ccc;background:#eee;">貴單位目前沒有課程需要確認。

{/foreach}
</table>

</body>
</html>

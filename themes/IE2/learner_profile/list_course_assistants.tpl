<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<script type="text/javascript" src="{$webroot}script/default.js"></script>

	<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
	<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
</head>

<body class="ifr">
	<h1>助教查詢與修改</h1>
	<p class="intro">
	此處為本課程助教列表，移除助教功能並非刪除此助教帳號，僅是將其從本課程中移除。
	</p>
	{if $done == 1}<center><strong style="color:red;">助教帳號修改完成</strong></center>{/if}
	<form action="manage_course_assistant.php" method="GET" name="delete">
	<ul id="tabnav">
		<li><a href="manage_course_assistant.php?option=view_modify">新增助教</a></li>
		<li><a href="manage_assistant.php?option=view_set">設定助教權限</a></li>
		<li><a href="manage_assistant.php?option=list_assistants">助教帳號列表</a></li>
	</ul>
	<input type="hidden" name="option" value="remove"/>
	<table class="datatable"><tbody>
		<tr>
			<th style="text-align:center;"><input type="checkbox" onclick="clickAll('delete', this);"/></th>
			<th>助教姓名</th>
			<th>助教帳號</th>
			<!-- <th>助教密碼</th> -->
			<th>助教E-mail</th>
			<th>助教連絡電話</th>
		</tr>
		{foreach from=$data item=entry}
		<tr class="{cycle values=" ,tr2"}">
			<td style="text-align:center;"><input type="checkbox" name="id[]" value="{$entry.personal_id}"/></td>
			<td><a href="manage_course_assistant.php?option=view_modify&login_id={$entry.login_id}">{$entry.personal_name|escape}</a></td>
			<td>{$entry.login_id}</td>
			<!-- <td>{$entry.pass}</td> -->
			<td>{$entry.email}</td>
			<td>{$entry.tel}</td>
		</tr>
		{foreachelse}
		<tr><td colspan="6" style="text-align:center;">目前沒有任何助教資料</td></tr>
		{/foreach}
	</tbody></table>
	<input type="reset" class="btn" value="清除資料"/><input type="submit" class="btn" value="移除助教"/>
	</form>
</body>
</html>

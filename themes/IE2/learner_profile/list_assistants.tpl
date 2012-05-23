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
	<h1>助教帳號列表</h1>
	<ul id="tabnav">
		<li><a href="manage_course_assistant.php?option=list_assistants">助教查詢與修改</a></li>
	</ul>
	<table class="datatable"><tbody>
		<tr>
			<th>助教姓名</th>
			<th>助教帳號</th>
			<th>助教E-mail</th>
			<th>助教連絡電話</th>
		</tr>
		{foreach from=$data item=entry}
		<tr class="{cycle values=" ,tr2"}">
			<td>{$entry.personal_name}</td>
			<td>{$entry.login_id}</td>
			<td>{$entry.email}</td>
			<td>{$entry.tel}</td>
		</tr>
		{foreachelse}
		<tr><td colspan="6" style="text-align:center;">目前沒有任何助教資料</td></tr>
		{/foreach}
	</tbody></table>
</body>
</html>

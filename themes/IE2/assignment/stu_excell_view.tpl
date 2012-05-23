<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

		<link href="{$tpl_path}/css/tabs.css" rel="stylesheet" type="text/css" />
		<link href="{$tpl_path}/css/content.css" rel="stylesheet" type="text/css" />
		<link href="{$tpl_path}/css/table.css" rel="stylesheet" type="text/css" />
		<link href="{$tpl_path}/css/form.css" rel="stylesheet" type="text/css" />
	</head>

	<body class="ifr" style="text-align:center;">
		<table class="datatable" style="width:75%;"><tbody>
			<tr>
				<th>學生姓名</th><th>優良作業</th>
			</tr>
			{foreach from=$works item=work}
			<tr class="{cycle values=" ,tr2"}">
				<td>{$work.personal_name}</td>
				<td><a href="stu_excellent.php?option=list_single&homework_no={$work.homework_no}&pid={$work.personal_id}">優良作業</a></td>
			</tr>
			{foreachelse}
			<tr><td colspan="2" style="text-align:center;">目前無資料</td></tr>
			{/foreach}
		</tbody></table>
	</body>
	<p class="al-left"><a href="javascript:history.back();"><img src="{$tpl_path}/images/icon/return.gif"/>返回線上作業列表</a></p>
</html>
